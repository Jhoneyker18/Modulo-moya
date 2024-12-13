<?php
session_start();
require 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '123456789') {
    header("Location: index.php");
    exit;
}

$cedula = $_SESSION['user_id'];

$stmtStudent = $pdo->prepare("SELECT * FROM users WHERE cedula = ?");
$stmtStudent->execute([$cedula]);
$student = $stmtStudent->fetch(PDO::FETCH_ASSOC);


$stmtRequests = $pdo->prepare("
    SELECT i.id, i.descripcion, i.estado, e.nombre AS empresa, 
    FROM internships i
    LEFT JOIN empresas e ON i.empresa_id = e.id
    WHERE i.cedula = ?
");
$stmtRequests->execute([$cedula]);
$internships = $stmtRequests->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio del Estudiante</title>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($student['nombres']); ?>!</h1>
    <a href="logout.php">Cerrar sesión</a>

    <h2>Solicitar Pasantía</h2>
    <form method="POST" action="solicitar_pasantia.php">
        <label for="empresa">Empresa:</label>
        <select id="empresa" name="empresa" required>
            <?php
            $stmtCompanies = $pdo->query("SELECT * FROM empresas");
            while ($company = $stmtCompanies->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$company['id']}'>{$company['nombre']}</option>";
            }
            ?>
        </select>
        <br>
        <label for="descripcion">Razón para elegir esta empresa:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
        <br>
        <button type="submit">Enviar Solicitud</button>
    </form>

    <h2>Estado de tu Pasantía</h2>
<?php
$stmt = $pdo->prepare("SELECT * FROM internships WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$internship = $stmt->fetch(PDO::FETCH_ASSOC);

if ($internship) {
    echo "<p>Estado: " . htmlspecialchars($internship['estado']) . "</p>";
    echo "<p>Empresa: " . htmlspecialchars($internship['nueva_empresa'] ?? 'Actual') . "</p>";
} else {
    echo "<p>No tienes una pasantía registrada.</p>";
}
?>

</body>
</html>
