<?php
session_start();                    // Inicia la sesión para almacenar peticiones en $_SESSION
include("conexion.php");            // Incluye el archivo de conexión a la base de datos

// Si no existe el array 'peticiones' en sesión, lo inicializa vacío
if (!isset($_SESSION['peticiones'])) {
    $_SESSION['peticiones'] = [];
}

// Cuando se envía el formulario de agregar petición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_peticion'])) {
    // Captura y valida los datos del formulario
    $producto_id = intval($_POST['producto_id']);    // ID del producto (convertido a entero)
    $cantidad    = intval($_POST['cantidad']);       // Cantidad solicitada (entero)
    $motivo      = trim($_POST['motivo']);           // Motivo de la petición (sin espacios innecesarios)

    // Prepara consulta para obtener nombre e imagen del producto
    $sql = $conexion->prepare("SELECT nombre, imagen FROM productos WHERE id = ?");
    $sql->bind_param("i", $producto_id);
    $sql->execute();
    $resultado = $sql->get_result();
    $producto = $resultado->fetch_assoc();           // Obtiene el registro del producto
    $sql->close();                                   // Cierra la consulta preparada

    // Si existe el producto y los datos son válidos, lo añade al array de sesión
    if ($producto && $cantidad > 0 && $motivo !== '') {
        $_SESSION['peticiones'][] = [
            'producto_id' => $producto_id,            // ID del producto
            'nombre'      => $producto['nombre'],     // Nombre del producto
            'imagen'      => $producto['imagen'],     // URL de la imagen
            'cantidad'    => $cantidad,               // Cantidad solicitada
            'motivo'      => $motivo,                 // Motivo de la petición
        ];
    }
    header("Location: peticiones.php");              // Redirige para evitar reenvío de formulario
    exit;
}

// Cuando se solicita eliminar una petición (por parámetro GET)
if (isset($_GET['eliminar'])) {
    $index = intval($_GET['eliminar']);              // Índice de la petición a eliminar
    if (isset($_SESSION['peticiones'][$index])) {
        array_splice($_SESSION['peticiones'], $index, 1); // Remueve la petición del array
    }
    header("Location: peticiones.php");              // Redirige para refrescar la lista
    exit;
}

// Cuando se envía la solicitud final al encargado
if (isset($_POST['enviar_solicitud'])) {
    // Aquí podrías guardar en base de datos o enviar un correo
    $_SESSION['peticiones'] = [];                    // Limpia todas las peticiones de la sesión
    $mensaje = "¡Solicitud enviada correctamente!";  // Mensaje de confirmación
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Petición de Productos</title>
<!-- Estilos básicos para la página -->
<style>
  body { 
    font-family: Arial, sans-serif; 
    padding: 20px; }
  form { 
    margin-bottom: 30px; 
  }
  label { 
    display: block; 
    margin-top: 10px; 
  }
  input[type="number"], select, textarea { 
    width: 100%; 
    padding: 8px; 
    margin-top: 5px; 
  }
  button { 
    margin-top: 15px; 
    padding: 10px 15px; 
  }
  .peticion-card {
    border: 1px solid #ccc; 
    padding: 15px; 
    margin-bottom: 15px;
    display: flex; 
    gap: 15px; 
    align-items: center;
  }
  .peticion-card img {
    width: 80px; 
    height: 80px; 
    object-fit: contain;
  }
  .peticion-info { 
    flex-grow: 1; 
  }
  .peticion-info p { 
    margin: 5px 0; 
  }
  .acciones { 
    display: flex; 
    flex-direction: column; 
    gap: 5px; 
  }
  .mensaje {
    padding: 10px; 
    background-color: #d4edda;
    color: #155724; 
    margin-bottom: 20px; 
    border-radius: 4px;
  }
</style>
</head>
<body>

<h2>Petición de Productos</h2>

<!-- Muestra mensaje de confirmación si existe -->
<?php if (!empty($mensaje)): ?>
  <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<!-- Formulario para agregar una nueva petición -->
<form method="POST" action="peticiones.php">
  <label for="producto_id">Producto:</label>
  <select id="producto_id" name="producto_id" required>
    <option value="">-- Seleccione un producto --</option>
    <?php
    // Consulta todos los productos para poblar el select
    $productos = $conexion->query("SELECT id, nombre FROM productos");
    while ($prod = $productos->fetch_assoc()) {
        // Opciones con valor=ID y texto=Nombre del producto
        echo "<option value='{$prod['id']}'>" . htmlspecialchars($prod['nombre']) . "</option>";
    }
    ?>
  </select>

  <label for="cantidad">Cantidad solicitada:</label>
  <input type="number" id="cantidad" name="cantidad" min="1" required />

  <label for="motivo">Motivo de la petición:</label>
  <textarea id="motivo" name="motivo" rows="3" required></textarea>

  <!-- Botón para añadir la petición a la lista en sesión -->
  <button type="submit" name="agregar_peticion">Agregar petición</button>
</form>

<h3>Petición actual</h3>

<!-- Si no hay peticiones en sesión, muestra texto -->
<?php if (empty($_SESSION['peticiones'])): ?>
  <p>No hay peticiones agregadas.</p>

<!-- Si hay peticiones, las recorre y muestra en tarjetas -->
<?php else: ?>
  <?php foreach ($_SESSION['peticiones'] as $i => $pet): ?>
    <div class="peticion-card">
      <!-- Imagen del producto -->
      <img src="<?= htmlspecialchars($pet['imagen']) ?>" alt="<?= htmlspecialchars($pet['nombre']) ?>" />
      <div class="peticion-info">
        <!-- Datos de la petición -->
        <p><strong>Producto:</strong> <?= htmlspecialchars($pet['nombre']) ?></p>
        <p><strong>Cantidad:</strong> <?= $pet['cantidad'] ?></p>
        <p><strong>Motivo:</strong> <?= htmlspecialchars($pet['motivo']) ?></p>
      </div>
      <div class="acciones">
        <!-- Enlace para editar la petición (redirige a editar_peticion.php) -->
        <a href="editar_peticion.php?index=<?= $i ?>">Editar</a>
        <!-- Enlace para eliminar la petición (envía índice por GET) -->
        <a href="peticiones.php?eliminar=<?= $i ?>" onclick="return confirm('¿Eliminar esta petición?')">Eliminar</a>
      </div>
    </div>
  <?php endforeach; ?>

  <!-- Formulario para enviar todas las peticiones al encargado -->
  <form method="POST" action="peticiones.php">
    <button type="submit" name="enviar_solicitud">Enviar solicitud al encargado</button>
  </form>
<?php endif; ?>

</body>
</html>