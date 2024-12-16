<?php
require('config.php');

$tipo       = $_FILES['dataCliente']['type'];
$tamanio    = $_FILES['dataCliente']['size'];
$archivotmp = $_FILES['dataCliente']['tmp_name'];
$lineas     = file($archivotmp);

if ($lineas) {
    $i = 0;
    foreach ($lineas as $linea) {
        if ($i != 0) { // Ignorar la primera línea si es un encabezado
            $datos = explode(";", $linea);
            
            // Asegurarse de que hay suficientes columnas en la línea
            if (count($datos) < 9) {
                continue; // Saltar líneas incompletas
            }

            // Limpiar datos y prevenir inyecciones SQL
            $id         = mysqli_real_escape_string($con, trim($datos[0]));
            $cedula     = mysqli_real_escape_string($con, trim($datos[1]));
            $password   = mysqli_real_escape_string($con, trim($datos[2]));
            $email      = mysqli_real_escape_string($con, trim($datos[3]));
            $carrera    = mysqli_real_escape_string($con, trim($datos[4]));
            $nombres    = mysqli_real_escape_string($con, trim($datos[5]));
            $apellidos  = mysqli_real_escape_string($con, trim($datos[6]));
            $turno      = mysqli_real_escape_string($con, trim($datos[7]));
            $created_at = mysqli_real_escape_string($con, trim($datos[8]));

            // Verificar si el registro con el mismo ID ya existe
            $checkDuplicidad = "SELECT id FROM users WHERE id = '$id'";
            $ca_dupli = mysqli_query($con, $checkDuplicidad);
            $cant_duplicidad = mysqli_num_rows($ca_dupli);

            // Si no existe el registro, insertarlo
            if ($cant_duplicidad == 0) { 
                $insertarData = "INSERT INTO users (
                    id,
                    cedula,
                    password,
                    email,
                    carrera,
                    nombres,
                    apellidos,
                    turno,
                    created_at
                ) VALUES (
                    '$id',
                    '$cedula',
                    '$password',
                    '$email',
                    '$carrera',
                    '$nombres',
                    '$apellidos',
                    '$turno',
                    '$created_at'
                )";

                if (mysqli_query($con, $insertarData)) {
                    echo "Registro insertado correctamente: $id<br>";
                } else {
                    echo "Error al insertar el registro ($id): " . mysqli_error($con) . "<br>";
                }
            } 
            // Si el registro ya existe, actualizarlo
            else {
                $updateData = "UPDATE users SET 
                    cedula = '$cedula',
                    password = '$password',
                    email = '$email',
                    carrera = '$carrera',
                    nombres = '$nombres',
                    apellidos = '$apellidos',
                    turno = '$turno',
                    created_at = '$created_at'
                    WHERE id = '$id'";

                if (mysqli_query($con, $updateData)) {
                    echo "Registro actualizado correctamente: $id<br>";
                } else {
                    echo "Error al actualizar el registro ($id): " . mysqli_error($con) . "<br>";
                }
            }
        }
        $i++;
    }
} else {
    echo "No se pudieron leer las líneas del archivo.<br>";
}
?>

<a href="excel.php">Atrás</a>
