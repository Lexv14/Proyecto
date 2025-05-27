<?php
// Crea una nueva instancia de conexión a la base de datos utilizando MySQLi
// Parámetros: servidor ("localhost"), usuario ("root"), contraseña (""), base de datos ("donas")
$conexion = new mysqli("localhost", "root", "", "donas");

// Verifica si hubo algún error al intentar conectar con la base de datos
if ($conexion->connect_error) {
  // Si ocurre un error, detiene la ejecución y muestra el mensaje de error
  die("Error de conexión: " . $conexion->connect_error);
}
?>