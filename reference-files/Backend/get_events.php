<?php
require_once 'db_connect.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT 
                        id, title, description, event_date, event_time,
                        location, status, cancellation_reason, cancelled_at
                        FROM events
                        ORDER BY 
                            CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END,
                            start_datetime ASC");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($events);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}