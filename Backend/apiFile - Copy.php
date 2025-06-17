<?php
// Allow access from other domains (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Get POST data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';

// Respond with JSON
echo json_encode([
    "message" => "Hello $name! Your email is $email"
]);
?>
