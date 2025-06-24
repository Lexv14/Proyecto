<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Panel de Administración - Dunkin'</title>
</head>
<body style="background-color: #d7ccc8;">
    <div class="admin-container">
        <aside class="sidebar">
            <h3>Panel Dunkin'</h3>
            <?php // El menú cambia según el rol del usuario en la sesión
            if (isset($_SESSION['admin_tipo']) && $_SESSION['admin_tipo'] === 'encargado'): ?>
                <a href="index.php?controlador=admin&accion=mostrarPanelEncargado">Mi Cuenta</a>
                <a href="index.php?controlador=producto&accion=mostrarInventario">Inventario</a>
                <a href="index.php?controlador=peticion&accion=verPeticionesEncargado">Ver Peticiones</a> <a href="index.php?controlador=admin&accion=gestionarUsuarios">Gestionar Empleados</a>
                <a href="index.php?controlador=reporte&accion=mostrarReportes">Reportes de Venta</a>
                <a href="index.php?controlador=admin&accion=cerrarSesion" class="btn btn-peligro" style="margin-top: auto;">Cerrar Sesión</a>
            <?php else: ?>
                <a href="index.php?controlador=admin&accion=mostrarPanelEmpleado">Mi Cuenta</a>
                <a href="index.php?controlador=producto&accion=mostrarInventario">Inventario</a>
                <a href="index.php?controlador=peticion&accion=mostrarFormularioPeticion">Hacer Petición</a>
                <a href="index.php?controlador=admin&accion=verMensajesEmpleado">Mis Mensajes</a> <a href="index.php?controlador=admin&accion=cerrarSesion" class="btn btn-peligro" style="margin-top: auto;">Cerrar Sesión</a>
            <?php endif; ?>
        </aside>
        <main class="main-content">