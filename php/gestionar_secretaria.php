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

        .content {
            flex: 1;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #004080;
            color: white;
        }

        .btn {
            padding: 5px 10px;
            background-color: #ffa726;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>

    <!-- Barra lateral -->
    <div class="vertical-menu">
        <a href="admin.php" class="active">Inicio</a>
        <a href="panel.php">Insertar Planilla</a>
        <a href="registrar.php">Registrar Estudiante</a>
        <a href="registrar_secret.php" class="active">Gestión de Secretarias</a>
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
