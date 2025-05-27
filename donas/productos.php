<?php
session_start();
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "donas");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener productos
$sql = "SELECT * FROM productos"; // Assuming your table has id, nombre, descripcion, precio, imagen
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - DUNKIN'</title>
    <link rel="stylesheet" href="estilos_productos.css">
    </head>
<body>
    <header class="header">
        <div class="header-logo">
            <a href="productos.php">DUNKIN'</a>
        </div>
        <nav class="header-nav">
            <?php if (isset($_SESSION["usuario_nombre"])): ?>
                <a href="logout.php" class="boton"><span>Hola, <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></span></a>
            <?php else: ?>
                <a href="login.php" class="boton">Iniciar sesión 🏠</a>
            <?php endif; ?>
            <a href="carrito.php" class="boton boton-carrito">Ver carrito 🛒</a>
        </nav>
    </header>

    <main class="main-content">
        <div class="product-section-title">DONAS</div>
        <div class="product-container">
        <?php
        if ($resultado && $resultado->num_rows > 0) {
            while ($producto = $resultado->fetch_assoc()) {
                echo '<div class="producto-card">';

                echo '<div class="producto-imagen-wrapper">';
                echo '<img src="imagenes/' . htmlspecialchars($producto['imagen']) . '" alt="' . htmlspecialchars($producto['nombre']) . '" class="producto-imagen">';
                echo '</div>';

                echo '<div class="producto-info">';

                echo '<h3 class="producto-nombre">' . htmlspecialchars($producto['nombre']) . '</h3>';

                echo '<p class="producto-desc">' . htmlspecialchars($producto['descripcion']) . '</p>';

                echo '<div class="producto-precio-wrapper">';

                echo '<span class="producto-precio">S/ ' . number_format($producto['precio'], 2) . '</span>';
                echo '</div>';


                echo '<form method="post" action="agregar_al_carrito.php" class="form-agregar-carrito">';
                echo '<input type="hidden" name="id" value="' . $producto['id'] . '">';
                echo '<input type="hidden" name="nombre" value="' . htmlspecialchars($producto['nombre']) . '">';
                echo '<input type="hidden" name="precio" value="' . $producto['precio'] . '">';
                echo '<input type="hidden" name="cantidad" value="1">';
                echo '<button type="submit" class="boton-agregar">AGREGAR</button>';
                echo '</form>';

                echo '</div>'; 
                echo '</div>'; 
            }
        } else {
            echo "<p class='no-productos'>No hay productos disponibles en este momento.</p>";
        }
        $conexion->close();
        ?>
        </div>
    </main>
</body>
<footer class="footer">
    Copyright <?php echo date("Y"); ?>. Dunkin Donuts.
</footer>
</html>