<?php
require_once __DIR__ . '/../config/BaseDeDatos.php';

class VisitaDAO {
    private $conexion;
    const DB_NAME = 'donas';

    public function __construct() {
        $this->conexion = BaseDeDatos::obtenerInstancia()->obtenerConexion(self::DB_NAME);
    }

    public function registrarVisita($pagina) {
        $sql_update = "UPDATE visitas SET contador = contador + 1 WHERE pagina = ?";
        $stmt_update = $this->conexion->prepare($sql_update);
        $stmt_update->bind_param("s", $pagina);
        $stmt_update->execute();

        if ($stmt_update->affected_rows == 0) {
            $sql_insert = "INSERT INTO visitas (pagina, contador) VALUES (?, 1)";
            $stmt_insert = $this->conexion->prepare($sql_insert);
            $stmt_insert->bind_param("s", $pagina);
            $stmt_insert->execute();
            $stmt_insert->close();
        }
        $stmt_update->close();
    }

    public function obtenerVisitasPorPagina($pagina) {
        $sql = "SELECT contador FROM visitas WHERE pagina = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $pagina);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        return $fila ? $fila['contador'] : 0;
    }
}
?>