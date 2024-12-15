<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Planilla</title>
    <link rel="stylesheet" href="css/style_certificado.css">
    
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
        <a href="registrar_secret.php">Gestión de Secretarias</a>
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
