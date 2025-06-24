<?php
// Inicia la sesión al principio de todo
session_start();

require_once __DIR__ . '/../modelo/ProductoDAO.php';
require_once __DIR__ . '/../modelo/VisitaDAO.php';
require_once __DIR__ . '/../modelo/ChatDAO.php';

class TiendaControlador {

    public function mostrarProductos() {
        $productoDAO = new ProductoDAO();
        $visitaDAO = new VisitaDAO();

        // Registrar y obtener visitas 
        $pagina = 'productos';
        $visitaDAO->registrarVisita($pagina);
        $contador_visitas = $visitaDAO->obtenerVisitasPorPagina($pagina);

        // Obtener productos
        $productos = $productoDAO->obtenerTodos(); // 

        // Cargar la vista
        require_once __DIR__ . '/../vista/tienda/productos.php';
    }

    public function mostrarCarrito() {
        // El carrito se gestiona principalmente en la sesión
        $carrito = $_SESSION['carrito'] ?? [];
        
        // Calcular subtotal 
        $subtotal_carrito = 0;
        foreach ($carrito as $item) {
            $subtotal_carrito += $item['precio'] * $item['cantidad'];
        }
        
        require_once __DIR__ . '/../vista/tienda/carrito.php';
    }

    public function agregarAlCarrito() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nombre = $_POST['nombre'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $cantidad = $_POST['cantidad'] ?? 1;
            $imagen = $_POST['imagen'] ?? 'default_image.png'; // Se recibe la imagen 

            if (empty($id)) {
                die("Error: ID de producto inválido.");
            }

            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }

            if (isset($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
            } else {
                $_SESSION['carrito'][$id] = [
                    'id' => $id,
                    'nombre' => $nombre,
                    'precio' => floatval($precio),
                    'cantidad' => intval($cantidad),
                    'imagen' => $imagen // Se guarda la imagen en la sesión 
                ];
            }
        }
        header('Location: index.php?controlador=tienda&accion=mostrarProductos');
        exit();
    }
    
    public function actualizarCantidadCarrito() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $cambio = intval($_POST['cambio'] ?? 0);

            if ($id !== null && isset($_SESSION['carrito'][$id]) && $cambio !== 0) {
                // Verificar stock antes de agregar
                if ($cambio > 0) {
                    $productoDAO = new ProductoDAO();
                    $producto = $productoDAO->obtenerPorId($id);
                    if ($_SESSION['carrito'][$id]['cantidad'] < $producto['stock']) { // 
                        $_SESSION['carrito'][$id]['cantidad']++; // 
                    }
                } else { // Si el cambio es negativo (quitar)
                     $_SESSION['carrito'][$id]['cantidad']--; // 
                }

                // Si la cantidad llega a 0, eliminar el producto del carrito
                if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {
                    unset($_SESSION['carrito'][$id]); // 
                }
            }
        }
        header('Location: index.php?controlador=tienda&accion=mostrarCarrito');
        exit();
    }

    public function eliminarDelCarrito() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id !== null && isset($_SESSION['carrito'][$id])) {
                unset($_SESSION['carrito'][$id]); // 
            }
        }
        header('Location: index.php?controlador=tienda&accion=mostrarCarrito');
        exit();
    }

    public function finalizarCompra() {
        // Si el carrito está vacío, no se puede finalizar la compra
        if (empty($_SESSION['carrito'])) {
            header('Location: index.php?controlador=tienda&accion=mostrarCarrito');
            exit;
        }
        
        // Si el usuario no ha iniciado sesión, redirigir al login 
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controlador=usuario&accion=mostrarLogin&redirect=finalizar_compra');
            exit;
        }

        require_once __DIR__ . '/../vista/tienda/finalizar_compra.php';
    }
    
    public function procesarCompra() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            // Aquí iría la lógica de procesamiento de pago...
            
            // Simulación de compra exitosa
            // Vaciar el carrito
            $_SESSION['carrito'] = [];

            // Cargar la vista de agradecimiento
            require_once __DIR__ . '/../vista/tienda/agradecimiento.php';
        } else {
            header('Location: index.php');
            exit();
        }
    }
    
    public function guardarMensajeChat() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $mensaje = trim($_POST['mensaje'] ?? '');

            if (!empty($nombre) && !empty($mensaje)) { // 
                $chatDAO = new ChatDAO();
                $chatDAO->guardarMensaje($nombre, $mensaje); // 
            }
        }
        header('Location: index.php?controlador=tienda&accion=mostrarProductos');
        exit();
    }

    public function mostrarUbicacion() {
        require_once __DIR__ . '/../vista/tienda/ubicacion.php';
    }
}
?>