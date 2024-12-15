<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario con Verificación de Cédula</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: row;
        }

        .vertical-menu {
            width: 250px;
            background-color: hsl(221, 100%, 50%);
            padding: 0;
            margin: 0;
            height: 100vh;
            overflow: auto;
        }

        .vertical-menu a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            border-bottom: 1px solid #444;
        }

        .vertical-menu a:hover {
            background-color: #ff4500;
        }

        .vertical-menu a.active {
            background-color: #ff0000;
        }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            border: 2px solid hsl(221, 100%, 50%);
        }

        form label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: hsl(221, 100%, 50%);
        }

        form input,
        form select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid hsl(221, 100%, 50%);
            border-radius: 5px;
            font-size: 14px;
        }

        form button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: hsl(221, 100%, 50%);
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #ff4500;
        }

        h1 {
            color: hsl(221, 100%, 50%);
        }
    </style>
    <script>
        function fetchUserData() {
            const cedula = document.getElementById('cedula').value;

            if (cedula.trim() !== '') {
                fetch(`get_user_date.php?cedula=${cedula}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Llenar los campos con los datos obtenidos
                            document.getElementById('nombre').value = data.nombres;
                            document.getElementById('apellido').value = data.apellidos;
                            document.getElementById('carrera').value = data.carrera;
                        } else {
                            // Limpiar los campos si no se encuentran los datos
                            alert(data.message);
                            document.getElementById('nombre').value = '';
                            document.getElementById('apellido').value = '';
                            document.getElementById('carrera').value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener los datos:', error);
                        alert('Error al realizar la consulta.');
                    });
            }
        }
    </script>
</head>
<body>
<div class="vertical-menu">
        <a href="admin.php" class="active">Inicio</a>
        <a href="panel.php">Insertar Planilla</a>
        <a href="registrar.php">Registrar Estudiante</a>
        <a href="registrar_secret.php">Gestión de Secretarias</a>
        <a href="certificado.php">Certificado Planilla</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <div class="main-content">
        <h1>Verificar Cédula y Llenar Formulario</h1>
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

            <label for="nombres">Nombres:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellido" name="apellido" required>

            <button type="submit">Solicitar planilla</button>
        </form>
    </div>
</body>
</html>