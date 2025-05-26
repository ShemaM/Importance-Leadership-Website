<?php
header('Content-Type: application/json');

// Database credentials
$host = 'localhost';
$username = 'root';
$password_db = 'secret';
$dbname = 'importanceleadership';

// Create MySQLi connection
$conn = new mysqli($host, $username, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]);
    exit;
}

// Get and sanitize form data
$firstname = trim($_POST['firstname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$repeat_password = $_POST['confirmPassword'] ?? ''; // match your form field name exactly

// Validation errors container
$errors = [];

// Validate firstname
if (empty($firstname)) {
    $errors['firstname'] = 'First name is required';
}

// Validate email and check uniqueness
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Valid email is required';
} else {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['email'] = 'Email already registered';
        }
        $stmt->close();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database query failed: ' . $conn->error
        ]);
        $conn->close();
        exit;
    }
}

// Validate password
if (empty($password)) {
    $errors['password'] = 'Password is required';
} elseif (strlen($password) < 8) {
    $errors['password'] = 'Password must be at least 8 characters';
}

// Validate password confirmation
if ($password !== $repeat_password) {
    $errors['confirmPassword'] = 'Passwords do not match';
}

// Return first validation error, if any
if (!empty($errors)) {
    $firstErrorKey = array_key_first($errors);
    echo json_encode([
        'success' => false,
        'message' => $errors[$firstErrorKey],
        'field' => $firstErrorKey
    ]);
    $conn->close();
    exit;
}

// Hash the password securely
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$insert = $conn->prepare("INSERT INTO users (firstname, email, password) VALUES (?, ?, ?)");
if (!$insert) {
    echo json_encode([
        'success' => false,
        'message' => 'Insert preparation failed: ' . $conn->error
    ]);
    $conn->close();
    exit;
}

$insert->bind_param("sss", $firstname, $email, $hashedPassword);

if ($insert->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Registration successful! Welcome, ' . htmlspecialchars($firstname),
        'redirect' => 'signupSuccess.html'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Registration failed. Please try again. Error: ' . $insert->error
    ]);
}

$insert->close();
$conn->close();
?>
