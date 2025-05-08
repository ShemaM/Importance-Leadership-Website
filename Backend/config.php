<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'u677171043_root');
define('DB_PASS', 'Nm&&668852');
define('DB_NAME', 'u677171043_shemamanase992');
define('ENVIRONMENT', 'production');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Stripe setup
require_once 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_your_secret_key_here');

define('SUCCESS_URL', 'http://importanceleadership.com/donation_success.php');
define('CANCEL_URL', 'http://importanceleadership.com/donate.html');
?>
