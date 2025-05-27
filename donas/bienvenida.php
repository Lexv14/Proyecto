<?php 
session_start(); 

if (!isset($_SESSION["usuario_id"])) {  
    header("Location: login.php");  
    exit(); 
}  
?>   
   
<!DOCTYPE html>  
<html lang="es">  
<head> 
    <meta charset="UTF-8"> 
    <title>Bienvenida</title>

    <style>
        /* --- Reset y estilos globales --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* --- Body --- */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            min-height: 100vh;
            position: relative;
        }

        /* --- Contenedor principal centrado --- */
        .bienvenida-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);

            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* --- Imagen de bienvenida --- */
        .bienvenida-container img {
            display: block;
            margin: 0 auto 20px;
            max-width: 100px;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* --- Título --- */
        .bienvenida-container h1 {
            font-size: 24px;
            font-weight: 700;
            color: #333333;
            margin-bottom: 15px;
        }

        /* --- Párrafos informativos --- */
        .bienvenida-container p {
            font-size: 14px;
            color: #555555;
            margin-bottom: 10px;
        }

        /* --- Botones / enlaces --- */
        .bienvenida-container .botones {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .bienvenida-container .botones a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff6600;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px; 
            transition: background-color 0.2s ease-in-out; 
            text-transform: uppercase; 
        }

        .bienvenida-container .botones a:hover {
            background-color: #e65c00;
        }
    </style>

    <script>
        // Redirige a productos.php luego de 4 segundos
        setTimeout(() => {
            window.location.href = 'productos.php';
        }, 4000);
    </script>
</head> 
<body> 
    <div class="bienvenida-container"> 
        <img src="imagenes/dona1.jpg" alt="Dona"> 
        <h1>👋 ¡Hola, <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?>!</h1> 
        <p>Has iniciado sesión correctamente.</p> 
        <p>Serás redirigido al inicio en unos segundos...</p> 

        <div class="botones"> 
            <a href="productos.php">Ir al inicio</a> 
            <a href="logout.php">Cerrar sesión</a> 
        </div> 
    </div> 
</body>
</html>
