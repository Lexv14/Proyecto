<?php
session_start();
session_destroy();
header("Location: productos.php");
exit();
