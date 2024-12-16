<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Excel</title>
    <link rel="stylesheet" href="css/style_importar.css">
    
</head>
<body>
    
    <h1>Importar Estudiantes desde Excel</h1>
    <div class="instructions">
        <h2>Instrucciones:</h2>
        <ol>
            <li>El archivo debe estar en formato <strong>.xlsx</strong> o <strong>.xls</strong>.</li>
            <li>Asegúrate de que el archivo contiene las siguientes columnas en este orden exacto:
                <ul>
                    <li><strong>cedula</strong> (máximo 9 caracteres, sin espacios ni guiones)</li>
                    <li><strong>password</strong> (la contraseña para el usuario)</li>
                    <li><strong>email</strong> (dirección de correo electrónico única)</li>
                    <li><strong>carrera</strong> (una de las siguientes: <em>turismo, informatica, publicidad, administración</em>)</li>
                    <li><strong>nombres</strong> (máximo 50 caracteres)</li>
                    <li><strong>apellidos</strong> (máximo 50 caracteres)</li>
                    <li><strong>turno</strong> (una de las siguientes: <em>mañana, noche, sábado</em>)</li>
                    <li><strong>codigo</strong> (código numérico único)</li>
                    <li><strong>telefono</strong> (máximo 12 dígitos,  solo un guion; ejemplo: 0000-0000000)</li>
                </ul>
            </li>
            <li>No dejes campos vacíos en ninguna fila.</li>
            <li>Verifica que no haya duplicados en las columnas <strong>cedula</strong> y <strong>email</strong>.</li>
            <li>Guarda los cambios en tu archivo antes de subirlo.</li>
        </ol>
        <p><strong>Nota:</strong> Si hay errores en el archivo, el sistema notificará las filas con problemas y no se insertarán.</p>
    </div>

    <div class="filters">
        <form method="POST" action="importar_estudiantes.php" enctype="multipart/form-data">
            <input type="file" name="archivo_excel" accept=".xlsx, .xls" required>
            <button type="submit">Importar</button>
        </form>
    </div>
</body>
</html>
