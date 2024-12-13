<?php
require 'fpdf/fpdf.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $cedula = $_POST['cedula'] ?? '';
    $carrera = $_POST['carrera'] ?? '';
    $empresa = $_POST['empresa'] ?? '';
    $email = $_POST['email'] ?? '';
    $action = $_POST['action'] ?? '';

    
    $pdfFilePath = 'temp/planilla_' . $cedula . '.pdf';

    
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 11);

    
    $pdf->Image('2.png', 5, 5, 30, 0);
    $pdf->Cell(0, 7, 'REPUBLICA BOLIVARIANA DE VENEZUELA', 0, 1, 'C');
    $pdf->Cell(0, 7, 'MINISTERIO DEL PODER POPULAR PARA LA EDUCACION UNIVERSITARIA', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->Cell(0, 7, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');
    $pdf->MultiCell(0, 7, "Por medio de la presente se manifiesta que el estudiante $nombre $apellido, con cédula $cedula de la carrera $carrera será pasante en $empresa.", 0, 'J');
    $pdf->Output('F', $pdfFilePath); 


    if ($action === 'email') {
        try {
            
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'casticj679@gmail.com'; 
            $mail->Password = '04269076624'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            
            $mail->setFrom('tu_correo@gmail.com', 'Departamento de Pasantías');
            $mail->addAddress($email, "$nombre $apellido");

            
            $mail->Subject = 'Planilla de Pasantía';
            $mail->Body = "Estimado/a $nombre $apellido,\n\nAdjunto encontrarás la planilla generada automáticamente.\n\nSaludos cordiales.";

        
            $mail->addAttachment($pdfFilePath);

            
            $mail->send();
            echo 'El correo se envió correctamente.';
        } catch (Exception $e) {
            echo 'Hubo un error al enviar el correo: ' . $mail->ErrorInfo;
        } finally {
        
            if (file_exists($pdfFilePath)) {
                unlink($pdfFilePath);
            }
        }
    } else {
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($pdfFilePath) . '"');
        readfile($pdfFilePath);

        
        unlink($pdfFilePath);
    }
} else {
    echo 'No se recibieron datos del formulario.';
}
