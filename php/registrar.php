<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Estudiante</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5; 
            display: flex;
            flex-direction: row;
        }

        /* Contenedor del menú */
        .vertical-menu {
            width: 250px;
            background-color: #004080; 
            padding: 0;
            margin: 0;
            height: 100vh;
            overflow: auto;
        }

        /* Estilos de los enlaces */
        .vertical-menu a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            border-bottom: 1px solid #003366; /* Línea divisora más oscura */
        }

        .vertical-menu a:hover {
            background-color: #ffa726; 
            color: white;
        }

        .vertical-menu a.active {
            background-color: #ffa726; /* Naranja brillante */
            font-weight: bold;
        }

        
        .content {
            flex: 1;
            padding: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 0 auto;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #004080; /* Azul marino */
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }

        button:hover {
            background-color: #ffa726; /* Naranja brillante */
        }

        h2 {
            text-align: center;
            color: #004080; /* Azul marino */
        }
    </style>
</head>
<body>

    
    <div class="vertical-menu">
        <a href="admin.php" class="active">Inicio</a>
        <a href="panel.php">Insertar Planilla</a>
        <a href="registrar.php">Registrar Estudiante</a>
        <a href="index.php">Cerrar Sesión</a>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <h2>Registrar Estudiante</h2>
        <form method="POST" action="register_student.php">
            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" required>
            <br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <br>
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="carrera">Carrera:</label>
            <select id="carrera" name="carrera" required>
                <option value="turismo">Turismo</option>
                <option value="informatica">Informática</option>
                <option value="publicidad">Publicidad</option>
                <option value="administracion">Administración</option>
            </select>
            <br>
            <label for="empresa">Empresas recomendadas:</label>
            <select id="empresa" name="empresa" required>
                <option value="Tech Solutions">Tech Solutions</option>
                <option value="EcoTurismo">EcoTurismo</option>
                <option value="Publicidad Creativa">Publicidad Creativa</option>
                <option value="Innova Administración">Innova Administración</option>
                <option value="Digital Marketing Pro">Digital Marketing Pro</option>
            </select>    
            <br>
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" required>
            <br>
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required>
            <br>
            <label for="turno">Turno:</label>
            <select id="turno" name="turno" required>
                <option value="mañana">Mañana</option>
                <option value="noche">Noche</option>
                <option value="sabado">Sábados</option>
            </select>
            <br>
            <button type="submit">Registrar Estudiante</button>
        </form>
    </div>


    <script>
document.addEventListener("DOMContentLoaded", function () {
    const cedulaInput = document.getElementById("cedula");
    const nombresInput = document.getElementById("nombres");
    const apellidosInput = document.getElementById("apellidos");

    cedulaInput.addEventListener("blur", function () {
        const cedula = cedulaInput.value.trim();

        if (cedula !== "") {
            // Hacer la solicitud AJAX
            fetch(`cedula.php?cedula=${cedula}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        nombresInput.value = data.nombre;
                        apellidosInput.value = data.apellido;
                    } else {
                        alert(data.message || "No se encontraron datos.");
                    }
                })
                .catch(error => {
                    console.error("Error al consultar la API:", error);
                    alert("Ocurrió un error al consultar la cédula.");
                });
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.querySelector("form");
    const cedulaInput = document.getElementById("cedula");
    const nombresInput = document.getElementById("nombres");
    const apellidosInput = document.getElementById("apellidos");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm_password");

    formulario.addEventListener("submit", function (event) {
        let isValid = true;

        
        const cedula = cedulaInput.value.trim();
        const cedulaRegex = /^[0-9]{6,9}$/; 
        if (!cedulaRegex.test(cedula)) {
            alert("La cédula debe contener solo números y tener entre 6 y 9 caracteres.");
            isValid = false;
        }

    
        const nombres = nombresInput.value.trim();
        const nombresRegex = /^[A-Za-záéíóúÁÉÍÓÚ\s]+$/; 
        if (!nombresRegex.test(nombres)) {
            alert("Los nombres solo deben contener letras.");
            isValid = false;
        }

        
        const apellidos = apellidosInput.value.trim();
        const apellidosRegex = /^[A-Za-záéíóúÁÉÍÓÚ\s]+$/; 
        if (!apellidosRegex.test(apellidos)) {
            alert("Los apellidos solo deben contener letras.");
            isValid = false;
        }

        
        const password = passwordInput.value.trim();
        const confirmPassword = confirmPasswordInput.value.trim();
        if (password !== confirmPassword) {
            alert("Las contraseñas no coinciden.");
            isValid = false;
        }

        
        if (!isValid) {
            event.preventDefault();
        }
    });
});
</script>


</body>
</html>