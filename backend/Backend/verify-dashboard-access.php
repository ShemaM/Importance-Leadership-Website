<?php
session_start();

// 1. Verify token exists and matches
if (empty($_POST['access_token']) || 
    empty($_SESSION['dashboard_token']) || 
    $_POST['access_token'] !== $_SESSION['dashboard_token']) {
    header("Location: join-us.html?error=invalid_access");
    exit();
}

// 2. Verify user exists
require_once 'db_connect.php';
$stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$userExists = $stmt->fetch();

if (!$userExists) {
    header("Location: join-us.html?error=invalid_user");
    exit();
}

// 3. Create session auth token
$_SESSION['auth_token'] = bin2hex(random_bytes(32));
$_SESSION['auth_time'] = time();

// 4. Clear one-time token
unset($_SESSION['dashboard_token']);

// 5. Redirect to dashboard
header("Location: userDashboard.php");
exit();
?>