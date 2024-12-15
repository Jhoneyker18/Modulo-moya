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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
            background-color: #f5f5f5;
        }

        .vertical-menu {
            width: 250px;
            background-color: #004080;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 0;
        }

        .vertical-menu a {
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            border-bottom: 1px solid #003366;
            transition: background 0.3s ease;
        }

        .vertical-menu a:hover {
            background-color: #ffa726;
        }

        .vertical-menu a.active {
            background-color: #ffa726;
            font-weight: bold;
        }

        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        h2 {
            color: #004080;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #004080;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #ffa726;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <!-- Barra lateral -->
    <div class="vertical-menu">
        <a href="admin.php">Inicio</a>
        <a href="panel.php">Insertar Planilla</a>
        <a href="registrar_secretaria.php" class="active">Registrar Secretaria</a>
        <a href="registrar.php">Registrar Estudiante</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <h2>Registrar Secretaria</h2>

        <div class="form-container">
            <?php if ($error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="success"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="cedula">Cédula:</label>
                    <input type="text" id="cedula" name="cedula" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit">Registrar Secretaria</button>
            </form>
        </div>
    </div>

</body>
</html>
