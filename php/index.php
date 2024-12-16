<?php
session_start();
require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'];
    $password = $_POST['password'];

    if ($cedula === '123456789' && $password === 'admin') {
        $_SESSION['user_id'] = $cedula; 
        header("Location: admin.php");
        exit;

    } 

    if ($cedula === '25881881' && $password === 'moya123') {
        $_SESSION['user_id'] = $cedula; 
        header("Location: profesor.php");
        exit;
    }



    
    $stmt = $pdo->prepare("SELECT * FROM secretarias WHERE cedula = ?");
    $stmt = $pdo->prepare("SELECT * FROM users WHERE cedula = ?");
    $stmt->execute([$cedula]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['user_id'] = $user['id'];
        header("Location: estudiante.php");
        exit;
    } else {
        $error = "Cédula o contraseña incorrecta.";
    }

    if ($secretaria && password_verify($password, $secretaria['password'])) {
        header("Location: home_secretaria.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="css/style_index.css">
</head>
<body>
    <!-- Título y logo -->
    <div class="header">
        <img src="3.png" alt="Logo"> 
        <h1>Proceso de Inscripción de Pasantes</h1>
    </div>

    <div class="login-container">
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="cedula">Cédula:</label>
                <input type="text" name="cedula" id="cedula" placeholder="Ingrese su cédula" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" required>
            </div>

            <button type="submit">Iniciar Sesión</button>
        </form>


    </div>
</body>
</html>
