<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM sales WHERE DATE(created_at) = CURDATE()");
$stmt->execute();
$ventas = $stmt->fetchAll();
?>
<link rel="stylesheet" href="assets/estilos.css" />

<h2>Reporte Diario</h2>
<table>
    <thead>
        <tr><th>Recibo</th><th>Fecha</th><th>Total</th><th>Comentario</th></tr>
    </thead>
    <tbody>
    <?php foreach ($ventas as $venta): ?>
        <tr>
            <td><?= htmlspecialchars($venta['receipt_number']) ?></td>
            <td><?= htmlspecialchars($venta['created_at']) ?></td>
            <td><?= '$' . number_format($venta['total'], 2) ?></td>
            <td><?= htmlspecialchars($venta['comments']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<button onclick="window.location.href='home.php'" class="btn-back">Volver</button>

