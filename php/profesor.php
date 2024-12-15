<?php
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != '25881881') {
    header("Location: index.php");
    exit;
}

require 'db.php';


$stmtStudents = $pdo->query("SELECT * FROM users WHERE cedula != '25881881'");
$students = $stmtStudents->fetchAll(PDO::FETCH_ASSOC);


$stmtCompanies = $pdo->query("SELECT * FROM empresas");
$companies = $stmtCompanies->fetchAll(PDO::FETCH_ASSOC);


$stmtInternships = $pdo->query("
    SELECT i.id, u.nombres, u.apellidos, e.nombre AS empresa, i.estado 
    FROM internships i
    JOIN users u ON i.user_id = u.id
    LEFT JOIN empresas e ON i.empresa_id = e.id
");
$internships = $stmtInternships->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Navegación Vertical</title>
    <link rel="stylesheet" href="css/style_profesor.css">
<script>
        function fetchUserData() {
            const cedula = document.getElementById('cedula').value;

            if (cedula.trim() !== '') {
                fetch(`get_user_data.php?cedula=${cedula}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('nombre').value = data.nombres;
                            document.getElementById('apellido').value = data.apellidos;
                            document.getElementById('carrera').value = data.carrera;
                        } else {
                            alert(data.message);
                            document.getElementById('nombre').value = '';
                            document.getElementById('apellido').value = '';
                            document.getElementById('carrera').value = '';
                        }
                    })
                    .catch(error => console.error('Error al obtener los datos:', error));
            }
        }
    </script>

    

</head>
<body>

    
    <div class="vertical-menu">
        <a href="profesor.php" class="active">Inicio</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    
    <div class="main-content">
        <h1>Insertar los datos del pasante</h1>
        <form method="POST" action="pdf.php" target="_blank">
            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" onblur="fetchUserData()" required>

            <label for="carrera">Carrera:</label>
            <select id="carrera" name="carrera" required>
                <option value="turismo">Turismo</option>
                <option value="informatica">Informática</option>
                <option value="publicidad">Publicidad</option>
                <option value="administracion">Administración</option>
            </select>

            <label for="nombre">Nombres:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellidos:</label>
            <input type="text" id="apellido" name="apellido" required>

            <button type="submit">Solicitar planilla</button>
        </form>
    </div>

    
    <img src="3.png" alt="Logo" class="logo-right"> 

   

</body>
</html>
