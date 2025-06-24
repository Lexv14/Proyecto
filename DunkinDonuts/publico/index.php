<?php
// --- FRONT CONTROLLER TIENDA ---

// Se define el directorio base de la aplicación
define('BASE_PATH', __DIR__ . '/..');

// Autocarga de controladores
spl_autoload_register(function ($clase) {
    $ruta = BASE_PATH . '/controlador/' . $clase . '.php';
    if (file_exists($ruta)) {
        require_once $ruta;
    }
});

// Enrutador simple
$controladorNombre = $_GET['controlador'] ?? 'Tienda';
$accion = $_GET['accion'] ?? 'mostrarProductos';

// Capitalizar para seguir el estándar de nombres de clase (ej. 'tienda' -> 'TiendaControlador')
$controladorNombre = ucfirst(strtolower($controladorNombre)) . 'Controlador';

// Verificar que el controlador y el método existan
if (class_exists($controladorNombre)) {
    $controlador = new $controladorNombre();
    if (method_exists($controlador, $accion)) {
        $controlador->$accion();
    } else {
        // Error 404: Acción no encontrada
        header("HTTP/1.0 404 Not Found");
        echo "<h1>Error 404: Acción no encontrada</h1>";
    }
} else {
    // Error 404: Controlador no encontrado
    header("HTTP/1.0 404 Not Found");
    echo "<h1>Error 404: Controlador no encontrado</h1>";
}
?>