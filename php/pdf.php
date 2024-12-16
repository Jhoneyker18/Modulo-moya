<?php
require('fpdf/fpdf.php');

date_default_timezone_set('America/Caracas');
function formatearNumero($numero) { return number_format($numero, 0, '', '.'); }
 
setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain.1252');

$fecha = strftime('%d de %B de %Y');

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';
$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
$carrera = isset($_POST['carrera']) ? $_POST['carrera'] : '';
$empresa = isset($_POST['empresa']) ? $_POST['empresa'] : '';
$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';
$encargado = isset($_POST['encargado']) ? $_POST['encargado'] : '';
$fecha = strftime('%d de %B de %Y');
$codigo = 123456789;
$turno = isset($_POST['turno']) ? $_POST['turno'] : '';
if($turno == "mañana"){
    $turno1 = "DIURNO";
}else if($turno == "noche"){
    $turno1 = "NOCTURNO";
}else{
    $turno1 = "SABATINO";
}
$cedula1 = formatearNumero($cedula);
$codigo1 = formatearNumero($codigo);
function convertirAMayusculas($palabra) { return strtoupper($palabra); }
if($cedula > 80000000){
$nacionalidad = "E";
}else{
$nacionalidad = "V";
}
$apellidos1 = convertirAMayusculas($apellido);
$nombres1 = convertirAMayusculas($nombre);
$carrera1 = convertirAMayusculas($carrera);
$cargo1 = convertirAMayusculas($cargo);
$encargado1 = convertirAMayusculas($encargado);
$pdf = new FPDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas






      $pdf->Image('logo2.png', 20, 30, 180);
      $pdf->Image('logo.jpg', 20, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $pdf->SetFont('Arial', 'B', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $pdf->Cell(45); // Movernos a la derecha
    $pdf->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $pdf->Cell(110, 5, utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(40);
      $pdf->Cell(110, 5, utf8_decode('MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN UNIVERSITARIA, CIENCIA Y TECNOLOGÍA'), 50, 1, 'C', 0);
      $pdf->SetFont('Arial', 'B', 12);
      $pdf->Cell(40);
      $pdf->Cell(110, 5, utf8_decode('INSTITUTO UNIVERSITARIO TECNOLÓGICO DE VENEZUELA'), 0, 1, 'C', 0);
      $pdf->Ln(10);
      $pdf->Cell(130);  // mover a la derecha
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Cell(96, 10, utf8_decode("Caracas, $fecha"), 0, 0, '', 0);
      $pdf->Ln(5);
      $pdf->SetMargins(30, 30, 30); 
      $pdf->SetAutoPageBreak(true, 30);  
      $pdf->Cell(10);
 // mover a la derecha
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Cell(96, 5, utf8_decode("Señores "), 0, 1, '', 0);
      $pdf->Ln(1);
      $pdf->Cell(-10);
      $pdf->Cell(96, 5, utf8_decode($empresa), 0, 1, '', 0);
      $pdf->Cell(-10);
      $pdf->Cell(96, 5, utf8_decode("Presente.- "), 0, 1, '', 0);
      $pdf->Cell(100);  // mover a la derecha
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Cell(96, 10, utf8_decode("ATT: ".$encargado1), 0, 1, '', 0);
      $pdf->Cell(65);  // mover a la derecha
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->SetX(130);
      $pdf->Cell(96, 1, utf8_decode($cargo1), 0, 1, '', 0);
      $pdf->Ln(5);
      $pdf->Cell(10);  // mover a la derecha
      $pdf->SetFont('Arial', '', 12);
      $pdf->Cell(-10);
      $pdf->Cell(96, 5, utf8_decode("Estimado(s) Señor(es):"), 0, 1, '', 0);
      $pdf->Ln(1);
      $pdf->Cell(96, 5, utf8_decode(""), 0, 1, '', 0);
      $pdf->Cell(-10);
      $pdf->MultiCell(180, 5, utf8_decode("                    Muy respetuosamente me dirijo a usted(es), en la oportunidad de presentarle(s) al Br. ".$nombres1.", ".$apellidos1." titular de la Cédula de Identidad:                       ".$nacionalidad." - ".$cedula1.", Codigo: ".$codigo1.", aspirante a realizar pasantías en esa importante Empresa ya que es un requisito indispensable para optar al titulo de Tecnico Superior Universitario en la carrera de ".$carrera1." (".$turno1.")."), 0, 0, '', 0);
      $pdf->Ln(5);
      $pdf->Cell(-10);
      $pdf->MultiCell(180, 5, utf8_decode("                    El Tiempo de la Pasantia es de: Seis (6) semanas dias habiles, para los alumnos del turno de la Noche, y de nueve (9) semananas para los alumnos del turno de la Mañana. (Total de horas minimas 240)"), 0, 0, '', 0);
      $pdf->Ln(5);
      $pdf->Cell(96, 5, utf8_decode("          Sin otro particular a que hacer referencia, le saludo."), 0, 1, '', 0);
      $pdf->Ln(8);
      $pdf->Cell(60);
      $pdf->SetFont('Arial', 'B', 12);
      $pdf->Cell(60, 5, utf8_decode("Atentamente: "), 0, 1, '', 0);
      $pdf->Ln(50);
      $pdf->Cell(45);
      $pdf->Cell(60, 5, utf8_decode("Ing. Elena Moya"), 0, 1, 'C', 0);
      $pdf->Cell(45);
      $pdf->Cell(60, 5, utf8_decode("Jefe del departamento de Pasantías y"), 0, 1, 'C', 0);
      $pdf->Cell(45);
      $pdf->Cell(60, 5, utf8_decode("Relaciones con las empresas"), 0, 1, 'C', 0);
      $pdf->Ln(10);
      $pdf->Cell(10);
$pdf->SetFont('Arial', '', 8); 
$pdf->MultiCell(0, 4, 
    utf8_decode("Sede parque Carabobo                            Sede Las Mercedes                                     Extension Maturin \n" .
    "Avenida Universidad, Perico                    Calle Londres entre Nueva york                   Detras de la vieja sede\n" . 
    "Morrocoy. Edificio La Metropolitana         y Caroni                                                        Sector Viento colao\n" . 
    "entre el metro de La Hoyada y                Telefono: 993.56.05 . 991.96.25.                  Calle 26 con 7-A : \n" . 
    "Parque Carabobo.                                                                                                        Maturin estado Monagas. Telefonos:(0291)642.91.50" . ""), 0, 'J');
    $pdf->SetFont('Arial', 'BU', 12);
$pdf->Ln(50); 
$pdf->Cell(20);
$pdf->Ln(20); 
$pdf->SetMargins(30, 0, 0); 
$pdf->SetAutoPageBreak(true, 30); 
$pdf->Cell(-30); 
$pdf->Cell(0, 0, utf8_decode('TUTOR EMPRESARIAL'), 0, 1, 'C', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(10);

$pdf->Cell(0, 0, utf8_decode('APELLIDOS Y NOMBRES: ____________________________________________________'), 0, 1, '', 0);
$pdf->Ln(7);

$pdf->Cell(0, 0, utf8_decode('CARGO EN LA EMPRESA: ____________________________________________________'), 0, 1, '', 0);
$pdf->Ln(7);

$pdf->Cell(0, 0, utf8_decode('NOMBRE DE LA EMPRESA: ___________________________________________________'), 0, 1, '', 0);
$pdf->Ln(7);

$pdf->Cell(0, 0, utf8_decode('DIRECCION: ________________________________________________________________'), 0, 1, '', 0);
$pdf->Ln(7);

$pdf->Cell(0, 0, utf8_decode('TELEFONOS: ____________________________________________________'), 0, 1, '', 0);
$pdf->SetFont('Arial', 'BU', 12);
$pdf->Ln(20);
$pdf->Cell(-30); 
$pdf->Cell(0, 0, utf8_decode('DATOS DEL PASANTE'), 0, 1, 'C', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(10);

$pdf->Cell(0, 0, utf8_decode('APELLIDOS Y NOMBRES: '), 0, 1, '', 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(44);
$pdf->Cell(0, 0, utf8_decode($apellidos1.', '.$nombres1), 0, 1, '', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(7);
$pdf->Cell(0, 0, utf8_decode('CEDULA DE IDENTIDAD:                          CODIGO:                       TURNO           '), 0, 1, '', 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(42);
$pdf->Cell(0, 0, utf8_decode($nacionalidad.' - '.$cedula1), 0, 1, '', 0);
$pdf->Cell(83);
$pdf->Cell(0, 0, utf8_decode($codigo1), 0, 1, '', 0);
$pdf->Cell(120);
$pdf->Cell(0, 0, utf8_decode('('.$turno1.')'), 0, 1, '', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(7);
$pdf->Cell(0, 0, utf8_decode('CARRERA:'), 0, 1, '', 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20);
$pdf->Cell(0, 0, utf8_decode($carrera1), 0, 1, '', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(7);

$pdf->Cell(0, 0, utf8_decode('FECHA INICIO DE PASANTIAS: _________ FECHA DE CULMINACIÓN: ___________'), 0, 1, '', 0);
$pdf->Ln(7);

$pdf->Cell(0, 0, utf8_decode('MEDIO TIEMPO:_____________ TIEMPO COMPLETO:_____________'), 0, 1, '', 0);
$pdf->SetFont('Arial', 'BU', 10);
$pdf->Ln(20);

$pdf->Cell(0, 0, utf8_decode('NOTA: LA MODALIDAD DE TIEMPO COMPLETO:'), 0, 1, '', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(82); 
$pdf->Cell(0, 0, utf8_decode('SEIS (6) SEMANAS DIAS HABILES, LOS'), 0, 1, '', 0);
$pdf->Ln(7);

$pdf->Cell(0, 0, utf8_decode('ALUMNOS DEL TURNO DE LA NOCHE Y LOS DE LA MAÑANA DEBEN REALIZAR LAS'), 0, 1, '', 0);
$pdf->Ln(7);

$pdf->Cell(0, 0, utf8_decode('PASANTIAS EN NUEVE (9) SEAMANAS PARA CUBRIR LOS DIAS DE CLASE '), 0, 1, '', 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(7);

$pdf->Cell(0, 0, utf8_decode('(TOTAL DE HORAS 240)'), 0, 1, '', 0);
$pdf->SetDrawColor(163, 163, 163); 


$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); 
$pdf->Output('Pasantia '.$apellidos1.', '.$nombres1.'.pdf', 'I');
$pdf->SetFont('Arial', '', 11); 
