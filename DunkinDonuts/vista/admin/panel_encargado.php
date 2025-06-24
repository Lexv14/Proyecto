<?php require_once BASE_PATH . '/vista/parciales/header_admin.php'; ?>

<h2>Panel del Encargado</h2>

<div class="profile">
    <img src="../imagenes/perfil_predeterminado_empleado.webp" alt="Foto del encargado" style="width:150px; border-radius:50%; margin: 0 auto;"/>
    <h3>Bienvenido, <?php echo htmlspecialchars($_SESSION['admin_usuario']); ?></h3>
    <p>Rol: Encargado</p>
</div>

<?php require_once BASE_PATH . '/vista/parciales/footer_admin.php'; ?>