<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../api/libraries/phpmailer651/src/Exception.php';
require __DIR__ . '/../../api/libraries/phpmailer651/src/PHPMailer.php';
require __DIR__ . '/../../api/libraries/phpmailer651/src/SMTP.php';
require __DIR__ . '/../../api/helpers/database.php';

header('Content-Type: application/json');

// Verificar el método de solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el correo electrónico del cliente y otros datos
    $clienteEmail = $_POST['clienteEmail'] ?? null;
    $code = $_POST['code'] ?? null;
    $newPassword = $_POST['newPassword'] ?? null;
    $confirmPassword = $_POST['confirmPassword'] ?? null;

    // Verificar si se envió un correo electrónico
    if ($clienteEmail && !$code) {
        // Enviar el correo electrónico con el mensaje de "Hola"
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sportdevelopment7@gmail.com'; // Tu correo electrónico de Gmail
            $mail->Password = 'oatk qcui omre ihbn'; // Tu contraseña o contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remitente y destinatario
            $mail->setFrom('sportdevelopment7@gmail.com', 'Sport Development');
            $mail->addAddress($clienteEmail); // Correo electrónico del cliente

            // Asunto y cuerpo del correo
            $mail->isHTML(true);
            $mail->Subject = 'Saludos desde Sport Development';
            $mail->Body = 'Hola, este es un mensaje de prueba desde Sport Development.';
            $mail->AltBody = 'Hola, este es un mensaje de prueba desde Sport Development.';

            // Enviar el correo
            $mail->send();
            echo json_encode(['status' => true, 'message' => 'Correo electrónico enviado con éxito.']);
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'error' => 'No se pudo enviar el correo. Error: ' . $mail->ErrorInfo]);
        }
        exit;
    }

    // Verificar si se envió el código y las contraseñas
    if ($code && $newPassword && $confirmPassword) {
        // Verificar si las contraseñas coinciden
        if ($newPassword !== $confirmPassword) {
            echo json_encode(['status' => false, 'error' => 'Las contraseñas no coinciden.']);
            exit;
        }

        // Actualizar la contraseña en la base de datos
        try {
            $query = "UPDATE tb_clientes SET contrasena_cliente = ? WHERE codigo_recuperacion = ?";
            $values = [password_hash($newPassword, PASSWORD_BCRYPT), $code];
            if (!Database::executeRow($query, $values)) {
                echo json_encode(['status' => false, 'error' => 'Error al actualizar la contraseña.']);
                exit;
            }

            // Limpiar el código de recuperación después de usarlo
            $queryClearCode = "UPDATE tb_clientes SET codigo_recuperacion = NULL WHERE codigo_recuperacion = ?";
            Database::executeRow($queryClearCode, [$code]);

            echo json_encode(['status' => true, 'message' => 'Contraseña actualizada con éxito.']);
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
        }
        exit;
    }

    // Si no se proporciona ningún dato válido
    echo json_encode(['status' => false, 'error' => 'Datos insuficientes.']);
}
?>
