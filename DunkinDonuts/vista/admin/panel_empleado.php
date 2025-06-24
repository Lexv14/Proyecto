<?php require_once BASE_PATH . '/vista/parciales/header_admin.php'; ?>

<h2>Panel del Empleado</h2>

<div class="profile">
    <img src="../imagenes/perfil_predeterminado_empleado.webp" alt="Foto del empleado" style="width:150px; border-radius:50%; margin: 0 auto;"/>
    <h3>Bienvenido, <?php echo htmlspecialchars($_SESSION['admin_usuario']); ?></h3>
    <p>Rol: Empleado</p>
</div>

<?php require_once BASE_PATH . '/vista/parciales/footer_admin.php'; ?>