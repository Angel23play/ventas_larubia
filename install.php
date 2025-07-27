<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'empanadas_larubia';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        );
        CREATE TABLE IF NOT EXISTS sales (
            id INT AUTO_INCREMENT PRIMARY KEY,
            receipt_number VARCHAR(20) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            comments TEXT,
            total DECIMAL(10,2)
        );
        CREATE TABLE IF NOT EXISTS sale_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sale_id INT NOT NULL,
            product_name VARCHAR(100),
            quantity INT,
            price DECIMAL(10,2),
            subtotal DECIMAL(10,2),
            FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE
        );
    ");

    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    if ($stmt->fetchColumn() == 0) {
        $hash = password_hash('tareafacil25', PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)")
            ->execute(['demo', $hash]);
        echo "Usuario demo creado: demo / tareafacil25<br>";
    } else {
        echo "Ya existe un usuario registrado.<br>";
    }

    echo "Instalación completa. Puedes borrar este archivo por seguridad.";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>