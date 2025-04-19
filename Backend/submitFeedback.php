<?php
header('Content-Type: application/json');

$servername = "127.0.0.1";
$username = "root";
$password = "secret";
$dbname = "importanceleadership";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit();
}

// Check if form is submitted
// After processing the form...
echo json_encode(['success' => true]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $program = $conn->real_escape_string($_POST['program'] ?? '');
    $feedback = $conn->real_escape_string($_POST['feedback'] ?? '');

    if (empty($name) || empty($email) || empty($program) || empty($feedback)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields.']);
    } else {
        $insertSql = "INSERT INTO feedback (name, email, program, feedback) VALUES ('$name', '$email', '$program', '$feedback')";

        if ($conn->query($insertSql)) {
            echo json_encode(['status' => 'success', 'message' => 'Feedback submitted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
        }
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

$conn->close();
?>
