<?php
$servername = "localhost"; // or "srv1388.hstgr.io"
$username = "root";   // replace with your DB username
$password = "secret";   // replace with your DB password
$dbname = "importanceleadership";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Success message (optional)
echo "Connected successfully to the database!";
?>
