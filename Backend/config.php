<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'secret');
define('DB_NAME', 'importanceleadership');
define('ENVIRONMENT', 'development'); // Change to 'production' on live server

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// config.php
require_once 'vendor/autoload.php';

// Set your secret key. Remember to switch to your live secret key in production!
\Stripe\Stripe::setApiKey('sk_test_your_secret_key_here');

// Set your success and cancel URLs
define('SUCCESS_URL', 'http://importanceleadership.com/donation_success.php');
define('CANCEL_URL', 'http://importanceleadership.com/donate.html');
?>
