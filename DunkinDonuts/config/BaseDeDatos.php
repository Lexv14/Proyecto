<?php
class BaseDeDatos {
    private static $instancia = null;
    private $conexion;

    private $host = '127.0.0.1';
    private $usuario = 'root';
    private $clave = 'Admin123';

    // El constructor es privado para prevenir la creación de objetos con 'new'
    private function __construct() {}

    /**
     * Previene la clonación del objeto (patrón Singleton).
     */
    private function __clone() {}

    /**
     * Previene la deserialización del objeto (patrón Singleton).
     */
    public function __wakeup() {}

    /**
     * Obtiene la instancia única de la clase. Si no existe, la crea.
     */
    public static function obtenerInstancia(): BaseDeDatos {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    /**
     * Establece una conexión a la base de datos especificada.
     * @param string $nombre_db El nombre de la base de datos ('donas' o 'login_sistema').
     * @return mysqli La conexión a la base de datos.
     */
    public function obtenerConexion(string $nombre_db): mysqli {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->clave, $nombre_db);

        if ($this->conexion->connect_error) {
            die("Error de conexión a la base de datos '$nombre_db': " . $this->conexion->connect_error);
        }

        // Se recomienda establecer el charset después de la conexión
        $this->conexion->set_charset("utf8mb4");

        return $this->conexion;
    }
}
?>