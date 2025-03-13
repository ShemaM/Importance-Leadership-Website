<?php
header('Content-Type: application/json'); // Set response type to JSON

// Database configuration
$host = 'localhost';
$dbname = 'importanceleadership';
$username = 'root';
$password = 'secret';

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'errors' => ['Database connection failed']]);
    exit;
}

// Get form data
$firstname = trim($_POST['firstname']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$repeat_password = $_POST['repeat_password'];

// Validate input
$errors = [];
if (empty($firstname)) {
    $errors[] = 'Firstname is required.';
}
if (empty($email)) {
    $errors[] = 'Email is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
}
if (empty($password)) {
    $errors[] = 'Password is required.';
} elseif (strlen($password) < 8) {
    $errors[] = 'Password must be at least 8 characters long.';
}
if ($password !== $repeat_password) {
    $errors[] = 'Passwords do not match.';
}

// If no errors, proceed with signup
if (empty($errors)) {
    // Check if email already exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = 'Email already exists.';
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $stmt = $pdo->prepare('INSERT INTO users (firstname, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$firstname, $email, $hashed_password]);

        // Return success response
        echo json_encode(['success' => true, 'message' => 'Signup successful!']);
        exit;
    }
}

// Return error response
echo json_encode(['success' => false, 'errors' => $errors]);
exit;