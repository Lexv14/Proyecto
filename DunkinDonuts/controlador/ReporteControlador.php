<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../modelo/ReporteDAO.php';
require_once __DIR__ . '/../modelo/ProductoDAO.php';

class ReporteControlador {

    private function verificarAcceso() {
        if (!isset($_SESSION['admin_tipo']) || $_SESSION['admin_tipo'] !== 'encargado') {
            header('Location: index.php?controlador=admin&accion=mostrarLogin');
            exit();
        }
    }

    // Muestra la página principal de reportes con los filtros
    public function mostrarReportes() {
        $this->verificarAcceso();
        
        // Cargar productos para el filtro dropdown
        $productoDAO = new ProductoDAO();
        $productos = $productoDAO->obtenerTodos();
        
        require_once __DIR__ . '/../vista/admin/reportes.php';
    }

    // Proporciona los datos en formato JSON para el gráfico (llamada por AJAX)
    public function obtenerDatosGraficoAjax() {
        $this->verificarAcceso();

        $fecha_inicio = !empty($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
        $fecha_fin = !empty($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;
        $producto_id = !empty($_GET['producto_id']) ? $_GET['producto_id'] : null;

        $reporteDAO = new ReporteDAO();
        $datosVentas = $reporteDAO->obtenerVentasPorFiltros($fecha_inicio, $fecha_fin, $producto_id);

        $labels = [];
        $data_ventas = []; // Datos para el total en S/
        $data_cantidad = []; // Datos para la cantidad de unidades

        foreach ($datosVentas as $venta) {
            $labels[] = $venta['producto_nombre'];
            $data_ventas[] = $venta['total_venta'];
            $data_cantidad[] = $venta['cantidad_total']; // Se procesa el nuevo dato
        }

        header('Content-Type: application/json');
        // Enviamos ambos conjuntos de datos en el JSON
        echo json_encode(['labels' => $labels, 'ventas' => $data_ventas, 'cantidad' => $data_cantidad]);
        exit();
    }
}
?>