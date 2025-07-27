<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/estilos.css" />
</head>
<body>
    <div class="container">
        <h2>Bienvenido <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Usuario') ?></h2>
        <nav>
            <ul class="menu">
                <li><a href="ventas.php">Registrar venta</a></li>
                <li><a href="reporte.php">Ver reporte diario</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
