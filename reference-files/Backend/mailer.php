<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load .env environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function sendEmailNotification($recipient, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USERNAME'];
        $mail->Password   = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = $_ENV['SMTP_PORT'];
        $mail->SMTPDebug  = 0; // Set to 2 for full debug output
        $mail->Debugoutput = 'error_log';

        // Email details
        $mail->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);
        $mail->addAddress($recipient);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

// Optional: cancellation email wrapper
function sendCancellationEmail($to, $eventTitle, $reason, $cancelledBy, $cancelledAt) {
    $subject = "Event Cancelled: $eventTitle";
    $body = "
        <h2>Event Cancellation Notification</h2>
        <p><strong>Event:</strong> $eventTitle</p>
        <p><strong>Cancelled by:</strong> $cancelledBy</p>
        <p><strong>Reason:</strong> $reason</p>
        <p><strong>Cancelled at:</strong> $cancelledAt</p>
    ";

    return sendEmailNotification($to, $subject, $body);
}
