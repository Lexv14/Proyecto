<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'] ?? null;

    if ($index !== null && isset($_SESSION['carrito'][$index])) {
        // Conexión a la base de datos para obtener el stock
        $conexion = new mysqli("localhost", "root", "", "donas");
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $producto_id = $_SESSION['carrito'][$index]['id'];
        $cantidad_actual = $_SESSION['carrito'][$index]['cantidad'];

        // Consultar stock actual del producto
        $sql = "SELECT stock FROM productos WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($producto = $resultado->fetch_assoc()) {
            $stock = (int)$producto['stock'];
            if ($cantidad_actual < $stock) {
                $_SESSION['carrito'][$index]['cantidad']++;
            }
            // Si ya es igual o mayor, no hace nada
        }

        $stmt->close();
        $conexion->close();
    }
}

header("Location: carrito.php");
exit();
