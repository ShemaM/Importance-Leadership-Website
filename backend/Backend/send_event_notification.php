<?php
require_once 'db_connect.php';
require_once 'mailer.php'; // Your PHPMailer setup

// Get event details (example: event ID 1)
$eventId = 1;
$event = $pdo->query("SELECT * FROM events WHERE id = $eventId")->fetch();

if (!$event) {
    die("Event not found!");
}

// Get all active subscribers
$subscribers = $pdo->query("SELECT * FROM newsletter_subscribers")->fetchAll();

// Email content
$subject = "New Event: " . htmlspecialchars($event['title']);

$body = "
    <div style='text-align: center;'>
        <img src='https://www.importanceleadership.com/' alt='Organization Logo' style='max-width: 200px; margin-bottom: 20px;'>
    </div>
    <p>Dear <strong>Leader</strong>,</p>
    <p>Greeting from <strong>Importance Leadership! </strong></p>
    <p>We are thrilled to invite you to an exciting new event:</p>
    <h2>" . htmlspecialchars($event['title']) . "</h2>
    <p><strong>Date:</strong> " . date('F j, Y', strtotime($event['event_date'])) . "</p>
    <p><strong>Time:</strong> " . date('h:i A', strtotime($event['event_time'])) . "</p>
    <p><strong>Location:</strong> " . htmlspecialchars($event['location']) . "</p>
    <p>" . nl2br(htmlspecialchars($event['description'])) . "</p>
    <p><em>Note: This is a test notification. The website is not live yet.</em></p>
    <p>Best regards,<br>Importance Leadership Team</p>
";

// Send to each subscriber
foreach ($subscribers as $subscriber) {
    sendEmailNotification(
        $subscriber['email'],
        $subject,
        $body
    );
}

echo "Notifications sent to " . count($subscribers, ) . " subscribers!";
?>