<?php
// Conexión a la base de datos 'login_sistema' usando MySQLi
$conexion = new mysqli("localhost", "root", "", "login_sistema");

// Verifica si hubo error al conectar
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Captura los datos enviados desde el formulario de login
$usuario = $_POST['usuario'];    // Nombre de usuario ingresado
$clave   = $_POST['clave'];      // Contraseña ingresada

// Consulta SQL para verificar credenciales
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
// Ejecuta la consulta
$resultado = $conexion->query($sql);

// Si encontró al menos un registro con esas credenciales
if ($resultado->num_rows > 0) {
    // Obtiene la fila con los datos del usuario
    $fila = $resultado->fetch_assoc();

    // Redirige según el tipo de usuario
    if ($fila['tipo'] == 'empleado') {
        header("Location: empleado.html");    // Si es empleado, va a la página de empleado
    } elseif ($fila['tipo'] == 'encargado') {
        header("Location: encargado.html");   // Si es encargado, va al panel de encargado
    }
} else {
    // Si no hay coincidencias, muestra mensaje de error
    echo "Usuario o contraseña incorrectos.";
}

// Cierra la conexión a la base de datos
$conexion->close();
?>