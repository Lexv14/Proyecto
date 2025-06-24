<?php 
$titulo_pagina = "Nuestras Tiendas";
require_once BASE_PATH . '/vista/parciales/header_tienda.php'; 
?>

<div style="text-align: center;">
    <h1>Ubicación de Nuestras Tiendas</h1>
    <p>Elige en qué lugar deseas comprar:</p>
    
    <select id="locationSelect" style="display: block; margin: 0 auto 20px auto; padding: 10px; font-size: 1rem;">
        <option value="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3900.777672680891!2d-77.00388432313719!3d-12.12735884341021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c7bcee7985b3%3A0xfd1a096a9d8044e3!2sDunkin'%20Donuts!5e0!3m2!1ses-419!2spe!4v1749975995318!5m2!1ses-419!2spe">Dunkin' Donuts, San Borja</option> 
        <option value="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3898.613407762406!2d-76.87597522313506!3d-12.274420146184967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105bde49aeaa483%3A0xcefa1428d3f122a1!2sDunkin%20donuts!5e0!3m2!1ses-419!2spe!4v1749976951623!5m2!1ses-419!2spe">Dunkin' Donuts, Lurín</option> [cite: 420]
        <option value="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3899.9995145285043!2d-76.94539772313624!3d-12.180435844407736!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105b9e6760b3da3%3A0x8846035cf152ac09!2sDunkin'!5e0!3m2!1ses-419!2spe!4v1749977099288!5m2!1ses-419!2spe">Dunkin', Villa María del Triunfo</option> 
    </select>
    
    <div class="map-container" style="max-width: 800px; margin: 0 auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 10px; overflow: hidden;">
        <iframe id="mapFrame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3900.777672680891!2d-77.00388432313719!3d-12.12735884341021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c7bcee7985b3%3A0xfd1a096a9d8044e3!2sDunkin'%20Donuts!5e0!3m2!1ses-419!2spe!4v1749975995318!5m2!1ses-419!2spe" style="width:100%; height:450px; border:0;" allowfullscreen="" loading="lazy"></iframe> 
    </div>
</div>

<?php require_once BASE_PATH . '/vista/parciales/footer_tienda.php'; ?>