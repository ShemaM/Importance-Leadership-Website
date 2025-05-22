<?php
$servername = "82.197.82.19"; // or "srv1388.hstgr.io"
$username = "nmshema";   // replace with your DB username
$password = "Nm&&668852";   // replace with your DB password
$dbname = "u677171043_importancelead";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Success message (optional)
echo "Connected successfully to the database!";
?>
