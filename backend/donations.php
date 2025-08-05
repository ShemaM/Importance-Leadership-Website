<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$pageTitle = "Donations Management";
$activePage = "donations";

// Get all donations with user info
try {
    $donations = $pdo->query("
        SELECT d.*, u.firstname, u.lastname 
        FROM donations d
        LEFT JOIN users u ON d.user_id = u.id
        ORDER BY d.donation_date DESC
    ")->fetchAll();
} catch (PDOException $e) {
    die("Error fetching donations: " . $e->getMessage());
}

// Get donation statistics
try {
    $stats = $pdo->query("
        SELECT 
            SUM(amount) as total,
            COUNT(*) as count,
            AVG(amount) as average,
            MAX(amount) as max,
            MIN(amount) as min
        FROM donations
    ")->fetch();
} catch (PDOException $e) {
    die("Error fetching donation stats: " . $e->getMessage());
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
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="label">Total Donations</div>
                        <div class="value">$<?= number_format($stats['total'], 2) ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="label">Number of Donations</div>
                        <div class="value"><?= number_format($stats['count']) ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="label">Average Donation</div>
                        <div class="value">$<?= number_format($stats['average'], 2) ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="label">Largest Donation</div>
                        <div class="value">$<?= number_format($stats['max'], 2) ?></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Donations</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Donor</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($donations as $donation): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($donation['firstname'] . ' ' . $donation['lastname']) ?>
                                    </td>
                                    <td>$<?= number_format($donation['amount'], 2) ?></td>
                                    <td><?= date('M j, Y', strtotime($donation['donation_date'])) ?></td>
                                    <td><?= ucfirst($donation['payment_method'] ?? 'N/A') ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $donation['status'] === 'completed' ? 'success' : 
                                            ($donation['status'] === 'pending' ? 'warning' : 'secondary')
                                        ?>">
                                            <?= ucfirst($donation['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="donation_view.php?id=<?= $donation['id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-success">
                                            <i class="fas fa-receipt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>