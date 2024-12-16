<?php
require 'db.php';

if (isset($_GET['cedula'])) {
    $cedula = trim($_GET['cedula']);

    // Actualiza la consulta para incluir los nuevos campos
    $stmt = $pdo->prepare("SELECT nombres, apellidos, carrera, codigo, turno FROM users WHERE cedula = :cedula");
    $stmt->execute(['cedula' => $cedula]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Devuelve todos los datos necesarios
        echo json_encode([
            'success' => true,
            'nombres' => $user['nombres'],
            'apellidos' => $user['apellidos'],
            'carrera' => $user['carrera'],
            'codigo' => $user['codigo'], 
            'turno' => $user['turno']
        ]);
    } else {
        // Mensaje de error si no se encuentra al usuario
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró un usuario con la cédula ingresada.'
        ]);
    }
} else {
    // Mensaje de error si no se envió la cédula
    echo json_encode([
        'success' => false,
        'message' => 'Cédula no proporcionada.'
    ]);
}
?>
