<?php 
$titulo_pagina = "Gracias por tu compra";
require_once BASE_PATH . '/vista/parciales/header_tienda.php'; 
?>

<div class="form-container" style="text-align: center;">
    <h2>¡Gracias por tu compra, <?php echo htmlspecialchars($nombre); ?>!</h2>
    <p>Te enviaremos confirmación a <strong><?php echo htmlspecialchars($email); ?></strong>.</p>
    <a href="index.php" class="btn btn-primario">Volver a la tienda</a>
    <p>Serás redirigido al inicio en unos segundos...</p>
</div>

<script>
    setTimeout(() => {
        window.location.href = 'index.php';
    }, 4000);
</script>

<?php require_once BASE_PATH . '/vista/parciales/footer_tienda.php'; ?>