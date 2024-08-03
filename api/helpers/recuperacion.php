<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../api/libraries/phpmailer651/src/Exception.php';
require __DIR__ . '/../../api/libraries/phpmailer651/src/PHPMailer.php';
require __DIR__ . '/../../api/libraries/phpmailer651/src/SMTP.php';
require __DIR__ . '/../../api/helpers/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (empty($email)) {
        echo json_encode(['status' => false, 'error' => 'No se ha enviado el email.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'error' => 'Email inválido']);
        exit;
    }

    // Generar código de recuperación
    $recoveryCode = rand(100000, 999999);

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
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sportdevelopment7@gmail.com';
        $mail->Password = 'oatk qcui omre ihbn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('sportdevelopment7@gmail.com', 'Sport Development');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Código de Recuperación de Contraseña';
        $mail->Body = 'Tu código de recuperación es: ' . $recoveryCode;
        $mail->AltBody = 'Tu código de recuperación es: ' . $recoveryCode;

        $mail->send();
        echo json_encode(['status' => true]);
    } catch (Exception $e) {
        echo json_encode(['status' => false, 'error' => 'No se pudo enviar el código. Error: ' . $mail->ErrorInfo]);
    }
}
?>
