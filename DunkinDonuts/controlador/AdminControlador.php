<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../modelo/AdminDAO.php';
require_once __DIR__ . '/../modelo/ChatDAO.php';

class AdminControlador {
    
    public function mostrarLogin() {
        require_once __DIR__ . '/../vista/admin/login.php';
    }

    public function procesarLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];

            $adminDAO = new AdminDAO();
            $admin = $adminDAO->autenticar($usuario, $clave); // 

            if ($admin) { // 
                $_SESSION['admin_usuario'] = $admin['usuario'];
                $_SESSION['admin_tipo'] = $admin['tipo'];

                if ($admin['tipo'] === 'encargado') {
                    header('Location: index.php?controlador=admin&accion=mostrarPanelEncargado'); // 
                } else {
                    header('Location: index.php?controlador=admin&accion=mostrarPanelEmpleado'); // 
                }
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
                require_once __DIR__ . '/../vista/admin/login.php';
            }
        }
    }

    public function mostrarPanelEmpleado() {
        $this->verificarAcceso(['empleado', 'encargado']);
        require_once __DIR__ . '/../vista/admin/panel_empleado.php';
    }

    public function mostrarPanelEncargado() {
        $this->verificarAcceso(['encargado']);
        require_once __DIR__ . '/../vista/admin/panel_encargado.php';
    }

    public function gestionarUsuarios() {
        $this->verificarAcceso(['encargado']);
        $adminDAO = new AdminDAO();
        $empleados = $adminDAO->obtenerTodosLosEmpleados(); // 
        require_once __DIR__ . '/../vista/admin/gestion_usuarios.php';
    }

    public function agregarEmpleado() {
        $this->verificarAcceso(['encargado']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave']; // En un sistema real, la clave debería ser hasheada
            $tipo = $_POST['tipo'];

            $adminDAO = new AdminDAO();
            if ($adminDAO->crearEmpleado($usuario, $clave, $tipo)) { // 
                header('Location: index.php?controlador=admin&accion=gestionarUsuarios&status=ok');
            } else {
                header('Location: index.php?controlador=admin&accion=gestionarUsuarios&status=error');
            }
            exit();
        }
    }

    public function eliminarEmpleado() {
        $this->verificarAcceso(['encargado']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'];
            $adminDAO = new AdminDAO();
            $adminDAO->eliminarEmpleado($usuario); // 
            header('Location: index.php?controlador=admin&accion=gestionarUsuarios&status=deleted');
            exit();
        }
    }

    public function obtenerMensajesAjax() {
        $this->verificarAcceso(['empleado', 'encargado']);
        $chatDAO = new ChatDAO();
        $mensajes = $chatDAO->obtenerTodosLosMensajes(); // 
        header('Content-Type: application/json');
        echo json_encode($mensajes); // 
    }
    
    public function cerrarSesion() {
        session_destroy();
        header('Location: index.php');
        exit();
    }
    
    private function verificarAcceso($roles_permitidos) {
        if (!isset($_SESSION['admin_tipo']) || !in_array($_SESSION['admin_tipo'], $roles_permitidos)) {
            header('Location: index.php?accion=mostrarLogin');
            exit();
        }
    }

    public function verMensajesEmpleado() {
        $this->verificarAcceso(['empleado', 'encargado']);
        
        $chatDAO = new ChatDAO();
        $mensajes = $chatDAO->obtenerTodosLosMensajes(); // 
        
        // Cargar la nueva vista que crearemos
        require_once __DIR__ . '/../vista/admin/ver_mensajes.php';
    }
}
?>