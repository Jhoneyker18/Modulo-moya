<?php
require 'db.php';
require 'libs/vendor/autoload.php'; // Asegúrate de instalar PhpSpreadsheet usando Composer.

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo_excel'])) {
    $archivo = $_FILES['archivo_excel'];

    // Validar que el archivo sea Excel o CSV
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    if (!in_array($extension, ['xlsx', 'csv'])) {
        die('Formato de archivo no válido. Solo se aceptan archivos .xlsx o .csv.');
    }

    // Cargar el archivo
    $spreadsheet = IOFactory::load($archivo['tmp_name']);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    // Validar e insertar registros
    $errores = [];
    $insertados = 0;

    foreach ($data as $index => $fila) {
        if ($index === 0) continue; // Saltar encabezados

        [$cedula, $password, $email, $carrera, $nombres, $apellidos, $turno, $codigo, $telefono] = $fila;

        // Validar campos obligatorios
        if (empty($cedula) || empty($password) || empty($email) || empty($carrera) || empty($nombres) ||
            empty($apellidos) || empty($turno) || empty($codigo) || empty($telefono)) {
            $errores[] = "Fila $index: campos obligatorios faltantes.";
            continue;
        }

        // Validar valores específicos
        if (!in_array($carrera, ['turismo', 'informatica', 'publicidad', 'administracion'])) {
            $errores[] = "Fila $index: carrera inválida.";
            continue;
        }
        if (!in_array($turno, ['mañana', 'noche', 'sabado'])) {
            $errores[] = "Fila $index: turno inválido.";
            continue;
        }

        // Validar unicidad de cedula y email
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE cedula = :cedula OR email = :email");
        $stmt->execute(['cedula' => $cedula, 'email' => $email]);
        if ($stmt->fetchColumn() > 0) {
            $errores[] = "Fila $index: cédula o email ya registrado.";
            continue;
        }

        // Insertar en la base de datos
        $stmt = $pdo->prepare("
            INSERT INTO users (cedula, password, email, carrera, nombres, apellidos, turno, codigo, telefono)
            VALUES (:cedula, :password, :email, :carrera, :nombres, :apellidos, :turno, :codigo, :telefono)
        ");
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $params = [
            'cedula' => $cedula,
            'password' => $passwordHash,
            'email' => $email,
            'carrera' => $carrera,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'turno' => $turno,
            'codigo' => $codigo,
            'telefono' => $telefono,
        ];

        if ($stmt->execute($params)) {
            $insertados++;
        } else {
            $errores[] = "Fila $index: error al insertar el registro.";
        }
    }

    // Mostrar resultados
    echo "<p>Importación finalizada. Registros insertados: $insertados.</p>";
    if ($errores) {
        echo "<p>Errores:</p><ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        // Redirigir con un mensaje de éxito usando GET
        header('Location: admin.php?import_success=true');
        exit();
    }
}
