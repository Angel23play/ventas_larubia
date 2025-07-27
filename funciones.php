<?php


function formatear_moneda($valor) {
    return '$' . number_format($valor, 2);
}

function generar_numero_recibo($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM sales");
    $count = $stmt->fetchColumn();
    return 'REC-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
}

function verificar_sesion() {
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }
}
?>
