<?php
require_once 'auth_check.php';
require_once 'db_connect.php';
require_once 'mailer.php'; // You'll need to create this

// Validate request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: events.php");
    exit;
}

// CSRF protection
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'] = "Invalid request";
    header("Location: events.php");
    exit;
}

// Validate inputs
$eventId = (int)$_POST['event_id'];
$reason = trim($_POST['cancellation_reason']);

if (empty($reason)) {
    $_SESSION['error'] = "Please provide a cancellation reason";
    header("Location: event_view.php?id=$eventId");
    exit;
}

try {
    // Begin transaction
    $pdo->beginTransaction();
    
    // 1. Update event status
    $stmt = $pdo->prepare("UPDATE events 
                          SET status = 'cancelled',
                              cancellation_reason = ?,
                              cancelled_by = ?,
                              cancelled_at = NOW()
                          WHERE id = ? AND status = 'upcoming'");
    $stmt->execute([$reason, $_SESSION['user_id'], $eventId]);
    
    if ($stmt->rowCount() === 0) {
        throw new Exception("Event could not be cancelled (may already be past/cancelled)");
    }
    
    // 2. Get event details for notification
    $event = $pdo->query("SELECT * FROM events WHERE id = $eventId")->fetch();
    
    // 3. Log to audit table (create this table if needed)
    $pdo->prepare("INSERT INTO event_audit_log 
                  (event_id, action, performed_by, details)
                  VALUES (?, 'cancellation', ?, ?)")
         ->execute([$eventId, $_SESSION['user_id'], "Cancelled: $reason"]);
    
    // 4. Send notifications
    $admins = $pdo->query("SELECT email FROM users WHERE role = 'admin'")->fetchAll();
    
    foreach ($admins as $admin) {
        sendCancellationEmail(
            $admin['email'],
            $event['title'],
            $reason,
            $_SESSION['user_name'],
            date('Y-m-d H:i:s')
        );
    }
    
    $pdo->commit();
    
    $_SESSION['message'] = "Event cancelled successfully. Admins have been notified.";
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['error'] = $e->getMessage();
}

header("Location: event_view.php?id=$eventId");
exit;

// Email function would be in mailer.php
// Replace the email sending code with:
if (file_exists('mailer.php')) {
    require_once 'mailer.php';
    
    // Send to admins
    $admins = $pdo->query("SELECT email FROM users WHERE role = 'admin'")->fetchAll();
    foreach ($admins as $admin) {
        $subject = "Event Cancelled: " . $event['title'];
        $body = "<h2>Event Cancellation Notification</h2>
                <p><strong>Event:</strong> {$event['title']}</p>
                <p><strong>Cancelled by:</strong> {$_SESSION['user_name']}</p>
                <p><strong>Reason:</strong> $reason</p>";
        
        sendEmailNotification($admin['email'], $subject, $body);
    }
    
    // Send to event creator if different
    if ($event['created_by'] != $_SESSION['user_id']) {
        $creator = $pdo->query("SELECT email FROM users WHERE id = {$event['created_by']}")->fetch();
        if ($creator) {
            $subject = "Your Event Was Cancelled: " . $event['title'];
            $body = "<h2>Your Event Was Cancelled</h2>
                    <p><strong>Event:</strong> {$event['title']}</p>
                    <p><strong>Cancelled by:</strong> {$_SESSION['user_name']}</p>
                    <p><strong>Reason:</strong> $reason</p>";
            
            sendEmailNotification($creator['email'], $subject, $body);
        }
    }
}
?>