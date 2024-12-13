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
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
            background-color: #f5f5f5; /* Fondo claro */
        }

        
        .vertical-menu {
            width: 250px;
            background-color: #004080; /* Azul marino */
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
            background-color: #ffa726; /* Naranja brillante */
        }

        .vertical-menu a.active {
            background-color: #ffa726; /* Naranja brillante */
            font-weight: bold;
        }

        /* Logo */
        .logo-right {
            position: absolute;
            top: 10px;
            right: 20px;
            width: 80px;
        }

        /* Contenido Principal */
        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        h2 {
            color: #004080; /* Azul marino */
        }

        /* Tablas */
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
            background-color: #004080; /* Azul marino */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Fila alternada */
        }

        tr:hover {
            background-color: #ffa726; /* Naranja brillante */
            color: white;
        }

        a {
            color: #004080; /* Azul */
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: #ffa726; /* Naranja */
        }


        .btn {
            padding: 10px 15px;
            background-color: #004080;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background-color: #ffa726; /* Naranja */
        }

    
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
            background-color: #f5f5f5; /* Fondo claro */
        }

        
        .vertical-menu {
            width: 250px;
            background-color: #004080; /* Azul marino */
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
            background-color: #ffa726; /* Naranja brillante */
        }

        .vertical-menu a.active {
            background-color: #ffa726; /* Naranja brillante */
            font-weight: bold;
        }

        
        .main-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            color: #004080; /* Azul marino */
            margin-bottom: 20px;
        }

        
        form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            border: 2px solid #004080; /* Azul marino */
        }

        form label {
            font-weight: bold;
            color: #004080;
            display: block;
            margin-top: 10px;
        }

        form input,
        form select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #004080; /* Azul marino */
            border-radius: 5px;
            font-size: 14px;
        }

        form button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #004080; /* Azul marino */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        form button:hover {
            background-color: #ffa726; /* Naranja brillante */
        }

    </style>

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
