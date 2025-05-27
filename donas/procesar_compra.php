<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "donas");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar que el carrito no esté vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "Tu carrito está vacío. <a href='productos.php'>Ver productos</a>";
    exit;
}

// Recibir y sanitizar datos del formulario
$nombre = $conexion->real_escape_string(trim($_POST['nombre'] ?? ''));
$email = $conexion->real_escape_string(trim($_POST['email'] ?? ''));
$direccion = $conexion->real_escape_string(trim($_POST['direccion'] ?? ''));

// Validar campos
if (!$nombre || !$email || !$direccion) {
    echo "Por favor completa todos los campos. <a href='carrito.php'>Volver</a>";
    exit;
}

// Insertar pedido
$sqlPedido = "INSERT INTO pedidos (nombre, email, direccion) VALUES ('$nombre', '$email', '$direccion')";
if (!$conexion->query($sqlPedido)) {
    echo "Error al guardar el pedido: " . $conexion->error;
    exit;
}
$pedido_id = $conexion->insert_id;

// Insertar detalles del pedido
foreach ($_SESSION['carrito'] as $producto_id => $producto) {
    $cantidad = intval($producto['cantidad']);
    $precio = floatval($producto['precio']);
    $sqlDetalle = "INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio) VALUES ($pedido_id, $producto_id, $cantidad, $precio)";
    if (!$conexion->query($sqlDetalle)) {
        echo "Error al guardar detalles: " . $conexion->error;
        exit;
    }
}

// Preparar correo de confirmación
$to = $email;
$subject = "Confirmación de tu compra en Tienda de Donas";

$message = "Hola $nombre,\n\nGracias por tu compra en nuestra Tienda de Donas.\n\nDetalles del pedido:\n";

foreach ($_SESSION['carrito'] as $producto_id => $producto) {
    $message .= "- " . $producto['nombre'] . " x " . $producto['cantidad'] . " = $" . number_format($producto['precio'] * $producto['cantidad'], 2) . "\n";
}

$message .= "\nDirección de envío:\n$direccion\n\n";
$message .= "¡Esperamos que disfrutes tus donas!\nTienda de Donas";

$headers = "From: tienda@tudominio.com\r\n";  // Cambia este correo

// Enviar correo
mail($to, $subject, $message, $headers);

// Vaciar carrito
unset($_SESSION['carrito']);

$conexion->close();

echo "<h2>Gracias por tu compra, " . htmlspecialchars($nombre) . ".</h2>";
echo "<p>Te enviaremos un correo de confirmación a " . htmlspecialchars($email) . ".</p>";
echo "<a href='productos.php'>Volver a la tienda</a>";
?>
