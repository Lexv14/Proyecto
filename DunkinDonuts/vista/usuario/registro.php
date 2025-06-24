<?php 
// Se pasa un título personalizado al header
$titulo_pagina = "Registro de Usuario";
// Se incluye el encabezado estándar de la tienda
require_once BASE_PATH . '/vista/parciales/header_tienda.php'; 
?>

<div class="form-container">
    <h1>📝 REGISTRARSE</h1>

    <?php // Muestra un mensaje de feedback si el controlador lo ha definido[cite: 681]?>
    <?php if (isset($mensaje) && !empty($mensaje)): ?>
        <div class="mensaje-error"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controlador=usuario&accion=procesarRegistro">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
        
        <button type="submit" class="btn btn-primario" style="width:100%; margin-top:15px;">Registrarse</button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php?controlador=usuario&accion=mostrarLogin">¿Ya tienes cuenta? Inicia sesión</a>
        <br>
        <a href="index.php" style="margin-top: 10px; display:inline-block;">← Volver al inicio</a>
    </div>
</div>

<?php 
// Se incluye el pie de página estándar de la tienda
require_once BASE_PATH . '/vista/parciales/footer_tienda.php'; 
?>