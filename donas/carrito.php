<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "donas");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$carrito = $_SESSION['carrito'];
$subtotal_carrito = 0;

// Calcular subtotal
foreach ($carrito as $item) {
    $subtotal_carrito += $item['precio'] * $item['cantidad'];
}

$total_pedido_display = $subtotal_carrito;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Carrito - DUNKIN'</title>
    <link rel="stylesheet" href="estilos_carrito.css">
</head>
<body>

<header class="header">
    <div class="header-logo">
        <a href="productos.php">DUNKIN'</a>
    </div>
    <nav class="header-nav">
        <a href="productos.php" class="boton">Volver al inicio 🏠</a>
        <a href="carrito.php" class="boton boton-carrito">Ver carrito 🛒</a>
    </nav>
</header>

<main class="main-content-carrito">
    <h1>MI CARRITO</h1>

    <?php if (empty($carrito)): ?>
        <p class="empty-message">Tu carrito está vacío.</p>
        <div class="acciones-carrito-vacio">
             <a href="productos.php" class="boton-grande-naranja">← IR A PRODUCTOS</a>
        </div>
    <?php else: ?>
        <div class="carrito-container">
            <div class="carrito-items-columna">
                <div class="tabla-carrito">
                    <div class="fila-encabezado">
                        <div class="col-producto">Producto</div>
                        <div class="col-precio">Precio</div>
                        <div class="col-cantidad-header">Cantidad</div>
                        <div class="col-subtotal">Subtotal</div>
                        <div class="col-acciones-header"></div>
                    </div>
                    <?php foreach ($carrito as $index => $producto_item): ?>
                        <?php
                            // Obtener imagen
                            $imagen_url = "imagenes/default_image.png";
                            $nombre_producto_display = htmlspecialchars($producto_item['nombre']);

                            if (isset($producto_item['id'])) {
                                $id_producto_en_carrito = $producto_item['id'];

                                // Imagen
                                $sql_imagen_producto = "SELECT imagen, nombre FROM productos WHERE id = ?";
                                $stmt_imagen = $conexion->prepare($sql_imagen_producto);
                                if ($stmt_imagen) {
                                    $stmt_imagen->bind_param("i", $id_producto_en_carrito);
                                    $stmt_imagen->execute();
                                    $resultado_db_producto = $stmt_imagen->get_result();
                                    if ($producto_db = $resultado_db_producto->fetch_assoc()) {
                                        if (!empty($producto_db['imagen'])) {
                                            $imagen_url = "imagenes/" . htmlspecialchars($producto_db['imagen']);
                                        }
                                    }
                                    $stmt_imagen->close();
                                }

                                // Obtener stock disponible
                                $stock_disponible = 0;
                                $sql_stock = "SELECT stock FROM productos WHERE id = ?";
                                $stmt_stock = $conexion->prepare($sql_stock);
                                if ($stmt_stock) {
                                    $stmt_stock->bind_param("i", $id_producto_en_carrito);
                                    $stmt_stock->execute();
                                    $resultado_stock = $stmt_stock->get_result();
                                    if ($fila_stock = $resultado_stock->fetch_assoc()) {
                                        $stock_disponible = (int)$fila_stock['stock'];
                                    }
                                    $stmt_stock->close();
                                }

                                // Deshabilitar botón "+" si cantidad >= stock
                                $boton_mas_disabled = ($producto_item['cantidad'] >= $stock_disponible) ? 'disabled' : '';
                                $estilo_boton_mas = ($boton_mas_disabled) ? 'style="background-color: #ccc; cursor: not-allowed;"' : '';
                            } else {
                                // Si no hay id, permitir agregar (por defecto)
                                $stock_disponible = 0;
                                $boton_mas_disabled = '';
                                $estilo_boton_mas = '';
                            }
                        ?>
                        <div class="fila-item">
                            <div class="col-producto">
                                <img src="<?= $imagen_url ?>" alt="<?= $nombre_producto_display ?>" class="item-imagen-carrito">
                                <span><?= $nombre_producto_display ?></span>
                            </div>
                            <div class="col-precio">S/ <?= number_format($producto_item['precio'], 2) ?></div>
                            <div class="col-cantidad">
                                <form method="post" action="eliminar_del_carrito.php" class="form-cantidad">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" class="btn-ajuste-cantidad" title="Quitar uno">−</button>
                                </form>
                                <span class="texto-cantidad"><?= $producto_item['cantidad'] ?></span>
                                <form method="post" action="agregar_uno.php" class="form-cantidad">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" class="btn-ajuste-cantidad" title="Agregar uno" <?= $boton_mas_disabled ?> <?= $estilo_boton_mas ?>>＋</button>
                                </form>
                            </div>
                            <div class="col-subtotal">S/ <?= number_format($producto_item['precio'] * $producto_item['cantidad'], 2) ?></div>
                            <div class="col-acciones">
                                <form method="post" action="eliminar_todo.php" class="form-accion-item">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" class="btn-accion-item btn-eliminar" title="Eliminar producto">🗑️</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="productos.php" class="enlace-seguir-comprando">← Seguir comprando</a>
            </div>

            <div class="resumen-pedido-columna">
                <div class="linea-resumen">
                    <span>Subtotal</span>
                    <span>S/ <?= number_format($subtotal_carrito, 2) ?></span>
                </div>
                <div class="linea-resumen">
                    <span>Costo de envío</span>
                    <span>Revisar en el paso Pago</span>
                </div>
                <div class="linea-resumen total-pedido-resumen">
                    <strong>Total Pedido</strong>
                    <strong>S/ <?= number_format($total_pedido_display, 2) ?></strong>
                </div>
                <button type="button" onclick="window.location.href='finalizar_compra.php'" class="btn-continuar-compra">CONTINUAR LA COMPRA</button>
            </div>
        </div>
    <?php endif; ?>
</main>

<footer class="footer">
    Copyright <?php echo date("Y"); ?>. Dunkin Donuts.
</footer>

<?php
$conexion->close();
?>
</body>
</html>
