<?php
// Verifica que la petición HTTP sea de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Construye un arreglo asociativo con los datos recibidos del formulario
    $datos = [
        'empleado'  => $_POST['empleado'],                     // Nombre o ID del empleado que envía la solicitud
        'producto'  => $_POST['producto'],                     // Producto solicitado
        'cantidad'  => $_POST['cantidad'],                     // Cantidad solicitada
        'fecha'     => date('Y-m-d H:i:s')                     // Fecha y hora actual en formato YYYY-MM-DD HH:MM:SS
    ];

    // Nombre del archivo JSON donde se almacenan las peticiones
    $archivo = 'peticiones.json';

    // Lee las peticiones ya existentes en el archivo, si existe;
    // de lo contrario inicializa un arreglo vacío
    $peticiones = file_exists($archivo)
        ? json_decode(file_get_contents($archivo), true)
        : [];

    // Agrega al final del arreglo la nueva petición recibida
    $peticiones[] = $datos;

    // Escribe de nuevo el arreglo completo en el archivo JSON,
    // con opciones para un formato legible (JSON_PRETTY_PRINT)
    file_put_contents($archivo, json_encode($peticiones, JSON_PRETTY_PRINT));

    // Muestra un mensaje de confirmación al usuario
    echo "Petición enviada correctamente.";
}
?>