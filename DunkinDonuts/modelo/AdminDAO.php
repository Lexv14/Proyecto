<?php
// Se añade esta línea para incluir la definición de la clase BaseDeDatos
require_once __DIR__ . '/../config/BaseDeDatos.php';

class AdminDAO {
    private $conexion;
    const DB_NAME = 'login_sistema';

    public function __construct() {
        // Esta línea ahora funcionará porque la clase BaseDeDatos ya fue incluida
        $this->conexion = BaseDeDatos::obtenerInstancia()->obtenerConexion(self::DB_NAME);
    }

    public function autenticar($usuario, $clave) {
        $sql = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $usuario, $clave);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
    
    public function obtenerTodosLosEmpleados() {
        $sql = "SELECT id, usuario, tipo FROM usuarios WHERE tipo = 'empleado'";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function crearEmpleado($usuario, $clave, $tipo = 'empleado') {
        $sql = "INSERT INTO usuarios (usuario, clave, tipo) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sss", $usuario, $clave, $tipo);
        return $stmt->execute();
    }

    public function eliminarEmpleado($usuario) {
        $sql = "DELETE FROM usuarios WHERE usuario = ? AND tipo = 'empleado'";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $usuario);
        return $stmt->execute();
    }
}
?>