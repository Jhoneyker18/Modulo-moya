<?php
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != '123456789') {
    header("Location: index.php");
    exit;
}

require 'db.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
    
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        
        header("Location: admin.php?deleted=1");
        exit;

    } catch (PDOException $e) {
        
        die("Error al eliminar el usuario: " . $e->getMessage());
    }
} else {
    
    header("Location: admin.php");
    exit;
}
?>
