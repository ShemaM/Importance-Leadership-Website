<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = 'localhost';
$dbname = 'importanceleadership';
$username = 'root';
$password = 'secret';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form data is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize form data
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING) ;
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING) ;
        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

        // Validate required fields
        if (empty($name) || empty($email)) {
            throw new Exception('Name and email are required fields.');
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }

        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO contactmessages (name, email, phone, message) VALUES (:name, :email, :phone, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':message', $comment);
        $stmt->execute();

        // Return success response
        echo json_encode(['success' => true, 'message' => 'Form submitted successfully!']);
    } else {
        // Handle invalid request method
        throw new Exception('Invalid request method.');
    }
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Handle other exceptions (e.g., validation errors)
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>