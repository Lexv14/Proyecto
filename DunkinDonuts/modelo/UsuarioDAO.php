<?php
require_once __DIR__ . '/../config/BaseDeDatos.php';

class UsuarioDAO {
    private $conexion;
    const DB_NAME = 'donas';

    public function __construct() {
        $this->conexion = BaseDeDatos::obtenerInstancia()->obtenerConexion(self::DB_NAME);
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function crear($nombre, $email, $contraseña_hasheada) {
        $sql = "INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sss", $nombre, $email, $contraseña_hasheada);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }
}
?>