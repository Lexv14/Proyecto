<?php
require_once __DIR__ . '/../config/BaseDeDatos.php';

class ReporteDAO {
    private $conexion;
    const DB_NAME = 'donas'; // Los datos de ventas están en la BD 'donas'

    public function __construct() {
        $this->conexion = BaseDeDatos::obtenerInstancia()->obtenerConexion(self::DB_NAME);
    }

    /**
     * Obtiene datos de ventas agregados, con filtros opcionales por fecha y producto.
     */
    public function obtenerVentasPorFiltros($fecha_inicio, $fecha_fin, $producto_id) {
        // La consulta base ahora también suma la cantidad de productos vendidos
        $sql = "SELECT
                    prod.nombre AS producto_nombre,
                    SUM(dp.cantidad * dp.precio_unitario) AS total_venta,
                    SUM(dp.cantidad) AS cantidad_total -- <--- LÍNEA NUEVA
                FROM detalle_pedido dp
                JOIN pedidos p ON dp.pedido_id = p.id
                JOIN productos prod ON dp.producto_id = prod.id";

        // ... (el resto del método para manejar los filtros WHERE no cambia) ...
        $params = [];
        $tipos = "";
        $where_clauses = [];

        if (!empty($fecha_inicio)) {
            $where_clauses[] = "p.fecha >= ?";
            $params[] = $fecha_inicio . " 00:00:00";
            $tipos .= "s";
        }
        if (!empty($fecha_fin)) {
            $where_clauses[] = "p.fecha <= ?";
            $params[] = $fecha_fin . " 23:59:59";
            $tipos .= "s";
        }
        if (!empty($producto_id) && $producto_id > 0) {
            $where_clauses[] = "dp.producto_id = ?";
            $params[] = $producto_id;
            $tipos .= "i";
        }

        if (!empty($where_clauses)) {
            $sql .= " WHERE " . implode(" AND ", $where_clauses);
        }

        $sql .= " GROUP BY prod.id, prod.nombre ORDER BY total_venta DESC";

        $stmt = $this->conexion->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($tipos, ...$params);
        }
        
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>