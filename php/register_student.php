<?php
session_start();
require 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != '123456789') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = trim($_POST['cedula']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);
    $carrera = trim($_POST['carrera']);
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $turno = trim($_POST['turno']);

    // Validaciones
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
        
        $stmt = $pdo->prepare("
            INSERT INTO users (cedula, password, email, carrera, nombres, apellidos, turno) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $cedula,
            password_hash($password, PASSWORD_DEFAULT), // Encriptar contraseña
            $email,
            $carrera,
            $nombres,
            $apellidos,
            $turno,
        ]);

        
        header("Location: admin.php?success=1");
        exit;
    } catch (PDOException $e) {
        die("Error al registrar estudiante: " . $e->getMessage());
    }
}
?>
