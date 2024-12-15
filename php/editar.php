<?php
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != '123456789') {
    header("Location: index.php");
    exit;
}

require 'db.php';

$editing = false;
$cedula = $email = $carrera = $nombres = $apellidos = $turno = '';

if (isset($_GET['id'])) {
    
    $editing = true;

    
    $id = $_GET['id'];

    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        
        $cedula = $student['cedula'];
        $email = $student['email'];
        $carrera = $student['carrera'];
        $nombres = $student['nombres'];
        $apellidos = $student['apellidos'];
        $turno = $student['turno'];
    } else {
        
        echo "Estudiante no encontrado.";
        exit;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $cedula = trim($_POST['cedula']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);
    $carrera = trim($_POST['carrera']);
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $turno = trim($_POST['turno']);

    
    if ($password !== $confirm_password) {
        die("Las contraseñas no coinciden.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Correo electrónico inválido.");
    }

    if (!preg_match('/^\d{7,9}$/', $cedula)) {
        die("Cédula inválida. Debe tener entre 7 y 9 números.");
    }

    try {
        
        if ($editing) {
            $stmt = $pdo->prepare("
                UPDATE users 
                SET cedula = ?, password = ?, email = ?, carrera = ?, nombres = ?, apellidos = ?, turno = ? 
                WHERE id = ? 
            ");
            $stmt->execute([
                $cedula,
                password_hash($password, PASSWORD_DEFAULT), 
                $email,
                $carrera,
                $nombres,
                $apellidos,
                $turno,
                $id
            ]);
        } else {
            
            $stmt = $pdo->prepare("
                INSERT INTO users (cedula, password, email, carrera, nombres, apellidos, turno) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $cedula,
                password_hash($password, PASSWORD_DEFAULT), 
                $email,
                $carrera,
                $nombres,
                $apellidos,
                $turno
            ]);
        }


        header("Location: admin.php?success=1");
        exit;

    } catch (PDOException $e) {
        die("Error al registrar/actualizar usuario: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $editing ? 'Editar' : 'Registrar'; ?> Usuario</title>
    <link rel="stylesheet" href="css/style_editar.css">
</head>
<body>
    <div class="form-container">
        <h1><?php echo $editing ? 'Editar' : 'Registrar'; ?> Usuario</h1>
        <form method="POST" action="">

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <div class="form-group">
                <label for="cedula">Cédula:</label>
                <input type="text" id="cedula" name="cedula" value="<?php echo htmlspecialchars($cedula); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmar Contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="form-group">
                <label for="carrera">Carrera:</label>
                <input type="text" id="carrera" name="carrera" value="<?php echo htmlspecialchars($carrera); ?>" required>
            </div>

            <div class="form-group">
                <label for="nombres">Nombres:</label>
                <input type="text" id="nombres" name="nombres" value="<?php echo htmlspecialchars($nombres); ?>" required>
            </div>

            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($apellidos); ?>" required>
            </div>

            <div class="form-group">
                <label for="turno">Turno:</label>
                <input type="text" id="turno" name="turno" value="<?php echo htmlspecialchars($turno); ?>" required>
            </div>

            <button type="submit"><?php echo $editing ? 'Actualizar' : 'Registrar'; ?></button>
        </form>
        <a href="admin.php">Volver al Panel</a>
    </div>
</body>
</html>
