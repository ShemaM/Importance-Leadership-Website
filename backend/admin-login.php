<?php
session_start();
require_once 'db_connect.php';

// Redirect if already logged in
if (!empty($_SESSION['admin_auth_token'])) {
    header("Location: admin.php");
    exit();
}

if ($admin && password_verify($password, $admin['password_hash'])) {
    // Create admin session
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_username'] = $admin['first_name']; // Add this line
    $_SESSION['admin_logged_in'] = true; // This is critical
    $_SESSION['admin_auth_token'] = bin2hex(random_bytes(32));
    $_SESSION['admin_auth_time'] = time();
    
    // Update last login
    $pdo->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?")
        ->execute([$admin['id']]);
    
    header("Location: clientSide.php");
    exit();
}
// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("
            SELECT id, first_name, password_hash 
            FROM admin_users 
            WHERE email = ? AND status = 'active'
        ");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            // Create admin session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_auth_token'] = bin2hex(random_bytes(32));
            $_SESSION['admin_auth_time'] = time();
            
            // Update last login
            $pdo->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?")
                ->execute([$admin['id']]);
            
            header("Location: clientSide.php");
            exit();
        } else {
            $error = "Invalid credentials";
        }
    } catch (PDOException $e) {
        error_log("Admin login error: " . $e->getMessage());
        $error = "Login temporarily unavailable";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Admin Login</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($_GET['error'])): ?>
                            <div class="alert alert-warning">
                                <?php 
                                $errors = [
                                    'session_expired' => 'Your session has expired',
                                    'session_timeout' => 'Session timed out',
                                    'invalid_credentials' => 'Please login again',
                                    'db_error' => 'Database error occurred'
                                ];
                                echo htmlspecialchars($errors[$_GET['error']] ?? 'Login required');
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>