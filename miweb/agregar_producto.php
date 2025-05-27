<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");

// Obtiene los valores enviados desde el formulario mediante POST
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$imagen = $_POST['imagen'];

// Escapa caracteres especiales para evitar errores por comillas y prevenir inyecciones SQL simples
$nombre = $conexion->real_escape_string($nombre);
$descripcion = $conexion->real_escape_string($descripcion);
$imagen = $conexion->real_escape_string($imagen);

// Prepara la consulta SQL para insertar un nuevo producto en la tabla "productos"
$sql = "INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES ('$nombre', '$descripcion', '$precio', '$imagen')";

// Ejecuta la consulta en la base de datos
$conexion->query($sql);

// Redirige al usuario de vuelta a la página del inventario
header("Location: inventario.php");

// Finaliza el script para asegurar que no se ejecute nada más después
exit;
?>