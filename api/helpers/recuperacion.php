<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../api/libraries/phpmailer651/src/Exception.php';
require __DIR__ . '/../../api/libraries/phpmailer651/src/PHPMailer.php';
require __DIR__ . '/../../api/libraries/phpmailer651/src/SMTP.php';
require __DIR__ . '/../../api/helpers/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si 'email' está en la solicitud POST
    if (!isset($_POST['email'])) {
        echo json_encode(['status' => false, 'error' => 'No se ha enviado el email.']);
        exit;
    }

    $email = $_POST['email'];

    // Validar email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'error' => 'Email inválido']);
        exit;
    }

    // Generar código de recuperación
    $recoveryCode = rand(100000, 999999);

    // Guardar el código en la base de datos
    try {
        $query = "UPDATE tb_clientes SET codigo_recuperacion = ? WHERE correo_cliente = ?";
        $values = [$recoveryCode, $email];
        if (!Database::executeRow($query, $values)) {
            echo json_encode(['status' => false, 'error' => 'Error al guardar el código de recuperación.']);
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
        $mail->Body = 'Tu código de recuperación es: ' . $recoveryCode;
        $mail->AltBody = 'Tu código de recuperación es: ' . $recoveryCode;

        // Enviar el correo
        $mail->send();
        echo json_encode(['status' => true]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'error' => 'No se pudo enviar el código. Error: ' . $mail->ErrorInfo]);
    }
}
?>
