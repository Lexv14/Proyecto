<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");

// Obtiene el ID del producto enviado desde el formulario mediante POST
$id = $_POST['id'];

// Prepara la sentencia SQL para eliminar un producto específico según su ID
// Esto se hace para prevenir ataques de inyección SQL
$stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");

// Se vincula el parámetro ID como entero (i = integer)
$stmt->bind_param("i", $id);

// Ejecuta la sentencia SQL preparada
$stmt->execute();

// Cierra la sentencia una vez que se ha ejecutado
$stmt->close();

// Redirige al usuario de regreso a la página del inventario
header("Location: inventario.php");

// Finaliza el script para asegurar que no se procese nada más
exit;
?>