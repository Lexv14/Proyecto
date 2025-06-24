<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titulo_pagina) ? htmlspecialchars($titulo_pagina) : "Dunkin' Donuts"; ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header class="header">
        <div class="header-logo">
            <a href="index.php">DUNKIN'</a>
        </div>

        <nav class="header-nav">
            <?php if (isset($_SESSION["usuario_nombre"])): ?>
                <span>Hola, <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></span>
                <a href="index.php?controlador=usuario&accion=cerrarSesion" class="btn btn-secundario">Cerrar Sesión</a>
            <?php else: ?>
                <a href="index.php?controlador=usuario&accion=mostrarLogin" class="btn btn-secundario">Iniciar Sesión 🏠</a>
            <?php endif; ?>
            
            <a href="index.php?controlador=tienda&accion=mostrarCarrito" class="btn btn-carrito">Ver Carrito 🛒</a>
        </nav>

        <?php if (isset($contador_visitas)): ?>
        <div class="header-visitas">
            <span>👁️ Visitas: <?php echo $contador_visitas; ?></span>
        </div>
        <?php endif; ?>
    </header>
    <main class="container">