<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != '123456789') {
    header("Location: index.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO secretarias (nombre, cedula, email, password) VALUES (?, ?, ?, ?)");
        try {
            $stmt->execute([$nombre, $cedula, $email, $hashedPassword]);
            $success = "Secretaria registrada exitosamente.";
        } catch (PDOException $e) {
            $error = "Error al registrar la secretaria: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Secretaria</title>
    <link rel="stylesheet" href="css/style_registrar_secretaria.css">
</head>
<body>

    <!-- Barra lateral -->
    <div class="vertical-menu">
        <a href="admin.php">Inicio</a>
        <a href="archivos_pasantia1.php">1-Solicitud de postulación</a>
        <a href="panel.php">2-Carta de aceptación</a>
        <a href="certificado.php">3-Certificación de pasantía</a>
        <a href="registrar.php">Registrar Estudiante</a>
        <a href="registrar_secretaria.php" class="active">Registrar Secretarias</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <!-- Contenido principal -->
    <div class="content">
        <h2>Registrar Secretaria</h2>
        <form method="POST">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Registrar Secretaria</button>
        </form>
    </div>

</body>
</html>
