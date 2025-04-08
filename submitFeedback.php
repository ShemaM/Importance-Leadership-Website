<?php
$servername = "localhost";
$username = "root";
$password = "secret";
$dbname = "importanceleadership";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $program = $conn->real_escape_string($_POST['program']);
    $feedback = $conn->real_escape_string($_POST['feedback']);

    $insertSql = "INSERT INTO feedback (name, email, program, feedback) VALUES ('$name', '$email', '$program', '$feedback')";

    if ($conn->query($insertSql)) {
        echo "Feedback submitted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->close();
?>