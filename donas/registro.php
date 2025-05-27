<?php
session_start(); 

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "donas");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $nombre      = $_POST["nombre"];
    $email       = $_POST["email"];
    $contraseña  = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);

    // 1) Verificar si el email ya existe
    $check = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $mensaje = "❌ Ese correo ya está registrado. ¿Olvidaste tu contraseña?";
    } else {
        // 2) Insertar usuario
        $sql  = "INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sss", $nombre, $email, $contraseña);

        if ($stmt->execute()) {
            // Guardar en sesión para simular login
            $_SESSION['usuario_id']     = $stmt->insert_id;
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['usuario_email']  = $email;

            // Redirigir al index.php (ya logueado)
            header("Location: productos.php");
            exit;
        } else {
            // Manejo de clave duplicada por si hay carrera de inserciones
            if ($conexion->errno === 1062) {
                $mensaje = "❌ Ese correo ya está registrado. Intenta iniciar sesión.";
            } else {
                $mensaje = "❌ Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }

    $check->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="estilos_registro.css">
</head>
<body>
    <header class="header">
        <div class="header-logo">
            <a href="productos.php">DUNKIN'</a>
        </div>
    </header>
    <div class="registro-container">
        <h1>📝 Registrarse</h1>
        <form method="POST" action="">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Contraseña:</label>
            <input type="password" name="contraseña" required>

            <button type="submit">Registrarse</button>
        </form>

        <?php if ($mensaje): ?>
            <p class="mensaje"><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
        <a href="productos.php">← Volver al inicio</a>
    </div>
    <script>
        const passwordInput = document.getElementById('contraseña');
        const togglePasswordButton = document.querySelector('.toggle-password');

        if (togglePasswordButton && passwordInput) {
            togglePasswordButton.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
            });
        }
    </script>
</body>
<footer class="footer">
    Copyright <?php echo date("Y"); ?>. Dunkin Donuts.
</footer>
</html>