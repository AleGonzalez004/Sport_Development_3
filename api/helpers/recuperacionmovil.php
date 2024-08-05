<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '/../../api/libraries/phpmailer651/src/Exception.php';
require_once '/../../api/libraries/phpmailer651/src/PHPMailer.php';
require_once '/../../api/libraries/phpmailer651/src/SMTP.php';
require_once '/../../api/helpers/database.php';

header('Content-type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    die();
}

$user = isset($_POST['user']) ? $_POST['user'] : '';
$pin = isset($_POST['pin']) ? $_POST['pin'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

ini_set("sendmail_from", "sportdevelopment7@gmail.com");

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPDebug = 2; // Cambiado a 2 para depuración más detallada
    $mail->Debugoutput = 'html';

    $mail->setFrom('sportdevelopment7@gmail.com'); 
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "smtp.gmail.com"; 
    $mail->Port = 587; 
    $mail->Username = "sportdevelopment7@gmail.com"; 
    $mail->Password = "oatk qcui omre ihbn"; 

    $mail->addAddress($email); 

    $mail->Subject = 'Recuperacion de contraseña';
    $mail->isHTML(true); 
    $mail->CharSet = 'utf-8'; 

    $html = "<html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #d1cdb8;
                    color: #000;
                    text-align: center;
                    padding: 50px;
                }
                .container {
                    background-color: #f0f0f0;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    max-width: 400px;
                    margin: auto;
                }
                .header {
                    font-size: 24px;
                    margin-bottom: 20px;
                }
                .pin {
                    font-size: 36px;
                    letter-spacing: 10px;
                    padding: 10px;
                    background-color: #fff;
                    border-radius: 5px;
                    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                    display: inline-block;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 14px;
                    color: #666;
                }
                .icon {
                    margin: 20px 0;
                }
                .icon img {
                    width: 100px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>Recuperación de clave</div>
                <div class='icon'>
                    <img src='cid:security_icon' alt='Security Icon'>
                </div>
                <div>Hola $user</div>
                <div>PIN DE SEGURIDAD</div>
                <div class='pin'>$pin</div>
                <div class='footer'>
                    <img src='cid:logo' alt='YNWA NCS Logo'>
                </div>
            </div>
        </body>
    </html>";

    $mail->msgHTML($html);

    if (!$mail->send()) {
        $json = array("status" => 0, "info" => "Correo no se pudo enviar.<br>" . $mail->ErrorInfo);
    } else {
        $json = array("status" => 1, "info" => "Correo enviado.");
    }
} catch (Exception $e) {
    $json = array("status" => 0, "info" => $e->getMessage());
}

echo json_encode($json);

