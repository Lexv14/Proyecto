<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'] ?? null;

    if ($index !== null && isset($_SESSION['carrito'][$index])) {
        if ($_SESSION['carrito'][$index]['cantidad'] > 1) {
            $_SESSION['carrito'][$index]['cantidad']--;
        } else {
            unset($_SESSION['carrito'][$index]);
        }

        // Reindexar
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}

header("Location: carrito.php");
exit();
