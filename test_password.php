<?php
$pass_plain = 'tareafacil25';

// Hasheamos la contraseña (igual que en la base de datos)
$pass_hash = password_hash($pass_plain, PASSWORD_DEFAULT);

echo "Hash generado: " . $pass_hash . "<br>";

// Probamos verificar la contraseña
if (password_verify('tareafacil25', $pass_hash)) {
    echo "La contraseña es válida.";
} else {
    echo "La contraseña NO es válida.";
}
?>
