<?php 
$titulo_pagina = "Productos - DUNKIN'"; 
require_once BASE_PATH . '/vista/parciales/header_tienda.php'; 
?>

<div class="product-section-title">DONAS</div>
<div class="product-container">
    <?php if (empty($productos)): ?>
        <p class='no-productos'>No hay productos disponibles en este momento.</p>
    <?php else: ?>
        <?php foreach ($productos as $producto): ?>
            <div class="producto-card">
                <img src="imagenes/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="producto-imagen">
                <div class="producto-info">
                    <h3 class="producto-nombre"><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                    <p class="producto-desc"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <div class="producto-precio-wrapper">
                        <span class="producto-precio">S/ <?php echo number_format($producto['precio'], 2); ?></span>
                    </div>
                    <form method="post" action="index.php?controlador=tienda&accion=agregarAlCarrito" class="form-agregar-carrito">
                        <input type="hidden" name="imagen" value="<?php echo htmlspecialchars($producto['imagen']); ?>">
                        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                        <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
                        <input type="hidden" name="cantidad" value="1">
                        <button type="submit" class="btn btn-primario">AGREGAR</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="chat-icon"> 💬 </div>
<div class="chat-popup" id="chatPopup">
    <form id="chatForm" method="post" action="index.php?controlador=tienda&accion=guardarMensajeChat">
        <h3>¿Tienes dudas? Pregúntanos</h3>
        <input type="text" name="nombre" placeholder="Tu nombre" required>
        <textarea name="mensaje" placeholder="Escribe tu consulta..." required></textarea>
        <button type="submit" class="btn btn-primario">Enviar</button>
    </form>
</div>

<?php require_once BASE_PATH . '/vista/parciales/footer_tienda.php'; ?>