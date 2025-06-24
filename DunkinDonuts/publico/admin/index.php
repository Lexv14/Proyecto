<?php
// --- FRONT CONTROLLER ADMIN ---

define('BASE_PATH', __DIR__ . '/../..');

spl_autoload_register(function ($clase) {
    $ruta = BASE_PATH . '/controlador/' . $clase . '.php';
    if (file_exists($ruta)) {
        require_once $ruta;
    }
});

// Enrutador simple para el área de administración
$controladorNombre = $_GET['controlador'] ?? 'Admin';
$accion = $_GET['accion'] ?? 'mostrarLogin';

$controladorNombre = ucfirst(strtolower($controladorNombre)) . 'Controlador';

if (class_exists($controladorNombre)) {
    $controlador = new $controladorNombre();
    if (method_exists($controlador, $accion)) {
        $controlador->$accion();
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "<h1>Error 404: Acción administrativa no encontrada</h1>";
    }
} else {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>Error 404: Controlador administrativo no encontrado</h1>";
}
?>