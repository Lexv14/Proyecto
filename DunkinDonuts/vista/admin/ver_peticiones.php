<?php require_once BASE_PATH . '/vista/parciales/header_admin.php'; ?>

<h2>Peticiones de Productos de Empleados</h2>

<?php if (empty($peticiones)): ?>
    <p>No hay peticiones pendientes.</p>
<?php else: ?>
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Motivo</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($peticiones as $peticion): ?>
            <tr>
                <td><?php echo htmlspecialchars($peticion['producto_nombre']); ?></td>
                <td><?php echo htmlspecialchars($peticion['cantidad']); ?></td>
                <td><?php echo htmlspecialchars($peticion['motivo']); ?></td>
                <td><?php echo htmlspecialchars($peticion['fecha']); ?></td>
                <td style="display:flex; gap: 5px;">
                    <button class="btn btn-primario" onclick="alert('Funcionalidad no implementada')">Aceptar</button>
                    <button class="btn btn-peligro" onclick="alert('Funcionalidad no implementada')">Rechazar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once BASE_PATH . '/vista/parciales/footer_admin.php'; ?>