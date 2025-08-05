<?php
$servername = "localhost";
$username = "root";
$password = "secret";
$dbname = "importanceleadership";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$email = $conn->real_escape_string($_POST['email'] ?? '');
$sql = "SELECT id FROM users WHERE email = '$email' LIMIT 1"; // use your real table
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo json_encode(['exists' => true]);
} else {
    echo json_encode(['exists' => false]);
}

$conn->close();
?>
