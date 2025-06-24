<?php require_once BASE_PATH . '/vista/parciales/header_admin.php'; ?>

<h2>Mensajes Recibidos de Clientes</h2>

<div id="listaMensajes">
    <?php if (empty($mensajes)): ?>
        <p>No hay mensajes disponibles.</p>
    <?php else: ?>
        <?php foreach ($mensajes as $msg): ?>
            <div style="background: #fffde7; border: 1px solid #bcaaa4; margin: 10px 0; padding: 15px; border-radius: 8px;">
                <p><strong>De:</strong> <?php echo htmlspecialchars($msg['nombre']); ?></p>
                <p><strong>Mensaje:</strong> <?php echo htmlspecialchars($msg['mensaje']); ?></p>
                <p style="font-size: 0.9em; color: gray;">Enviado el: <?php echo htmlspecialchars($msg['fecha']); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once BASE_PATH . '/vista/parciales/footer_admin.php'; ?>