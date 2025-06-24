<?php require_once BASE_PATH . '/vista/parciales/header_admin.php'; ?>

<h2>Reportes de Venta</h2>

<div class="form-container" style="max-width: none; padding: 20px; border: 1px solid #ddd;">
    <form id="filtrosReporte" style="display: flex; gap: 20px; align-items: center;">
        <div>
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio">
        </div>
        <div>
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin">
        </div>
        <div>
            <label for="producto_id">Producto:</label>
            <select id="producto_id" name="producto_id">
                <option value="0">-- Todos los productos --</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?php echo $producto['id']; ?>"><?php echo htmlspecialchars($producto['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="button" id="filtrarBtn" class="btn btn-primario" style="align-self: flex-end;">Filtrar</button>
    </form>
</div>

<div style="margin-top: 40px;">
    <canvas id="graficoVentas"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../js/reportes.js"></script>

<?php require_once BASE_PATH . '/vista/parciales/footer_admin.php'; ?>