<?php
require_once __DIR__ . '/../config/BaseDeDatos.php';

class ChatDAO {
    private $conexion;
    const DB_NAME = 'donas';

    public function __construct() {
        $this->conexion = BaseDeDatos::obtenerInstancia()->obtenerConexion(self::DB_NAME);
    }

    public function guardarMensaje($nombre, $mensaje) {
        $sql = "INSERT INTO chat_clientes (nombre, mensaje) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $nombre, $mensaje);
        return $stmt->execute();
    }

    public function obtenerTodosLosMensajes() {
        $sql = "SELECT nombre, mensaje, fecha FROM chat_clientes ORDER BY fecha DESC";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>