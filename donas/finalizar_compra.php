<?php 
session_start();

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<p>Tu carrito está vacío. <a href='productos.php'>Ver productos</a></p>";
    exit;
}

$error = '';
$nombre = $email = $direccion = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $nombre = trim($_POST['nombre'] ?? ''); 
    $email = trim($_POST['email'] ?? ''); 
    $direccion = trim($_POST['direccion'] ?? ''); 
    $metodo_pago = trim($_POST['metodo_pago'] ?? '');

    if (!$nombre || !$email || !$direccion || !$metodo_pago) {
        $error = "Completa todos los campos y selecciona un método de pago.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Correo electrónico inválido.";
    } else {
        $conexion = new mysqli("localhost", "root", "", "donas");
        if ($conexion->connect_error) die("Error de conexión: " . $conexion->connect_error);
        $conexion->set_charset("utf8");

        $stmt = $conexion->prepare("SELECT id FROM clientes WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            $stmt->close();
            $stmt = $conexion->prepare("INSERT INTO clientes (nombre, email, direccion) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $email, $direccion);
            $stmt->execute();
            $cliente_id = $stmt->insert_id;
            $stmt->close();
        } else {
            $stmt->bind_result($cliente_id);
            $stmt->fetch();
            $stmt->close();
        }

        $total = 0;
        foreach ($_SESSION['carrito'] as $producto) {
            $total += $producto['precio'] * ($producto['cantidad'] ?? 1);
        }

        $fecha = date("Y-m-d H:i:s");
        $stmt = $conexion->prepare("INSERT INTO pedidos (usuario_id, total, fecha, metodo_pago) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $cliente_id, $total, $fecha, $metodo_pago);
        $stmt->execute();
        $pedido_id = $stmt->insert_id;
        $stmt->close();

        $stmt = $conexion->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
        foreach ($_SESSION['carrito'] as $producto) {
            $stmt->bind_param("iiid", $pedido_id, intval($producto['id']), intval($producto['cantidad'] ?? 1), floatval($producto['precio']));
            $stmt->execute();
        }
        $stmt->close();

        $conexion->close();
        unset($_SESSION['carrito']);
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Gracias por tu compra</title>
            <link rel="stylesheet" href="estilos_fc.css">
        </head>
        <body>
            <div class="agradecimiento">
                <h2>¡Gracias por tu compra, <?= htmlspecialchars($nombre) ?>!</h2>
                <p>Te enviaremos confirmación a <strong><?= htmlspecialchars($email) ?></strong>.</p>
                <a href="productos.php">Volver a la tienda</a>
                <p>Serás redirigido al inicio en unos segundos...</p>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = 'productos.php';
                }, 4000);
            </script>
        </body>
        </html>
        <?php
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="estilos_fc.css">
    <style>
        .contenedor-principal {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 40px;
            margin-top: 50px;
        }
        .metodo-pago-container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .metodo-pago-container h2 {
            font-size: 20px;
            margin-bottom: 15px;
            text-align: center;
            color: #333;
        }
        .metodo-pago-container label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 600;
        }
        .metodo-pago-container select,
        .metodo-pago-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="contenedor-principal">
        <div class="form-container">
            <h1>Finalizar Compra</h1>
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post" name="formCompra" onsubmit="return validarFormulario()">
                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($nombre) ?>">

                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email) ?>">

                <label for="direccion">Dirección de envío:</label>
                <textarea id="direccion" name="direccion" required><?= htmlspecialchars($direccion) ?></textarea>

                <input type="hidden" name="metodo_pago" id="metodo_pago_input">

                <button type="submit" id="btnConfirmar">Confirmar compra</button>
            </form>
        </div>

        <div class="metodo-pago-container">
            <h2>Método de Pago</h2>
            <label for="tipo_pago">Selecciona:</label>
            <select id="tipo_pago">
                <option value="">-- Selecciona --</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="paypal">PayPal</option>
                <option value="efectivo">Efectivo</option>
            </select>

            <div id="detalles_pago"></div>
        </div>
    </div>

    <script>
        const tipoPago = document.getElementById("tipo_pago");
        const detallesPago = document.getElementById("detalles_pago");
        const metodoInput = document.getElementById("metodo_pago_input");
        const btnConfirmar = document.getElementById("btnConfirmar");

        tipoPago.addEventListener("change", function() {
            const valor = this.value;
            metodoInput.value = valor;
            detallesPago.innerHTML = "";

            if (valor === "tarjeta") {
                detallesPago.innerHTML = `
                    <label>Número de tarjeta:</label>
                    <input type="text" id="tarjeta" required>
                    <label>Fecha vencimiento:</label>
                    <input type="month" id="vencimiento" required>
                    <label>CVC:</label>
                    <input type="text" id="cvc" required>
                `;
            } else if (valor === "paypal") {
                detallesPago.innerHTML = `
                    <label>Correo PayPal:</label>
                    <input type="email" id="correo_paypal" required>
                `;
            } else if (valor === "efectivo") {
                detallesPago.innerHTML = `
                    <p>Pagas al recibir el pedido.</p>
                `;
            }
        });

        function validarFormulario() {
            if (!document.getElementById("metodo_pago_input").value) {
                alert("Selecciona un método de pago.");
                return false;
            }
            if (tipoPago.value === "tarjeta") {
                if (!document.getElementById("tarjeta").value.trim() ||
                    !document.getElementById("vencimiento").value ||
                    !document.getElementById("cvc").value.trim()) {
                    alert("Completa los datos de la tarjeta.");
                    return false;
                }
            }
            if (tipoPago.value === "paypal") {
                const correo = document.getElementById("correo_paypal").value.trim();
                if (!correo || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
                    alert("Ingresa un correo válido de PayPal.");
                    return false;
                }
            }
            return true;
        }
    </script>
</body>
</html>
