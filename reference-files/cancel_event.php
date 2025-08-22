<?php
require_once 'auth_check.php';

// Ensure user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit(json_encode(['success' => false, 'message' => 'User not authenticated']));
}
require_once 'db_connect.php';

// Set JSON header
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    exit(json_encode(['success' => false, 'message' => 'Direct access not allowed']));
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    exit(json_encode(['success' => false, 'message' => 'Invalid request token']));
}

/* Check admin privileges
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    http_response_code(403);
    exit(json_encode(['success' => false, 'message' => 'Admin privileges required']));
}
*/

// Validate required fields
if (!isset($_POST['event_id']) || !isset($_POST['cancellation_reason'])) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Missing required fields']));
}

$eventId = (int)$_POST['event_id'];
$reason = trim($_POST['cancellation_reason']);

if (empty($reason)) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Cancellation reason cannot be empty']));
}

try {
    // Update event status in database
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

    // Get updated event data
    $stmt = $pdo->prepare("SELECT 
                          e.*,
                          u1.name as creator_name,
                          u2.name as canceller_name
                          FROM events e
                          LEFT JOIN users u1 ON e.created_by = u1.id
                          LEFT JOIN users u2 ON e.cancelled_by = u2.id
                          WHERE e.id = ?");
    $stmt->execute([$eventId]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return success with event data
    echo json_encode([
        'success' => true,
        'message' => 'Event cancelled successfully',
        'event' => $event
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error cancelling event: ' . $e->getMessage()]);
}