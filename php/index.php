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
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 50px; /* Tamaño del logo */
            height: auto;
            margin-right: 10px;
        }

        .header h1 {
            font-size: 20px;
            color: #004080; /* Azul marino */
            margin: 0;
        }

        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        
        button {
            background-color: #ffa726; /* Naranja brillante */
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #004080; /* Azul marino */
        }

        
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* Enlace adicional */
        a {
            color: #004080;
            text-decoration: none;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
            color: #ffa726; /* Naranja */
        }

        /* Espaciado entre elementos */
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Título y logo -->
    <div class="header">
        <img src="3.png" alt="Logo"> 
        <h1>Proceso de Inscripción de Pasantes</h1>
        <h2>prueba de git</h2>
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
