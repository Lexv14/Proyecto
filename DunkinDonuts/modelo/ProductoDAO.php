<?php
require_once __DIR__ . '/../config/BaseDeDatos.php';

class ProductoDAO {
    private $conexion;
    const DB_NAME = 'donas';

    public function __construct() {
        $this->conexion = BaseDeDatos::obtenerInstancia()->obtenerConexion(self::DB_NAME);
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM productos";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function crear($nombre, $descripcion, $precio, $stock, $imagen) {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $stock, $imagen);
        return $stmt->execute();
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $stock, $imagen) {
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, imagen = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $stock, $imagen, $id);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $sql = "DELETE FROM productos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function actualizarStock($id_producto, $cantidad_comprada) {
        $sql = "UPDATE productos SET stock = stock - ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ii", $cantidad_comprada, $id_producto);
        return $stmt->execute();
    }
}
?>