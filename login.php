<?php
session_start();
require 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];  // que coincida con el name del input en el form
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    var_dump($user);
    var_dump(password_verify($password, $user['password']));


   if ($user && $password === $user['password']) {
        $_SESSION['user'] = $username;
        header("Location: home.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/estilos.css" />
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" autocomplete="off">
            <input type="text" name="username" placeholder="Usuario" required autofocus />
            <input type="password" name="password" placeholder="Contraseña" required />
            <input type="submit" value="Entrar" />
        </form>
    </div>
</body>
</html>
