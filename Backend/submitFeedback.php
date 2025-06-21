<?php
define('ENVIRONMENT', 'production'); // Change to 'development' for debugging
header('Content-Type: application/json');
require_once 'db_connection.php';

// CORS Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");

// Helper functions
function generateAvatar(?string $email, string $name): string {
    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=120";
    }
    $initials = mb_substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 2);
    return "https://ui-avatars.com/api/?name={$initials}&background=0b1f3a&color=fff";
}

function debugMessage(Throwable $e): ?string {
    return (defined('ENVIRONMENT') && ENVIRONMENT === 'development') ? $e->getMessage() : null;
}

// Main execution
try {
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getFeedback') {
        if (!($pdo instanceof PDO)) {
            throw new RuntimeException('Database connection failed');
        }

        $stmt = $pdo->prepare("
            SELECT 
                id,
                name,
                email,
                program,
                rating,
                feedback,
                submitted_at
            FROM feedback
            WHERE rating BETWEEN 1 AND 5
            ORDER BY submitted_at DESC
            LIMIT 10
        ");

        if (!$stmt->execute()) {
            throw new PDOException('Query execution failed');
        }

        $feedback = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = array_map(function($item) {
            return [
                'id' => (int)$item['id'],
                'name' => mb_substr(htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'), 0, 100),
                'email' => filter_var($item['email'], FILTER_VALIDATE_EMAIL) ? $item['email'] : null,
                'program' => mb_substr(htmlspecialchars($item['program'], ENT_QUOTES, 'UTF-8'), 0, 50),
                'rating' => min(5, max(1, (int)($item['rating'] ?? 5))),
                'message' => htmlspecialchars($item['feedback'], ENT_QUOTES, 'UTF-8'),
                'date' => date('Y-m-d\TH:i:s', strtotime($item['submitted_at'])),
                'avatar' => generateAvatar($item['email'], $item['name'])
            ];
        }, $feedback);

        echo json_encode([
            'status' => 'success',
            'data' => $response,
            'meta' => [
                'count' => count($response),
                'generated_at' => date('c')
            ]
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => 'Endpoint not found'
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error',
        'debug' => debugMessage($e)
    ]);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request',
        'debug' => debugMessage($e)
    ]);
}