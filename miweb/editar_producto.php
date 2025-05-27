<?php
// Incluye el archivo que contiene la conexión a la base de datos
include("conexion.php");

// Obtiene los datos enviados mediante POST desde el formulario
$id = $_POST['id'];                     // ID del producto que se va a actualizar
$nombre = $_POST['nombre'];             // Nuevo nombre del producto
$descripcion = $_POST['descripcion'];   // Nueva descripción
$precio = $_POST['precio'];             // Nuevo precio
$imagen = $_POST['imagen'];             // Nueva URL o nombre de imagen
$stock = $_POST['stock'];               // Nuevo valor de stock disponible

// Se prepara la sentencia SQL para actualizar los campos del producto especificado
$sql = "UPDATE productos SET 
          nombre = ?, 
          descripcion = ?, 
          precio = ?, 
          imagen = ?, 
          stock = ? 
        WHERE id = ?";

// Se crea una sentencia preparada para evitar inyecciones SQL
$stmt = $conexion->prepare($sql);

// Se vinculan los parámetros a la sentencia preparada
// Tipos de datos: s (string), d (double), i (integer)
// En este caso: nombre (s), descripcion (s), precio (d), imagen (s), stock (i), id (i)
$stmt->bind_param("ssdssi", $nombre, $descripcion, $precio, $imagen, $stock, $id);

// Se ejecuta la sentencia
$stmt->execute();

// Una vez actualizado, redirige al usuario a la página del inventario
header("Location: inventario.php");

// Finaliza el script para evitar cualquier salida posterior
exit;
?>