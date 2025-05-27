<?php
session_start();
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "donas");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $email = $_POST["email"];
    $password = $_POST["contraseña"];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario['contraseña'])) {
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nombre"] = $usuario["nombre"];

            // Redireccionar según parámetro 'redirect'
            if (isset($_GET['redirect']) && $_GET['redirect'] === 'finalizar_compra') {
                header("Location: finalizar_compra.php");
            } else {
                header("Location: bienvenida.php");
            }
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Usuario no encontrado. Por favor, regístrate primero.";
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="estilos_login.css">
</head>
<body>
    <header class="header">
        <div class="header-logo">
            <a href="productos.php">DUNKIN'</a>
        </div>
    </header>

    <div class="login-container">
        <h1>INICIAR SESIÓN</h1>

        <?php if (!empty($mensaje)): // Check if $mensaje is not empty before displaying ?>
            <div class="mensaje-error"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="email">Correo electrónico *</label>
            <input type="email" id="email" name="email" placeholder="Ej. nombre@mail.com" required>

            <label for="contraseña">Contraseña *</label>
            <div class="password-wrapper">
                <input type="password" id="contraseña" name="contraseña" placeholder="Aa12345" required>
                <span class="toggle-password">👁️</span>
            </div>

            <button type="submit">INICIAR SESIÓN</button>
        </form>

        <a href="registro.php" class="register-link">¿No tienes cuenta? Regístrate</a>
        <a href="productos.php" class="back-link">← Volver al inicio</a>
    </div>

    <script>
        const passwordInput = document.getElementById('contraseña');
        const togglePasswordButton = document.querySelector('.toggle-password');

        if (togglePasswordButton && passwordInput) {
            togglePasswordButton.addEventListener('click', function () {
                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Optional: Change icon if you have two versions (e.g., eye and eye-slash)
                // This example just uses one icon, but you could change its textContent or class
                // For example: this.textContent = type === 'password' ? '👁️' : '🙈';
            });
        }
    </script>
</body>
<footer class="footer">
    Copyright <?php echo date("Y"); ?>. Dunkin Donuts.
</footer>
</html>