<?php
require_once __DIR__ . '/../config/BaseDeDatos.php';

class PedidoDAO {
    private $conexion;
    const DB_NAME = 'donas';

    public function __construct() {
        $this->conexion = BaseDeDatos::obtenerInstancia()->obtenerConexion(self::DB_NAME);
    }

    public function crearPedido($usuario_id, $total) {
        $sql = "INSERT INTO pedidos (usuario_id, total, fecha) VALUES (?, ?, NOW())";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("id", $usuario_id, $total);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }

    public function guardarDetallePedido($pedido_id, $producto_id, $cantidad, $precio_unitario) {
        $sql = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iiid", $pedido_id, $producto_id, $cantidad, $precio_unitario);
        return $stmt->execute();
    }
}
?>