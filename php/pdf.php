<?php
require('fpdf/fpdf.php');

date_default_timezone_set('America/Caracas');

$cedula = $_GET['cedula'];
$stmt = $pdo->prepare("SELECT nombres, apellidos, codigo, turno, carrera FROM users WHERE cedula = :cedula");
if($stmt->execute(['cedula' => $cedula])){
    $row = $stmt->fetch();
    $nombres = $row['nombres'];
    $apellidos = $row['apellidos'];
    $codigo = $row['codigo'];
    $turno = $row['turno'];
    $carrera = $row['carrera'];
}
$empresa = isset($_POST['empresa']) ? $_POST['empresa'] : '';

$fecha = date('d/m/Y'); 

$pdf = new FPDF();
$pdf->AddPage();

$pdf->Image('2.png', 5, 5, 30, 0); 
$pdf->Image('2.png', 55, 70, 100, 0); 

$pdf->SetFont('Arial', 'B', 11);


$pdf->Cell(0, 7, '', 0, 1, 'C');
$pdf->Cell(0, 7, '', 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN UNIVERSITARIA, CIENCIA Y TECNOLOGÍA'), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('INSTITUTO UNIVERSITARIO DE TECNOLOGÍA VENEZUELA'), 0, 1, 'C');

$pdf->Ln(10); 

$pdf->Cell(0, 7, utf8_decode('Fecha: ' . $fecha), 0, 1, 'R'); 
$pdf->Cell(0, 7, utf8_decode('Att: Elena Moya '), 0, 1, 'R');

$pdf->SetFont('Arial', '', 11); 
$pdf->Cell(0, 7, utf8_decode('Señores:'), 0, 1, 'J'); 
$pdf->MultiCell(
    0, 
    7, 
    utf8_decode('Por el medio de la presente manifestamos nuestro agradecimiento por haber aceptado como pasante al Br: ' 
    . $nombres . ' ' . $apellidos . ', cédula de identidad N: ' . $cedula 
    . ', la carrera de '.$carrera.' durante el lapso el lapso.'), 
    0, 
    'J'
);

$pdf->Ln(5); 
$pdf->MultiCell(
    0, 
    7, 
    utf8_decode('Anexo estamos enviando el formato "EVALUACIÓN DEL PASANTE", en el cual quedará reflejada su actuación. '
    . 'Es importante comunicarle que este formulario debe ser completado en su totalidad, sellado y firmado por '
    . 'el autor empresarial y devuelto en sobre cerrado.'), 
    0, 
    'J'
);

$pdf->Ln(10);
$pdf->Cell(0, 7, utf8_decode('Sin otro particular a qué hacer referencia, le saluda'), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Atentamente'), 0, 1, 'C');

$pdf->Ln(10);
$pdf->Cell(0, 7, utf8_decode('Ing. ELENA MOYA'), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('JEFE DEL DEPARTAMENTO DE PASANTÍAS Y'), 0, 1, 'C'); 
$pdf->Cell(0, 7, utf8_decode('RELACIONES CON LAS EMPRESAS'), 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10); 
$pdf->Cell(0, 7, utf8_decode('_________________________'), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Lugar de pasantía:' . $empresa), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Esta Planilla solo es válida si tiene el sello de la institución'), 0, 1, 'C');
$pdf->Ln(10);
$pdf->MultiCell(0, 7, 
    utf8_decode("Sede parque Carabobo                                                                                                      Extensión Maturín\n" .
    "Avenida Universidad, Perico                                                                                               Detrás de la vieja sede\n" . 
    "Morrocoy. Edificio La Metropolitana                                                                                    Sector Viento colao\n" . 
    "entre el metro de La Hoyada y                                                                                            Calle 26 con 7-A : \n" .
    "Parque Carabobo.                                                                                                               Teléfonos:(0291)642.91.50\n" . 
    "                                                                                                                                            Maturín estado Monagas."), 0, 'J');
$pdf->Output();
?>

