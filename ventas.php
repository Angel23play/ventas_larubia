<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productos = $_POST['producto'];
    $cantidades = $_POST['cantidad'];
    $precios = $_POST['precio'];
    $comentarios = $_POST['comentario'];
    $total = 0;

    foreach ($productos as $i => $producto) {
        $subtotal = $cantidades[$i] * $precios[$i];
        $total += $subtotal;
    }

    $stmt = $pdo->query("SELECT COUNT(*) FROM sales");
    $numero = str_pad($stmt->fetchColumn() + 1, 3, "0", STR_PAD_LEFT);
    $recibo = "REC-$numero";

    $stmt = $pdo->prepare("INSERT INTO sales (receipt_number, comments, total) VALUES (?, ?, ?)");
    $stmt->execute([$recibo, $comentarios, $total]);
    $sale_id = $pdo->lastInsertId();

    foreach ($productos as $i => $producto) {
        $cantidad = $cantidades[$i];
        $precio = $precios[$i];
        $subtotal = $cantidad * $precio;

        $stmt = $pdo->prepare("INSERT INTO sale_items (sale_id, product_name, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$sale_id, $producto, $cantidad, $precio, $subtotal]);
    }

    header("Location: recibo.php?id=" . $sale_id);
    exit();
}
?>
<link rel="stylesheet" href="assets/estilos.css" />

<form method="post">
    <h2>Registrar Venta</h2>
    <div id="items">
        <div>
            <input type="text" name="producto[]" placeholder="Producto" required>
            <input type="number" name="cantidad[]" placeholder="Cantidad" required>
            <input type="number" step="0.01" name="precio[]" placeholder="Precio" required>
        </div>
    </div>
    <button type="button" onclick="agregarItem()">Agregar otro</button><br><br>
    <textarea name="comentario" placeholder="Comentario (opcional)"></textarea><br>
    <button type="submit">Guardar venta</button>
    <button onclick="window.location.href='home.php'" class="btn-back">Volver</button>

</form>

<script>
function agregarItem() {
    let div = document.createElement("div");
    div.innerHTML = '<input type="text" name="producto[]" placeholder="Producto" required> <input type="number" name="cantidad[]" placeholder="Cantidad" required> <input type="number" step="0.01" name="precio[]" placeholder="Precio" required>';
    document.getElementById("items").appendChild(div);
}
</script>