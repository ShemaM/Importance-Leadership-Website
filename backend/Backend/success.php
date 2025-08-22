<?php
session_start();

// OPTIONAL: You can customize based on your user system (mentor, mentee, or admin)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Assuming admin access for dashboard (you can adapt this based on role)
$_SESSION['admin_id'] = $_SESSION['user_id']; // or a dedicated admin ID
$_SESSION['admin_auth_token'] = bin2hex(random_bytes(32));
$_SESSION['admin_auth_time'] = time();
$_SESSION['created'] = time();

// Redirect to admin dashboard
header("Location: userDashboard.php");
exit();
