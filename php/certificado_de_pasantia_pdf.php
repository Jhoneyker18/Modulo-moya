<?php
require('fpdf/fpdf.php');

date_default_timezone_set('America/Caracas');

$nombre = isset($_POST['nombre']) ? utf8_decode($_POST['nombre']) : '';
$cedula = isset($_POST['cedula']) ? utf8_decode($_POST['cedula']) : '';
$apellido = isset($_POST['apellido']) ? utf8_decode($_POST['apellido']) : '';
$carrera = isset($_POST['carrera']) ? utf8_decode($_POST['carrera']) : '';
$empresa = isset($_POST['empresa']) ? utf8_decode($_POST['empresa']) : '';


setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain.1252');

$fecha = strftime('%d de %B de %Y');


$pdf = new FPDF();
$pdf->AddPage();


$pdf->SetMargins(30, 30, 30);
$pdf->SetAutoPageBreak(true, 30);
$pdf->Image('2.png', 10, 10, 30, 0);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Ln(20); 
$pdf->MultiCell(0, 7, utf8_decode(
    "INSTITUTO UNIVERSITARIO DE TECNOLOGÍA VENEZUELA\nSEDE PRINCIPAL"
), 0, 'C');
$pdf->Ln(15);

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode('CERTIFICADO DE PASANTIA'), 0, 1, 'C');
$pdf->SetLineWidth(0.5); // Grosor de la línea
$pdf->Line(70, $pdf->GetY(), 140, $pdf->GetY()); // Subrayar el título


$pdf->SetFont('Arial', '', 11);
$pdf->Ln(10);
$texto = 'Quien suscribe, MSc. Nahmens de Gonzales, Directora del INSTITUTO UNIVERSITARIO DE TECNOLOGÍA VENEZUELA, 
hace constar por medio de la presente, que el (la) BR. ' . $nombre . ' ' . $apellido . ', titular de la Cédula de Identidad N° ' . $cedula . 
', cursó y aprobó pasantía durante el semestre actual en la especialidad de ' . $carrera . 
', mencionando que realizó las mismas en la empresa o institución ' . $empresa . 
' con una duración de 240 horas, donde cumplió satisfactoriamente con las actividades asignadas, obteniendo una clasificación (_ _) de puntos.';
$pdf->MultiCell(0, 7, utf8_decode($texto), 0, 'J');

$pdf->Ln(20);


$pdf->Cell(0, 7, utf8_decode('En Caracas, a los ' . $fecha), 0, 1, 'C');
$pdf->Ln(20);

$pdf->Cell(0, 7, utf8_decode('Atentamente,'), 0, 1, 'C');
$pdf->Ln(10);
$pdf->Cell(0, 7, utf8_decode('MSc. Evelyn Nahmens de Gonzales'), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Directora'), 0, 1, 'C');


$pdf->Output();
?>
