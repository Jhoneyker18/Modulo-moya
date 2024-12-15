<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != '123456789') {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM secretarias");
$secretarias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Secretarias</title>
    <link rel="stylesheet" href="css/style_gestionar_secretaria.css">
</head>
<body>

    <!-- Barra lateral -->
    <div class="vertical-menu">
        <a href="admin.php" class="active">Inicio</a>
        <a href="panel.php">Insertar Planilla</a>
        <a href="registrar.php">Registrar Estudiante</a>
        <a href="registrar_secret.php">Gestión de Secretarias</a>
        <a href="certificado.php">Certificado Planilla</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <h2>Gestionar Secretarias</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cédula</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($secretarias as $secretaria): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($secretaria['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($secretaria['cedula']); ?></td>
                        <td><?php echo htmlspecialchars($secretaria['email']); ?></td>
                        <td>
                            <a href="editar_secretaria.php?id=<?php echo $secretaria['id']; ?>" class="btn">Editar</a>
                            <a href="eliminar_secretaria.php?id=<?php echo $secretaria['id']; ?>" class="btn">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
