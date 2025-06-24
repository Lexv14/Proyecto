<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../modelo/ProductoDAO.php';

class ProductoControlador {

    private function verificarAcceso() {
        if (!isset($_SESSION['admin_tipo']) || !in_array($_SESSION['admin_tipo'], ['empleado', 'encargado'])) {
            header('Location: index.php?controlador=admin&accion=mostrarLogin');
            exit();
        }
    }

    public function mostrarInventario() {
        $this->verificarAcceso();
        $productoDAO = new ProductoDAO();
        $productos = $productoDAO->obtenerTodos(); // 
        require_once __DIR__ . '/../vista/admin/inventario.php';
    }

    public function agregarProducto() {
        $this->verificarAcceso();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $imagen = $_POST['imagen'];
            
            $productoDAO = new ProductoDAO();
            $productoDAO->crear($nombre, $descripcion, $precio, $stock, $imagen); // 
        }
        header('Location: index.php?controlador=producto&accion=mostrarInventario'); // 
        exit();
    }

    public function editarProducto() {
        $this->verificarAcceso();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $imagen = $_POST['imagen'];
            
            $productoDAO = new ProductoDAO();
            $productoDAO->actualizar($id, $nombre, $descripcion, $precio, $stock, $imagen); // 
        }
        header('Location: index.php?controlador=producto&accion=mostrarInventario'); // 
        exit();
    }
    
    public function eliminarProducto() {
        $this->verificarAcceso();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id']; // 
            $productoDAO = new ProductoDAO();
            $productoDAO->eliminar($id); // 
        }
        header('Location: index.php?controlador=producto&accion=mostrarInventario'); // 
        exit();
    }
}
?>