<?php require_once BASE_PATH . '/vista/parciales/header_admin.php'; ?>

<h2>Gestionar Empleados</h2>

<table class="tabla-admin">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($empleados as $empleado): ?>
        <tr>
            <td><?php echo $empleado['id']; ?></td>
            <td><?php echo htmlspecialchars($empleado['usuario']); ?></td>
            <td><?php echo htmlspecialchars($empleado['tipo']); ?></td>
            <td>
                <form action="index.php?controlador=admin&accion=eliminarEmpleado" method="POST" onsubmit="confirmarEliminacion(event, '<?php echo htmlspecialchars($empleado['usuario']); ?>')">
                    <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($empleado['usuario']); ?>">
                    <button type="submit" class="btn btn-peligro">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<hr style="margin: 40px 0;">

<h3>Agregar Nuevo Empleado</h3>
<form class="form-container" style="max-width: none; padding: 20px; box-shadow: none; border: 1px solid #ddd;" action="index.php?controlador=admin&accion=agregarEmpleado" method="POST">
    <label for="usuario">Nombre de Usuario:</label>
    <input type="text" id="usuario" name="usuario" required>
    
    <label for="clave">Clave:</label>
    <input type="password" id="clave" name="clave" required>
    
    <input type="hidden" name="tipo" value="empleado">
    
    <button type="submit" class="btn btn-primario">Agregar Empleado</button>
</form>

<?php require_once BASE_PATH . '/vista/parciales/footer_admin.php'; ?>