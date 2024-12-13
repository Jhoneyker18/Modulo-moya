<?php
require 'db.php';

if (isset($_GET['cedula'])) {
    $cedula = trim($_GET['cedula']);

    
    $stmt = $pdo->prepare("SELECT nombres, apellidos, carrera FROM users WHERE cedula = :cedula");
    $stmt->execute(['cedula' => $cedula]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
    
        echo json_encode([
            'success' => true,
            'nombres' => $user['nombres'],
            'apellidos' => $user['apellidos'],
            'carrera' => $user['carrera']
        ]);
    } else {
        
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró un usuario con la cédula ingresada.'
        ]);
    }
} else {
    
    echo json_encode([
        'success' => false,
        'message' => 'Cédula no proporcionada.'
    ]);
}
?>
