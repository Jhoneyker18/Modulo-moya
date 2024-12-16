<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != '123456789') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Secretarias</title>
    <link rel="stylesheet" href="css/style_registrar_secret.css">
</head>
<body>

    <!-- Barra lateral -->
    <div class="vertical-menu">
    <a href="admin.php" class="active">Inicio</a>
        <a href="archivos_pasantia1.php">1-Modelo de informacion</a>
        <a href="panel.php">2-carta de aceptacion</a>
        <a href="certificado.php">3-certificacion de pasantia</a>
        <a href="registrar.php">Registrar Estudiante</a>
        <a href="registrar_secret.php">Gestión de Secretarias</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <h2>Gestión de Secretarias</h2>
        <a href="registrar_secretaria.php" class="button">Registrar Secretaria</a>
        <a href="gestionar_secretaria.php" class="button">Gestionar Secretarias</a>
    </div>

</body>
</html>
