<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../modelo/PeticionDAO.php';
require_once __DIR__ . '/../modelo/ProductoDAO.php';

class PeticionControlador {
    
    private function verificarAcceso($roles_permitidos) {
        if (!isset($_SESSION['admin_tipo']) || !in_array($_SESSION['admin_tipo'], $roles_permitidos)) {
            header('Location: index.php?controlador=admin&accion=mostrarLogin');
            exit();
        }
    }

    public function mostrarFormularioPeticion() {
        $this->verificarAcceso(['empleado', 'encargado']);
        
        $productoDAO = new ProductoDAO();
        $productos = $productoDAO->obtenerTodos(); // 
        
        // La lógica de la sesión para manejar la lista temporal de peticiones
        $peticiones_actuales = $_SESSION['peticiones_temp'] ?? [];
        
        require_once __DIR__ . '/../vista/admin/peticiones.php';
    }

    public function agregarPeticionTemporal() {
        $this->verificarAcceso(['empleado', 'encargado']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto_id = $_POST['producto_id']; // 
            $cantidad = $_POST['cantidad']; // 
            $motivo = $_POST['motivo']; // 

            // Obtener datos del producto para mostrar en la lista
            $productoDAO = new ProductoDAO();
            $producto = $productoDAO->obtenerPorId($producto_id); // 
            
            if ($producto) {
                if (!isset($_SESSION['peticiones_temp'])) {
                    $_SESSION['peticiones_temp'] = [];
                }
                // Añadir a la lista temporal en la sesión
                $_SESSION['peticiones_temp'][] = [
                    'producto_id' => $producto_id,
                    'nombre' => $producto['nombre'],
                    'imagen' => $producto['imagen'],
                    'cantidad' => $cantidad,
                    'motivo' => $motivo
                ]; // 
            }
        }
        header('Location: index.php?controlador=peticion&accion=mostrarFormularioPeticion');
        exit();
    }

    public function eliminarPeticionTemporal() {
        $this->verificarAcceso(['empleado', 'encargado']);
        
        if (isset($_GET['index'])) {
            $index = intval($_GET['index']);
            if (isset($_SESSION['peticiones_temp'][$index])) {
                array_splice($_SESSION['peticiones_temp'], $index, 1); // 
            }
        }
        header('Location: index.php?controlador=peticion&accion=mostrarFormularioPeticion');
        exit();
    }

    public function enviarPeticiones() {
        $this->verificarAcceso(['empleado', 'encargado']);
        
        $peticionDAO = new PeticionDAO();
        $peticiones_temporales = $_SESSION['peticiones_temp'] ?? [];

        foreach ($peticiones_temporales as $peticion) {
            $peticionDAO->crearPeticion($peticion['producto_id'], $peticion['cantidad'], $peticion['motivo']);
        }
        
        // Limpiar las peticiones temporales de la sesión
        unset($_SESSION['peticiones_temp']); // 
        
        header('Location: index.php?controlador=peticion&accion=mostrarFormularioPeticion&status=enviado'); // 
        exit();
    }

    public function verPeticionesEncargado() {
        $this->verificarAcceso(['encargado']);
        
        $peticionDAO = new PeticionDAO();
        $peticiones = $peticionDAO->obtenerTodas();
        
        // Cargar la nueva vista que crearemos en el siguiente paso
        require_once __DIR__ . '/../vista/admin/ver_peticiones.php';
    }
}
?>