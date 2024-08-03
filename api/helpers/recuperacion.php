<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ('../../api/models/data/cliente_data.php');
require __DIR__ . '/../../api/libraries/phpmailer651/src/Exception.php';
require __DIR__ . '/../../api/libraries/phpmailer651/src/PHPMailer.php';
require __DIR__ . '/../../api/libraries/phpmailer651/src/SMTP.php';
require __DIR__ . '/../../api/helpers/database.php';

$cliente = new ClienteData;
$clienteEmail = null; // Variable para almacenar el correo electrónico del cliente


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $clienteEmail = $_POST['clienteEmail'];
    $clientEmail = urldecode($_GET['clienteEmail']);

    // Generar código de recuperación
    $recoveryCode = rand(100000, 999999);

    // Guardar el código en la base de datos
    try {
        $query = "UPDATE tb_clientes SET codigo_recuperacion = ? WHERE correo_cliente = ?";
        $values = [$recoveryCode, $clienteEmail];
        if (!Database::executeRow($query, $values)) {
            echo json_encode(['status' => false, 'error' => 'Error al guardar el código de recuperación.']);
            exit;
        }

        // Verificar si el correo se actualizó correctamente
        $queryCheck = "SELECT correo_cliente FROM tb_clientes WHERE correo_cliente = ?";
        $valuesCheck = [$clienteEmail];
        $result = Database::getRow($queryCheck, $valuesCheck);
        
        if (!$result) {
            echo json_encode(['status' => false, 'error' => 'El correo electrónico no se encuentra en la base de datos.']);
            exit;
        }

    } catch (Exception $e) {
        echo json_encode(['status' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
        exit;
    }

    // Enviar email
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP para Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sportdevelopment7@gmail.com'; // Tu correo electrónico de Gmail
        $mail->Password = 'oatk qcui omre ihbn'; // Tu contraseña o contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('sportdevelopment7@gmail.com', 'Sport Development');
        $mail->addAddress($email);

        // Asunto y cuerpo del correo
        $mail->isHTML(true);
        $mail->Subject = 'Código de Recuperación de Contraseña';
        $mail->Body = 'Tu código de recuperación es: <strong>' . $recoveryCode . '</strong>';
        $mail->AltBody = 'Tu código de recuperación es: ' . $recoveryCode;

        // Enviar el correo
        $mail->send();
        echo json_encode(['status' => true, 'message' => 'Código de recuperación enviado.']);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'error' => 'No se pudo enviar el código. Error: ' . $mail->ErrorInfo]);
    }
}
?>
