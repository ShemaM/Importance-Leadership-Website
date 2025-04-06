<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to PHPMailer autoload

function sendEmailNotification($recipient, $subject, $body) {
    $mail = new PHPMailer(true);
    


    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'shemamanase992@gmail.com'; // SMTP username
        $mail->Password   = 'xqox zscc ouwq hsli'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption
        $mail->Port       = 465; // TCP port to connect to
        
        // Recipients
        $mail->setFrom('noreply@importanceleadership.com', 'Event Management System');
        $mail->addAddress($recipient);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
function sendCancellationEmail($to, $eventTitle, $reason, $cancelledBy, $cancelledAt) {
    $subject = "Event Cancelled: $eventTitle";
    $body = "<h2>Event Cancellation Notification</h2>
             <p><strong>Event:</strong> $eventTitle</p>
             <p><strong>Cancelled by:</strong> $cancelledBy</p>
             <p><strong>Reason:</strong> $reason</p>
             <p><strong>Cancelled at:</strong> $cancelledAt</p>";
    
    sendEmailNotification($to, $subject, $body);
}