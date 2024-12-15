<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'secretaria') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Secretaria</title>
</head>
<body>
    <h1>Bienvenida, Secretaria</h1>
    <p>Panel de administración para secretarias.</p>
</body>
</html>
