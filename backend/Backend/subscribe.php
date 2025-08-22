<?php
// Database connection details
$host = "localhost";  // Change if needed
$username = "root";
$password = "secret";
$database = "importanceleadership";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address!'); window.history.back();</script>";
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('You are already subscribed!'); window.history.back();</script>";
        exit;
    }
    $stmt->close();

    // Insert new subscriber
    $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);
    
    if ($stmt->execute()) {
        // Redirect to sample newsletter after successful subscription
        header("Location: newsfeed.html");
        exit;
    } else {
        echo "<script>alert('Subscription failed. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
