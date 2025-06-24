<?php
require_once __DIR__ . '/../config/BaseDeDatos.php';

class PeticionDAO {
    private $conexion;
    const DB_NAME = 'login_sistema';

    public function __construct() {
        $this->conexion = BaseDeDatos::obtenerInstancia()->obtenerConexion(self::DB_NAME);
    }

    public function crearPeticion($producto_id, $cantidad, $motivo) {
        $sql = "INSERT INTO peticiones (producto_id, cantidad, motivo, fecha) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iis", $producto_id, $cantidad, $motivo);
        return $stmt->execute();
    }

    public function obtenerTodas() {
        // Consulta que une la tabla de peticiones en `login_sistema` con la de productos en `donas`
        $sql = "SELECT p.id, p.cantidad, p.motivo, p.fecha, prod.nombre as producto_nombre
                FROM login_sistema.peticiones p
                JOIN donas.productos prod ON p.producto_id = prod.id
                ORDER BY p.fecha DESC";
        
        $resultado = $this->conexion->query($sql);
        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
?>