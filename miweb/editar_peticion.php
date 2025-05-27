<?php
// Inicia la sesión para acceder a las variables de sesión
session_start();

// Incluye el archivo de conexión a la base de datos
include("conexion.php");

// Si no hay peticiones en la sesión, redirige a la página principal de peticiones
if (!isset($_SESSION['peticiones'])) {
    header("Location: peticiones.php");
    exit;
}

// Obtiene el índice de la petición desde la URL; si no existe, se usa -1
$index = isset($_GET['index']) ? intval($_GET['index']) : -1;

// Si el índice es inválido o no existe esa petición en la sesión, redirige
if ($index < 0 || !isset($_SESSION['peticiones'][$index])) {
    header("Location: peticiones.php");
    exit;
}

// Obtiene la petición específica del arreglo en sesión
$peticion = $_SESSION['peticiones'][$index];

// Si el formulario fue enviado mediante POST, se procesan los cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se extraen los datos del formulario
    $producto_id = intval($_POST['producto_id']); // ID del producto
    $cantidad = intval($_POST['cantidad']);       // Cantidad solicitada
    $motivo = trim($_POST['motivo']);             // Motivo, sin espacios sobrantes

    // Se consulta la base de datos para obtener nombre e imagen del producto seleccionado
    $sql = $conexion->prepare("SELECT nombre, imagen FROM productos WHERE id = ?");
    $sql->bind_param("i", $producto_id); // Vincula el parámetro como entero
    $sql->execute();
    $resultado = $sql->get_result();
    $producto = $resultado->fetch_assoc();
    $sql->close();

    // Si se encontró el producto y los datos son válidos
    if ($producto && $cantidad > 0 && $motivo !== '') {
        // Se actualiza la petición con los nuevos valores
        $_SESSION['peticiones'][$index] = [
            'producto_id' => $producto_id,
            'nombre' => $producto['nombre'],
            'imagen' => $producto['imagen'],
            'cantidad' => $cantidad,
            'motivo' => $motivo,
        ];
        // Redirige nuevamente a la lista de peticiones
        header("Location: peticiones.php");
        exit;
    } else {
        // Si hay algún error en los datos ingresados, se genera un mensaje
        $error = "Datos inválidos, revisa por favor.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Petición</title>
  <style>
    /* Estilos básicos para la página */
    body { 
      font-family: Arial, sans-serif; 
      padding: 20px; 
    }
    label { 
      display: block; 
      margin-top: 10px; 
    }
    input[type="number"], select, textarea { 
      width: 100%; 
      padding: 8px; 
      margin-top: 5px; }
    button { 
      margin-top: 15px; 
      padding: 10px 15px; 
    }
    .error { 
      color: red; 
    }
  </style>
</head>
<body>

<h2>Editar Petición</h2>

<!-- Si existe un mensaje de error, se muestra aquí -->
<?php if (!empty($error)): ?>
  <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<!-- Formulario de edición -->
<form method="POST" action="">
  <!-- Lista desplegable para elegir el producto -->
  <label for="producto_id">Producto:</label>
  <select id="producto_id" name="producto_id" required>
    <?php
    // Consulta todos los productos de la base de datos
    $productos = $conexion->query("SELECT id, nombre FROM productos");
    // Recorre e imprime cada producto como opción en el select
    while ($prod = $productos->fetch_assoc()) {
        $sel = $prod['id'] == $peticion['producto_id'] ? "selected" : "";
        echo "<option value='{$prod['id']}' $sel>" . htmlspecialchars($prod['nombre']) . "</option>";
    }
    ?>
  </select>

  <!-- Campo para la cantidad solicitada -->
  <label for="cantidad">Cantidad solicitada:</label>
  <input type="number" id="cantidad" name="cantidad" min="1" value="<?= $peticion['cantidad'] ?>" required />

  <!-- Campo para el motivo -->
  <label for="motivo">Motivo de la petición:</label>
  <textarea id="motivo" name="motivo" rows="3" required><?= htmlspecialchars($peticion['motivo']) ?></textarea>

  <!-- Botón para enviar el formulario -->
  <button type="submit">Guardar cambios</button>
  <!-- Enlace para cancelar y volver -->
  <a href="peticiones.php" style="margin-left:10px;">Cancelar</a>
</form>

</body>
</html>