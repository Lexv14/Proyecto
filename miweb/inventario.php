<?php
// Incluye la conexión a la base de datos (conexion.php establece $conexion)
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inventario de Donas - Empleado</title>
  <!-- Estilos CSS de la página de inventario -->
  <style>
    /* Estilo general del body: fuente, fondo, colores y centrado */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #d7ccc8;           /* Fondo igual al panel del encargado */
      color: #3e2723;                /* Color principal de texto */
      margin: 0;
      padding: 40px;
      display: flex;
      flex-direction: column;        /* Elementos en columna */
      align-items: center;           /* Centrado horizontal */
      min-height: 100vh;             /* Altura mínima de pantalla */
      box-sizing: border-box;        /* Incluye padding en tamaño */
    }

    /* Contenedor principal blanco */
    .container {
      background: #ffffff;
      padding: 30px 50px;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      max-width: 1100px;
      width: 100%;
      box-sizing: border-box;
    }

    /* Estilo de títulos h2 y h3 */
    h2, h3 {
      color: #3e2723;                /* Color marrón oscuro */
      text-align: center;
      margin-bottom: 35px;
      letter-spacing: 0.5px;
    }
    h2 {
      font-size: 2.2em;              /* Tamaño grande para título principal */
    }
    h3 {
      font-size: 1.8em;              /* Tamaño mediano para subtítulos */
      margin-top: 40px;
      border-bottom: 2px solid #bcaaa4;  /* Línea inferior para separar secciones */
      padding-bottom: 10px;
    }

    /* Tabla de inventario */
    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      margin-bottom: 30px;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    /* Celdas de encabezado y datos */
    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #efebe9;
    }
    /* Encabezados con fondo amarillo */
    th {
      background-color: #fbc02d;
      color: #3e2723;
      font-weight: bold;
      text-transform: uppercase;
      font-size: 0.9em;
    }
    /* Filas de datos con fondo crema */
    td {
      background-color: #fffde7;
      color: #5d4037;
    }
    /* Hover más claro en filas */
    tr:hover td {
      background-color: #fffbe5;
    }

    /* Estilos para inputs y textarea dentro de la tabla */
    input[type="text"],
    input[type="number"],
    textarea {
      width: calc(100% - 16px);
      padding: 12px;
      margin: 5px 0;
      box-sizing: border-box;
      border: 1px solid #bcaaa4;
      border-radius: 6px;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      font-size: 1em;
      color: #3e2723;
    }
    textarea {
      resize: vertical;
      min-height: 80px;     /* Altura mínima */
      height: 80px;         /* Altura fija */
    }
    /* Efecto al enfocar campos */
    input[type="text"]:focus,
    input[type="number"]:focus,
    textarea:focus {
      border-color: #fbc02d;                   /* Borde amarillo */
      box-shadow: 0 0 0 3px rgba(251, 192, 45, 0.2);
      outline: none;
    }

    /* Botones generales */
    button {
      padding: 10px 18px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      color: white;
      font-weight: bold;
      transition: background-color 0.3s ease, transform 0.2s ease;
      font-size: 0.95em;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    /* Botones de guardar dentro de la tabla */
    button[type="submit"] {
      background-color: #e65100;   /* Naranja */
      margin-top: 10px;
    }
    button[type="submit"]:hover {
      background-color: #ff8f00;
      transform: translateY(-1px);
    }

    /* Botón para agregar nuevo producto */
    .add-btn {
      background-color: #e65100;
    }
    .add-btn:hover {
      background-color: #ff8f00;
      transform: translateY(-1px);
    }

    /* Botón de regreso a la cuenta */
    .back-btn {
      display: inline-block;
      margin-bottom: 30px;
      padding: 14px 25px;
      background-color: #6d4c41;  /* Marrón */
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .back-btn:hover {
      background-color: #8d6e63;
      transform: translateY(-2px);
    }

    /* Miniatura de imagen dentro de la tabla */
    img {
      display: block;
      max-width: 90px;
      height: auto;
      margin-top: 8px;
      border-radius: 4px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Formularios inline dentro de td */
    form {
      display: flex;
      align-items: flex-end;
      gap: 15px;
      flex-wrap: wrap;
    }
    /* Ajuste específico para formularios de agregar producto */
    form.add-product-form {
      justify-content: flex-start;
      margin-top: 30px;
      padding: 20px;
      background-color: #fffbe7;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    form.add-product-form input,
    form.add-product-form textarea {
      flex: 1;
      min-width: 180px;
    }
    form.add-product-form button {
      flex-grow: 0;
      min-width: 120px;
    }

    /* Botón Eliminar dentro de tabla */
    td form + form button {
      background-color: #c62828;  /* Rojo */
      margin-left: 8px;
    }
    td form + form button:hover {
      background-color: #ef5350;
    }
  </style>
</head>

<body>
  <!-- Enlace para volver al panel de la cuenta de empleado -->
  <a href="empleado.html" class="back-btn">← Regresar a Cuenta</a>

  <!-- Título principal -->
  <h2>Inventario de Donas</h2>

  <!-- Tabla que muestra los productos -->
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Descripción</th>
      <th>Stock</th>
      <th>Precio</th>
      <th>Imagen</th>
      <th>Acciones</th>
    </tr>
    <?php
    // Consulta todos los productos de la tabla 'productos'
    $sql = "SELECT * FROM productos";
    $resultado = $conexion->query($sql);

    // Genera una fila por cada producto encontrado
    while ($fila = $resultado->fetch_assoc()) {
      echo "<tr>
        <td>{$fila['id']}</td>
        <td>
          <!-- Formulario para editar nombre -->
          <form action='editar_producto.php' method='POST' style='margin:0;'>
            <input type='hidden' name='id' value='{$fila['id']}'>
            <input type='text' name='nombre' value='".htmlspecialchars($fila['nombre'], ENT_QUOTES)."' required>
        </td>
        <td>
            <!-- Textarea para editar descripción -->
            <textarea name='descripcion' required>"
            .htmlspecialchars($fila['descripcion'], ENT_QUOTES).
            "</textarea>
        </td>
        <td>
            <!-- Input para editar stock -->
            <input type='number' name='stock' value='{$fila['stock']}' min='0' required>
        </td>
        <td>
            <!-- Input para editar precio -->
            <input type='number' step='0.01' name='precio' value='{$fila['precio']}' required>
        </td>
        <td>
            <!-- Input para editar URL de imagen -->
            <input type='text' name='imagen' value='"
            .htmlspecialchars($fila['imagen'], ENT_QUOTES).
            "'><br>";
      // Muestra la imagen si existe URL
      if (!empty($fila['imagen'])) {
        echo "<img src='{$fila['imagen']}' alt='Imagen' width='80'>";
      }
      echo "</td>
        <td>
            <!-- Botón Guardar edición -->
            <button type='submit'>Guardar</button>
          </form>
          <!-- Formulario para eliminar producto -->
          <form action='eliminar_producto.php' method='POST' style='display:inline; margin-left:5px;'>
            <input type='hidden' name='id' value='{$fila['id']}'>
            <button type='submit' onclick='return confirm(\"¿Eliminar este producto?\")'>Eliminar</button>
          </form>
        </td>
      </tr>";
    }
    ?>
  </table>

  <!-- Sección para agregar un nuevo producto -->
  <h3>Agregar nuevo producto</h3>
  <form action="agregar_producto.php" method="POST">
    <!-- Campos de nombre y descripción -->
    <input type="text" name="nombre" placeholder="Nombre" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <!-- Campo de stock -->
    <input type="number" name="stock" placeholder="Stock" min="0" required>
    <!-- Campo de precio -->
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <!-- Campo de URL de imagen -->
    <input type="text" name="imagen" placeholder="URL imagen">
    <!-- Botón para enviar la nueva entrada -->
    <button type="submit" class="add-btn">Agregar</button>
  </form>
</body>
</html>