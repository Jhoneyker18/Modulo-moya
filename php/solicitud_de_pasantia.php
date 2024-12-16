<?php
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';
$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
$carrera = isset($_POST['carrera']) ? $_POST['carrera'] : '';
$empresa = isset($_POST['empresa']) ? $_POST['empresa'] : '';
$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';

require('fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->AliasNbPages();

// Configurar márgenes de 3 cm
$pdf->SetMargins(30, 30, 30);
$pdf->SetAutoPageBreak(true, 30); // Márgenes inferiores automáticos

// Agregar logo
$pdf->Image('3.png', 15, 5, 20); // logo: ruta, x, y, tamaño

// Encabezado
$pdf->SetFont('Times', 'B', 8); // fuente: tipo, estilo, tamaño
$pdf->SetTextColor(0, 0, 0); // color del texto negro
$pdf->Cell(20); // margen izquierdo
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'), 0, 1, 'C');
$pdf->Ln(5); 
$pdf->Cell(20);
$pdf->Cell(0, 0, utf8_decode('MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN UNIVERSITARIA'), 0, 1, 'C');
$pdf->Ln(5); 
$pdf->Cell(20);
$pdf->Cell(0, 0, utf8_decode('INSTITUTO UNIVERSITARIO DE TECNOLOGÍA VENEZUELA'), 0, 1, 'C');

// Título principal
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(10); 
$pdf->Cell(0, 10, utf8_decode('MODELO'), 0, 1, 'C');
$pdf->SetFont('Arial', 'I', 12);
$pdf->Ln(5);
$pdf->Cell(0, 10, utf8_decode('INFORMACIÓN PARA'), 0, 1, 'C');
$pdf->Cell(0, 10, utf8_decode('SOLICITAR LA POSTULACIÓN A PASANTÍAS'), 0, 1, 'C');

// Sección: Datos del estudiante
$pdf->SetFont('Arial', 'BIU', 11);
$pdf->Ln(10); 
$pdf->Cell(0, 10, utf8_decode('DATOS DEL ESTUDIANTE'), 0, 1, 'L');
$pdf->SetFont('Arial', 'I', 10);
$pdf->Ln(5); 
$pdf->MultiCell(0, 8, utf8_decode('APELLIDOS Y NOMBRES: ' .$nombre . ' '.$apellido.'___'));
$pdf->MultiCell(0, 8, utf8_decode('CARRERA: '.$carrera.'__CÓDIGO: '.$codigo.'____'));
$pdf->MultiCell(0, 8, utf8_decode('Nº DE CÉDULA DE IDENTIDAD: '.$cedula.'___ TURNO: ________________'));
$pdf->MultiCell(0, 8, utf8_decode('Nº DE TELÉFONO: _'.$telefono.'' ));
$pdf->MultiCell(0, 8, utf8_decode('CORREO ELECTRÓNICO: ________________________________________________'));

// Sección: Datos de la empresa seleccionada
$pdf->SetFont('Arial', 'BIU', 11);
$pdf->Ln(10); 
$pdf->Cell(0, 10, utf8_decode('DATOS DE LA EMPRESA SELECCIONADA'), 0, 1, 'L');
$pdf->SetFont('Arial', 'I', 10);
$pdf->Ln(5); 
$pdf->MultiCell(0, 8, utf8_decode('NOMBRE DE LA EMPRESA: _____________________________________________'));
$pdf->MultiCell(0, 8, utf8_decode('DIRECCIÓN: _________________________________________________________'));
$pdf->MultiCell(0, 8, utf8_decode('Nº DE TELÉFONO: ____________________________________________________'));
$pdf->MultiCell(0, 8, utf8_decode('RIF: _______________________________________________________________'));
$pdf->MultiCell(0, 8, utf8_decode('APELLIDOS Y NOMBRES Y CARGO DE LA PERSONA A QUIEN LE SERÁ DIRIGIDA'));
$pdf->MultiCell(0, 8, utf8_decode('LA CARTA DE POSTULACIÓN: ____________________________________________'));

// Anexos requeridos
$pdf->SetFont('Arial', 'BI', 10);
$pdf->Ln(10); 
$pdf->Cell(0, 10, utf8_decode('ANEXAR A ESTA SOLICITUD'), 0, 1, 'L');
$pdf->SetFont('Arial', 'I', 9);
$pdf->Ln(5); 
$pdf->MultiCell(0, 6, utf8_decode('- Una copia de la Cédula de Identidad vigente y legible.'));
$pdf->MultiCell(0, 6, utf8_decode('- Una copia del recibo de inscripción.'));

$pdf->SetFont('Arial', '', 10);
$pdf->Ln(10); 
$pdf->MultiCell(0, 8, utf8_decode('FIRMA: ______________________  FECHA:_________________________'));

// Sección: Tutor Empresarial
$pdf->SetFont('Arial', 'BU', 12);
$pdf->Ln(30); 
$pdf->Cell(0, 10, utf8_decode('TUTOR EMPRESARIAL'), 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(10); 
$pdf->MultiCell(0, 8, utf8_decode('APELLIDOS Y NOMBRES: ________________________________________________'));
$pdf->MultiCell(0, 8, utf8_decode('CARGO EN LA EMPRESA: ________________________________________________'));
$pdf->MultiCell(0, 8, utf8_decode('NOMBRE DE LA EMPRESA: ______________________________________________'));
$pdf->MultiCell(0, 8, utf8_decode('DIRECCIÓN: _________________________________________________________'));
$pdf->MultiCell(0, 8, utf8_decode('TELÉFONOS: _________________________________________________________'));

// Sección: Datos del pasante
$pdf->SetFont('Arial', 'BU', 12);
$pdf->Ln(20); 
$pdf->Cell(0, 10, utf8_decode('DATOS DEL PASANTE'), 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(10); 
$pdf->MultiCell(0, 8, utf8_decode('APELLIDOS Y NOMBRES: ' .$nombre . '  '.$apellido.'_________________________________'));
$pdf->MultiCell(0, 8, utf8_decode('CÉDULA DE IDENTIDAD: '.$cedula.'_______ CÓDIGO: '.$codigo.'________________'));
$pdf->MultiCell(0, 8, utf8_decode('CARRERA: '.$carrera.'____________________________________________'));
$pdf->MultiCell(0, 8, utf8_decode('FECHA INICIO DE PASANTÍAS: _________ FECHA DE CULMINACIÓN: ___________'));
$pdf->MultiCell(0, 8, utf8_decode('MEDIO TIEMPO:_____________ TIEMPO COMPLETO:_____________'));

// Notas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(10); 
$pdf->MultiCell(0, 8, utf8_decode('NOTA: LA MODALIDAD DE TIEMPO COMPLETO DEBE CUMPLIR SEIS (6) SEMANAS DÍAS HÁBILES. PARA ALUMNOS DE TURNO NOCHE O MAÑANA, EL PERIODO DE PASANTÍAS ES DE NUEVE (9) SEMANAS PARA CUBRIR LOS DÍAS DE CLASE.'));
$pdf->MultiCell(0, 8, utf8_decode('(TOTAL DE HORAS: 240)'));

// Salida del PDF
$pdf->Output('I', 'Solicitud_Pasantias.pdf');
?>
