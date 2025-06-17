<?php
session_start();

// 1. Verify the user just signed up
if (empty($_SESSION['signup_complete'])) {
    header("Location: signup.php");
    exit();
}

// 2. Generate one-time access token
$_SESSION['dashboard_token'] = bin2hex(random_bytes(32));
$dashboard_url = "dashboard.php?token=" . $_SESSION['dashboard_token'];

// 3. Clear the signup flag
unset($_SESSION['signup_complete']);

// 4. Redirect to dashboard with token
header("Location: $dashboard_url");
exit();
?>