<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Planilla</title>
    <style>
        /* Estilo General */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
            background-color: #f5f5f5; /* Fondo claro */
        }

        /* Menú vertical */
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

        /* Contenedor Principal */
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

        /* Estilos del formulario */
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
    <!-- Menú de navegación vertical -->
    <div class="vertical-menu">
        <a href="admin.php" class="active">Inicio</a>
        <a href="panel.php">Insertar Planilla</a>
        <a href="registrar.php">Registrar Estudiante</a>
        <a href="registrar_secret.php" class="active">Gestión de Secretarias</a>
        <a href="certificado.php">Certificado Planilla</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <h1>Insertar los datos del pasante</h1>
        <form method="POST" action="certificado_de_pasantia_pdf.php" target="_blank">
            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" onblur="fetchUserData()" required>

            <label for="carrera">Carrera:</label>
            <select id="carrera" name="carrera" required>
                <option value="turismo">Turismo</option>
                <option value="informatica">Informática</option>
                <option value="publicidad">Publicidad</option>
                <option value="administracion">Administración</option>
            </select>

            <label for="empresa">Empresas recomendadas:</label>
            <select id="empresa" name="empresa" required>
                <option value="Tech Solutions">Tech Solutions</option>
                <option value="EcoTurismo">EcoTurismo</option>
                <option value="Publicidad Creativa">Publicidad Creativa</option>
                <option value="Innova Administración">Innova Administración</option>
            </select>

            <label for="nombre">Nombres:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellidos:</label>
            <input type="text" id="apellido" name="apellido" required>



            <!-- Botones -->
            <button type="submit">Solicitar Planilla</button>
        </form>
    </div>
</body>
</html>
