<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Administración</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="form-container">
        <h1>Acceso de Personal</h1>
        
        <?php if (isset($error)): ?>
            <div class="mensaje-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?controlador=admin&accion=procesarLogin" method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" placeholder="Tu nombre de usuario" required>
            
            <label for="clave">Contraseña:</label>
            <input type="password" id="clave" name="clave" placeholder="Tu contraseña" required>
            
            <button type="submit" class="btn btn-primario" style="width:100%;">Entrar</button>
        </form>
    </div>
</body>
</html>