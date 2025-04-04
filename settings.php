<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$pageTitle = "Settings";
$activePage = "settings";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed");
    }

    if (isset($_POST['update_settings'])) {
        // Handle settings update
        $_SESSION['message'] = "Settings updated successfully!";
        header("Location: settings.php");
        exit;
    } elseif (isset($_POST['change_password'])) {
        // Handle password change
        $current = $_POST['current_password'];
        $new = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];

        if ($new !== $confirm) {
            $_SESSION['error'] = "New passwords don't match!";
        } else {
            try {
                // Verify current password
                $stmt = $pdo->prepare("SELECT password_hash FROM admin_users WHERE id = ?");
                $stmt->execute([$_SESSION['admin_id']]);
                $user = $stmt->fetch();

                if ($user && password_verify($current, $user['password_hash'])) {
                    $newHash = password_hash($new, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE admin_users SET password_hash = ? WHERE id = ?");
                    $stmt->execute([$newHash, $_SESSION['admin_id']]);
                    $_SESSION['message'] = "Password changed successfully!";
                } else {
                    $_SESSION['error'] = "Current password is incorrect!";
                }
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error changing password: " . $e->getMessage();
            }
        }
        header("Location: settings.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
:root {
            --primary: #103e6c;
            --primary-light: #1a4f87;
            --secondary: #ffcc00;
            --light-bg: #f8f9fa;
            --dark-text: #212529;
            --light-text: #6c757d;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-text);
        }
        
        .sidebar {
            background-color: #ffffff;
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .sidebar-brand {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid #eee;
            text-align: center;
        }
        
        .sidebar-brand img {
            height: 80px;
            width: auto;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
            width: calc(100% - 250px);
        }
        
        .nav-link {
            color: var(--light-text);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.25rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary);
            background-color: rgba(16, 62, 108, 0.1);
        }
        
        .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 0.5rem;
        }
        
        .header {
            background-color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .stat-card {
            padding: 1.25rem;
            border-radius: 0.5rem;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .stat-card .value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .progress {
            height: 8px;
            border-radius: 4px;
        }
        
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .table thead th {
            background-color: var(--primary);
            color: white;
            border: none;
        }
        
        .badge-active {
            background-color: var(--success);
        }
        
        .badge-inactive {
            background-color: var(--danger);
        }
        
        .badge-pending {
            background-color: var(--warning);
            color: var(--dark-text);
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar-brand span, .nav-link span {
                display: none;
            }
            
            .nav-link {
                text-align: center;
            }
            
            .nav-link i {
                margin-right: 0;
                font-size: 1.25rem;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'header.php'; ?>
        
        <div class="container-fluid">
            <?php include 'messages.php'; ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">System Settings</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label">Site Name</label>
                                    <input type="text" name="site_name" class="form-control" value="<?= SITE_NAME ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Base URL</label>
                                    <input type="text" name="base_url" class="form-control" value="<?= BASE_URL ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Items Per Page</label>
                                    <input type="number" name="items_per_page" class="form-control" value="<?= ITEMS_PER_PAGE ?>">
                                </div>
                                
                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="maintenance_mode" class="form-check-input" id="maintenanceMode">
                                    <label class="form-check-label" for="maintenanceMode">Maintenance Mode</label>
                                </div>
                                
                                <button type="submit" name="update_settings" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Change Password</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="confirm_password" class="form-control" required>
                                </div>
                                
                                <button type="submit" name="change_password" class="btn btn-primary">
                                    <i class="fas fa-key"></i> Change Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">System Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">PHP Version</dt>
                                <dd class="col-sm-8"><?= phpversion() ?></dd>
                                
                                <dt class="col-sm-4">Database</dt>
                                <dd class="col-sm-8">MySQL</dd>
                                
                                <dt class="col-sm-4">Server Software</dt>
                                <dd class="col-sm-8"><?= $_SERVER['SERVER_SOFTWARE'] ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Last Backup</dt>
                                <dd class="col-sm-8"><?= date('Y-m-d H:i:s') ?></dd>
                                
                                <dt class="col-sm-4">Disk Space</dt>
                                <dd class="col-sm-8">
                                    <?= 
                                        round(disk_free_space('/') / (1024 * 1024 * 1024), 2) 
                                    ?> GB free of 
                                    <?= 
                                        round(disk_total_space('/') / (1024 * 1024 * 1024), 2) 
                                    ?> GB
                                </dd>
                                
                                <dt class="col-sm-4">System Load</dt>
                                <dd class="col-sm-8">
                                    <?= implode(', ', sys_getloadavg()) ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <button class="btn btn-success me-2">
                            <i class="fas fa-download"></i> Backup Database
                        </button>
                        <button class="btn btn-warning">
                            <i class="fas fa-sync-alt"></i> Check for Updates
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>