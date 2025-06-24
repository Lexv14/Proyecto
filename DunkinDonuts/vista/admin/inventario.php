<?php require_once BASE_PATH . '/vista/parciales/header_admin.php'; ?>

<h2>Gestión de Inventario</h2>

<table class="tabla-admin">
    <thead>
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <form action="index.php?controlador=producto&accion=editarProducto" method="POST">
                <td>
                    <?php echo $producto['id']; ?>
                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                </td>
                <td>
                    <img src="../imagenes/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen">
                    <input type="text" name="imagen" value="<?php echo htmlspecialchars($producto['imagen']); ?>" placeholder="nombre_archivo.jpg">
                </td>
                <td><input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required></td>
                <td><textarea name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea></td>
                <td><input type="number" name="stock" value="<?php echo $producto['stock']; ?>" min="0" required></td>
                <td><input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required></td>
                <td style="display:flex; gap: 5px;">
                    <button type="submit" class="btn btn-primario">Guardar</button>
            </form>
            <form action="index.php?controlador=producto&accion=eliminarProducto" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                <button type="submit" class="btn btn-peligro">Eliminar</button>
            </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<hr style="margin: 40px 0;">

<h3>Agregar Nuevo Producto</h3>
<form class="form-container" style="max-width: none; padding: 20px; box-shadow: none; border: 1px solid #ddd;" action="index.php?controlador=producto&accion=agregarProducto" method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <input type="number" name="stock" placeholder="Stock" min="0" required>
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <input type="text" name="imagen" placeholder="URL de la imagen (ej: dona_nueva.jpg)">
    <button type="submit" class="btn btn-primario">Agregar Producto</button>
</form>

<?php require_once BASE_PATH . '/vista/parciales/footer_admin.php'; ?>