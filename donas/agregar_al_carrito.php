<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $cantidad = $_POST['cantidad'] ?? 1;  // Aquí usamos la cantidad que venga (por defecto 1)

    if ($id === null || $id === '') {
        die("Error: El ID del producto es inválido.");
    }

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $existe = false;

    // Verificar si el producto ya está en el carrito para sumar cantidad
    foreach ($_SESSION['carrito'] as &$producto) {
        if ($producto['id'] == $id) {
            $producto['cantidad'] += intval($cantidad);
            $existe = true;
            break;
        }
    }
    unset($producto);

    if (!$existe) {
        $_SESSION['carrito'][] = [
            'id' => $id,
            'nombre' => $nombre,
            'precio' => floatval($precio),
            'cantidad' => intval($cantidad)
        ];
    }

    header('Location: productos.php');

    exit();
}
