<?php
// La sesión ya está iniciada por el controlador principal o el router
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../modelo/UsuarioDAO.php';

class UsuarioControlador {
    
    public function mostrarLogin() {
        $redirect = $_GET['redirect'] ?? '';
        require_once __DIR__ . '/../vista/usuario/login.php';
    }

    public function procesarLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $contraseña = $_POST['contraseña'];

            $usuarioDAO = new UsuarioDAO();
            $usuario = $usuarioDAO->buscarPorEmail($email); // 

            $mensaje = "";
            if ($usuario && password_verify($contraseña, $usuario['contraseña'])) { // 
                // Login exitoso
                $_SESSION['usuario_id'] = $usuario['id']; // 
                $_SESSION['usuario_nombre'] = $usuario['nombre']; // 

                $redirect = $_POST['redirect'] ?? '';
                if ($redirect === 'finalizar_compra') {
                    header('Location: index.php?controlador=tienda&accion=finalizarCompra'); // 
                } else {
                    header('Location: index.php?controlador=usuario&accion=mostrarBienvenida');
                }
                exit();
            } elseif ($usuario) {
                $mensaje = "Contraseña incorrecta."; // 
            } else {
                $mensaje = "Usuario no encontrado. Por favor, regístrate primero.";
            }

            // Si el login falla, volver a mostrar el formulario con un mensaje
            require_once __DIR__ . '/../vista/usuario/login.php';
        }
    }

    public function mostrarRegistro() {
        require_once __DIR__ . '/../vista/usuario/registro.php';
    }

    public function procesarRegistro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $contraseña = $_POST['contraseña'];

            $usuarioDAO = new UsuarioDAO();
            $mensaje = "";

            // Verificar si el email ya existe 
            if ($usuarioDAO->buscarPorEmail($email)) {
                $mensaje = "Ese correo ya está registrado. ¿Olvidaste tu contraseña?"; // 
                require_once __DIR__ . '/../vista/usuario/registro.php';
            } else {
                $hash = password_hash($contraseña, PASSWORD_DEFAULT); // 
                $nuevo_id = $usuarioDAO->crear($nombre, $email, $hash); // 

                if ($nuevo_id) {
                    // Iniciar sesión automáticamente después del registro
                    $_SESSION['usuario_id'] = $nuevo_id; // 
                    $_SESSION['usuario_nombre'] = $nombre; // 
                    header('Location: index.php?controlador=usuario&accion=mostrarBienvenida');
                    exit();
                } else {
                    $mensaje = "Error al registrar el usuario."; // 
                    require_once __DIR__ . '/../vista/usuario/registro.php';
                }
            }
        }
    }

    public function mostrarBienvenida() {
        // Verificar si el usuario está logueado
        if (!isset($_SESSION['usuario_id'])) { // 
            header('Location: index.php?controlador=usuario&accion=mostrarLogin');
            exit();
        }
        require_once __DIR__ . '/../vista/tienda/bienvenida.php';
    }
    
    public function cerrarSesion() {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit();
    }
}
?>