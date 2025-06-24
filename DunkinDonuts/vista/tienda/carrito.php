<?php 
$titulo_pagina = "Mi Carrito - DUNKIN'";
require_once BASE_PATH . '/vista/parciales/header_tienda.php'; 
?>

<h1>MI CARRITO</h1>
<?php if (empty($carrito)): ?>
    <p class="empty-message">Tu carrito está vacío.</p>
    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php" class="btn btn-primario">← IR A PRODUCTOS</a>
    </div>
<?php else: ?>
    <div class="carrito-container">
        <div class="carrito-items">
            <table class="carrito-tabla">
                <thead>
                    <tr>
                        <th colspan="2">Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $item): ?>
                    <tr>
                        <td>
                            <img src="imagenes/<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>">
                        </td>
                        <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                        <td>S/ <?php echo number_format($item['precio'], 2); ?></td>
                        <td>
                            <div class="cantidad-control">
                                <form action="index.php?controlador=tienda&accion=actualizarCantidadCarrito" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" name="cambio" value="-1">
                                    <button type="submit" class="btn-ajuste-cantidad">−</button>
                                </form>
                                <span><?php echo $item['cantidad']; ?></span>
                                <form action="index.php?controlador=tienda&accion=actualizarCantidadCarrito" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" name="cambio" value="1">
                                    <button type="submit" class="btn-ajuste-cantidad">＋</button>
                                </form>
                            </div>
                        </td>
                        <td>S/ <?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                        <td>
                            <form action="index.php?controlador=tienda&accion=eliminarDelCarrito" method="POST">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="btn-accion-item" title="Eliminar producto">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <aside class="carrito-resumen">
            <h2>Resumen del Pedido</h2>
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span>Subtotal</span>
                <span>S/ <?php echo number_format($subtotal_carrito, 2); ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span>Costo de envío</span>
                <span>Revisar en el paso Pago</span>
            </div>
            <hr>
            <div style="display: flex; justify-content: space-between; margin-top: 15px; font-weight: bold; font-size: 1.2em;">
                <strong>Total Pedido</strong>
                <strong>S/ <?php echo number_format($subtotal_carrito, 2); ?></strong>
            </div>
            <a href="index.php?controlador=tienda&accion=finalizarCompra" class="btn btn-primario" style="width: 100%; margin-top: 20px;">CONTINUAR LA COMPRA</a>
        </aside>
    </div>
<?php endif; ?>

<?php require_once BASE_PATH . '/vista/parciales/footer_tienda.php'; ?>