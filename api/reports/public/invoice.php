<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Define rutas absolutas
$exceptionPath = 'C:/xampp/htdocs/Sport_Development_3/resources/libs/PHPMailer/src/Exception.php';
$phpMailerPath = 'C:/xampp/htdocs/Sport_Development_3/resources/libs/PHPMailer/src/PHPMailer.php';
$smtpPath = 'C:/xampp/htdocs/Sport_Development_3/resources/libs/PHPMailer/src/SMTP.php';

// Verifica que los archivos existen
if (!file_exists($exceptionPath) || !file_exists($phpMailerPath) || !file_exists($smtpPath)) {
    die('No se puede encontrar uno o más archivos de PHPMailer.');
}

// Incluye los archivos
require $exceptionPath;
require $phpMailerPath;
require $smtpPath;

// Verifica si se han pasado los parámetros necesarios
if (!isset($_GET['file']) || !isset($_GET['email'])) {
    die('No se ha proporcionado el archivo PDF o el correo electrónico.');
}

$pdfFilePath = urldecode($_GET['file']);
$clientEmail = urldecode($_GET['email']);

// Verifica si el archivo PDF existe
if (!file_exists($pdfFilePath)) {
    die('El archivo PDF no existe.');
}

// Configuración de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP para Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'denisalejandro2006@gmail.com'; // Tu correo electrónico de Gmail
    $mail->Password   = 'xllo wncf baub yqbs'; // Tu contraseña o contraseña de aplicación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Remitente y destinatario
    $mail->setFrom('denisalejandro2006@gmail.com', 'Sport Development Corp');
    $mail->addAddress($clientEmail); // Utilizar el correo electrónico del cliente

    // Asunto y cuerpo del correo
    $mail->isHTML(true);
    $mail->Subject = 'Comprobante de Compra';
    $mail->Body    = 'Adjunto encontrarás tu comprobante de compra.';
    $mail->AltBody = 'Adjunto encontrarás tu comprobante de compra.';

    // Adjuntar el archivo PDF
    $mail->addAttachment($pdfFilePath, 'Comprobante.pdf');

    // Enviar el correo
    $mail->send();
    echo 'El correo ha sido enviado con éxito.';
} catch (Exception $e) {
    echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
}
?>
