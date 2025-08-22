<?php
header('Content-Type: application/json');

// Configuration
$dbConfig = [
    'host' => 'localhost',
    'name' => 'importanceleadership',
    'user' => 'root',
    'pass' => 'secret',
    'charset' => 'utf8mb4'
];

// Validate request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get and sanitize input
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$subject = trim($_POST['subject'] ?? 'General Inquiry');
$message = trim($_POST['message'] ?? '');

// Validate fields
if ($name === '' || $email === '' || $subject === '' || $message === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

try {
    // Connect to database
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['name']};charset={$dbConfig['charset']}";
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Insert into database
    $stmt = $pdo->prepare("
        INSERT INTO contact_messages
        (name, email, subject, phone, message, status, created_at) 
        VALUES (:name, :email, :subject, :phone, :message, 'unread', NOW())
    ");

    $stmt->execute([
        ':name'    => htmlspecialchars($name),
        ':email'   => filter_var($email, FILTER_SANITIZE_EMAIL),
        ':subject' => htmlspecialchars($subject),
        ':phone'   => $phone !== '' ? htmlspecialchars($phone) : null,
        ':message' => htmlspecialchars($message)
    ]);

    echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully.']);
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
}
