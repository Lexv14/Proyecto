<?php require_once BASE_PATH . '/vista/parciales/header_admin.php'; ?>

<h2>Petición de Productos</h2>

<?php if (isset($_GET['status']) && $_GET['status'] === 'enviado'): ?>
    <div class="mensaje-exito">¡Solicitud enviada correctamente al encargado!</div>
<?php endif; ?>

<div class="form-container" style="max-width: none; padding: 20px; box-shadow: none; border: 1px solid #ddd;">
    <h3>Agregar Producto a la Petición</h3>
    <form action="index.php?controlador=peticion&accion=agregarPeticionTemporal" method="POST">
        <label for="producto_id">Producto:</label>
        <select id="producto_id" name="producto_id" required>
            <option value="">-- Seleccione un producto --</option>
            <?php foreach ($productos as $prod): ?>
                <option value="<?php echo $prod['id']; ?>"><?php echo htmlspecialchars($prod['nombre']); ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="cantidad">Cantidad solicitada:</label>
        <input type="number" id="cantidad" name="cantidad" min="1" required />
        
        <label for="motivo">Motivo de la petición:</label>
        <textarea id="motivo" name="motivo" rows="3" required></textarea>
        
        <button type="submit" class="btn btn-secundario">Agregar a la lista</button>
    </form>
</div>

<hr style="margin: 40px 0;">

<h3>Petición Actual</h3>
<?php if (empty($peticiones_actuales)): ?>
    <p>No hay productos en la petición actual.</p>
<?php else: ?>
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Motivo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($peticiones_actuales as $index => $peticion): ?>
            <tr>
                <td><?php echo htmlspecialchars($peticion['nombre']); ?></td>
                <td><?php echo htmlspecialchars($peticion['cantidad']); ?></td>
                <td><?php echo htmlspecialchars($peticion['motivo']); ?></td>
                <td>
                    <a href="index.php?controlador=peticion&accion=eliminarPeticionTemporal&index=<?php echo $index; ?>" 
                       class="btn btn-peligro" 
                       onclick="confirmarEliminacionPeticion(event)">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <form action="index.php?controlador=peticion&accion=enviarPeticiones" method="POST" style="margin-top: 20px;">
        <button type="submit" class="btn btn-primario">Enviar Solicitud al Encargado</button>
    </form>
<?php endif; ?>

<?php require_once BASE_PATH . '/vista/parciales/footer_admin.php'; ?>