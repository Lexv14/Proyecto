<?php 
$titulo_pagina = "Finalizar Compra";
require_once BASE_PATH . '/vista/parciales/header_tienda.php'; 
?>

<div class="contenedor-principal" style="display:flex; gap: 40px; justify-content:center; flex-wrap:wrap;">
    <div class="form-container" style="max-width: 650px;">
        <h1>Finalizar Compra</h1>
        <form method="post" action="index.php?controlador=tienda&accion=procesarCompra">
            <label for="nombre">Nombre completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['usuario_email'] ?? ''); ?>" required>

            <label for="direccion">Dirección de envío:</label>
            <textarea id="direccion" name="direccion" required></textarea>

            <label for="tipo_pago">Método de pago:</label>
            <select id="tipo_pago" name="metodo_pago" required>
                <option value="">-- Selecciona --</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="paypal">PayPal</option>
                <option value="efectivo">Efectivo</option>
            </select>

            <div id="campos_tarjeta" class="extra-fields" style="display:none;">
                <label for="numero_tarjeta">Número de tarjeta:</label>
                <input type="text" id="numero_tarjeta" name="numero_tarjeta" maxlength="16">
                <label for="fecha_expiracion">Fecha de expiración:</label>
                <input type="month" id="fecha_expiracion" name="fecha_expiracion">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" maxlength="4">
            </div>

            <div id="campos_paypal" class="extra-fields" style="display:none;">
                <label for="correo_paypal">Correo de PayPal:</label>
                <input type="email" id="correo_paypal" name="correo_paypal">
            </div>

            <button type="submit" class="btn btn-primario" style="width:100%;">Confirmar compra</button>
        </form>
    </div>

    <div class="map-container" style="width: 650px;">
        <h2>Selecciona tu tienda para recojo</h2>
        <select id="locationSelect">
            <option value="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3900.777672680891!2d-77.00388432313719!3d-12.12735884341021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c7bcee7985b3%3A0xfd1a096a9d8044e3!2sDunkin'%20Donuts!5e0!3m2!1ses-419!2spe!4v1749975995318!5m2!1ses-419!2spe">Dunkin' Donuts, San Borja</option>
            <option value="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3898.613407762406!2d-76.87597522313506!3d-12.274420146184967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105bde49aeaa483%3A0xcefa1428d3f122a1!2sDunkin%20donuts!5e0!3m2!1ses-419!2spe!4v1749976951623!5m2!1ses-419!2spe">Dunkin' Donuts, Lurín</option>
            <option value="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3899.9995145285043!2d-76.94539772313624!3d-12.180435844407736!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105b9e6760b3da3%3A0x8846035cf152ac09!2sDunkin'!5e0!3m2!1ses-419!2spe!4v1749977099288!5m2!1ses-419!2spe">Dunkin', Villa María del Triunfo</option>
        </select>
        <iframe id="mapFrame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3900.777672680891!2d-77.00388432313719!3d-12.12735884341021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c7bcee7985b3%3A0xfd1a096a9d8044e3!2sDunkin'%20Donuts!5e0!3m2!1ses-419!2spe!4v1749975995318!5m2!1ses-419!2spe" style="width:100%; height:450px; border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>

<?php require_once BASE_PATH . '/vista/parciales/footer_tienda.php'; ?>