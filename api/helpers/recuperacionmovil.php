<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../api/libraries/phpmailer651/src/Exception.php';
require __DIR__ . '/../../api/libraries/phpmailer651/src/PHPMailer.php';
require __DIR__ . '/../../api/libraries/phpmailer651/src/SMTP.php';
require __DIR__ . '/../../api/helpers/database.php';

header('Content-type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    die();
}

$clienteEmail = $_POST['clienteEmail'] ?? null;

if (!$clienteEmail) {
    echo json_encode(array("status" => 0, "info" => "El email del cliente no está proporcionado."));
    exit;
}

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPDebug = 0; 
    $mail->Debugoutput = 'html';

    $mail->setFrom('sportdevelopment7@gmail.com', 'Sport Development');
    $mail->addAddress($clienteEmail);

    $mail->Subject = 'Saludos desde Sport Development';
    $mail->isHTML(true);
    $mail->CharSet = 'utf-8';

    $html = "<html>
        <body>
            <p>Hola,</p>
            <p>Este es un mensaje de prueba desde Sport Development.</p>
        </body>
    </html>";

    $mail->msgHTML($html);

    if (!$mail->send()) {
        $json = array("status" => 0, "info" => "Correo no se pudo enviar.<br>" . $mail->ErrorInfo);
    } else {
        $json = array("status" => 1, "info" => "Correo enviado.");
    }
} catch (Exception $e) {
    $json = array("status" => 0, "info" => "Error: " . $e->getMessage());
}

echo json_encode($json);
?>
