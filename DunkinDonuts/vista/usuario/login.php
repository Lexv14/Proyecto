<?php 
// Se pasa un título personalizado al header
$titulo_pagina = "Iniciar Sesión"; 
// Se incluye el encabezado estándar de la tienda
require_once BASE_PATH . '/vista/parciales/header_tienda.php'; 
?>

<div class="form-container">
    <h1>INICIAR SESIÓN</h1>
    
    <?php // Muestra un mensaje de error si el controlador lo ha definido[cite: 616]?>
    <?php if (isset($mensaje) && !empty($mensaje)): ?>
        <div class="mensaje-error"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controlador=usuario&accion=procesarLogin">
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect ?? ''); ?>">

        <label for="email">Correo electrónico *</label>
        <input type="email" id="email" name="email" placeholder="Ej. nombre@mail.com" required>
        
        <label for="contraseña">Contraseña *</label>
        <div class="password-wrapper">
            <input type="password" id="contraseña" name="contraseña" placeholder="Tu contraseña" required>
            <span class="toggle-password"> 👁️ </span>
        </div>
        
        <button type="submit" class="btn btn-primario" style="width:100%; margin-top: 15px;">INICIAR SESIÓN</button>
    </form>
    
    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php?controlador=usuario&accion=mostrarRegistro">¿No tienes cuenta? Regístrate</a>
        <br>
        <a href="index.php" style="margin-top: 10px; display:inline-block;">← Volver al inicio</a>
    </div>
</div>

<?php 
// Se incluye el pie de página estándar de la tienda
require_once BASE_PATH . '/vista/parciales/footer_tienda.php'; 
?>