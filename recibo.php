<?php
require 'db.php';
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM sales WHERE id = ?");
$stmt->execute([$id]);
$venta = $stmt->fetch();

$stmt = $pdo->prepare("SELECT * FROM sale_items WHERE sale_id = ?");
$stmt->execute([$id]);
$items = $stmt->fetchAll();
?>
<link rel="stylesheet" href="assets/estilos.css" />

<div class="container">
    <h2>Recibo: <?= htmlspecialchars($venta['receipt_number']) ?></h2>
    <p><strong>Fecha:</strong> <?= htmlspecialchars($venta['created_at']) ?></p>
    <p><strong>Comentario:</strong> <?= htmlspecialchars($venta['comments']) ?></p>
    <hr>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td>$<?= number_format($item['subtotal'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total: $<?= number_format($venta['total'], 2) ?></h3>

    <button onclick="window.print()" class="btn-print">Imprimir</button>
</div>
