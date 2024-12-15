<?php 
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != '123456789') {
    header("Location: index.php");
    exit;
}


require 'db.php';


$searchCedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';
$searchName = isset($_GET['name']) ? $_GET['name'] : '';
$searchEmail = isset($_GET['email']) ? $_GET['email'] : '';

$query = "SELECT * FROM users WHERE cedula != '123456789'";

if ($searchCedula || $searchName || $searchEmail) {
    $query .= " AND (";
    if ($searchCedula) {
        $query .= "cedula LIKE :cedula";
    }
    if ($searchName) {
        if ($searchCedula) $query .= " AND ";
        $query .= "(nombres LIKE :name OR apellidos LIKE :name)";
    }
    if ($searchEmail) {
        if ($searchCedula || $searchName) $query .= " AND ";
        $query .= "email LIKE :email";
    }
    $query .= ")";
}


$stmtStudents = $pdo->prepare($query);

if ($searchCedula) {
    $stmtStudents->bindValue(':cedula', "%$searchCedula%");
}
if ($searchName) {
    $stmtStudents->bindValue(':name', "%$searchName%");
}
if ($searchEmail) {
    $stmtStudents->bindValue(':email', "%$searchEmail%");
}

$stmtStudents->execute();
$students = $stmtStudents->fetchAll(PDO::FETCH_ASSOC);

// Obtener la lista de empresas
$stmtCompanies = $pdo->query("SELECT * FROM empresas");
$companies = $stmtCompanies->fetchAll(PDO::FETCH_ASSOC);

// Obtener la lista de solicitudes de pasantías
$stmtInternships = $pdo->query("
    SELECT i.id, u.nombres, u.apellidos, e.nombre AS empresa, i.estado 
    FROM internships i
    JOIN users u ON i.user_id = u.id
    LEFT JOIN empresas e ON i.empresa_id = e.id
");
$internships = $stmtInternships->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Estudiantes</title>
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

    
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #004080;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #ffa726;
            color: white;
        }

        
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .filters input, .filters select {
            padding: 8px;
            margin-right: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .filters button {
            padding: 10px 15px;
            background-color: #004080;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .filters button:hover {
            background-color: #ffa726;
        }
    </style>
</head>
<body>

    
    <div class="vertical-menu">
        <a href="admin.php" class="active">Inicio</a>
        <a href="panel.php">Insertar Planilla</a>
        <a href="registrar.php">Registrar Estudiante</a>
        <a href="registrar_secret.php">Registrar Secretaria</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>


    <div class="content">
        <h2>Estudiantes</h2>

    
        <div class="filters">
            <form method="GET" action="admin.php">
                <input type="text" name="cedula" placeholder="Cédula" value="<?php echo htmlspecialchars($searchCedula); ?>">
                <input type="text" name="name" placeholder="Nombre o Apellido" value="<?php echo htmlspecialchars($searchName); ?>">
                <input type="email" name="email" placeholder="Correo electrónico" value="<?php echo htmlspecialchars($searchEmail); ?>">
                <button type="submit">Buscar</button>
            </form>
        </div>

    
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['cedula']); ?></td>
                        <td><?php echo htmlspecialchars($student['nombres'] . ' ' . $student['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $student['id']; ?>">Editar</a> |
                            <a href="eliminar.php?id=<?php echo $student['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este estudiante?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
