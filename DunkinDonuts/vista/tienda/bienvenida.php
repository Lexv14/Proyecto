<?php 
$titulo_pagina = "¡Bienvenido!";
require_once BASE_PATH . '/vista/parciales/header_tienda.php'; 
?>

<div class="form-container" style="text-align: center;">
    <img src="imagenes/dona1.jpg" alt="Dona" style="max-width: 100px; border-radius: 50%; margin: 0 auto 20px;">
    <h1>👋 ¡Hola, <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?>!</h1>
    <p>Has iniciado sesión correctamente.</p>
    <p>Serás redirigido al inicio en unos segundos...</p>
    <div style="margin-top: 20px; display:flex; justify-content:center; gap: 15px;">
        <a href="index.php" class="btn btn-primario">Ir al inicio</a>
        <a href="index.php?controlador=usuario&accion=cerrarSesion" class="btn btn-secundario">Cerrar sesión</a>
    </div>
</div>

<script>
    setTimeout(() => {
        window.location.href = 'index.php';
    }, 4000);
</script>

<?php require_once BASE_PATH . '/vista/parciales/footer_tienda.php'; ?>