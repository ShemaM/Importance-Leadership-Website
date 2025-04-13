<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$pageTitle = "Reports";
$activePage = "reports";

// Get report data
try {
    // Program participation
    $programParticipation = $pdo->query("
        SELECT 
            p.name as program,
            COUNT(lp.id) as leadership_count,
            COUNT(mp.id) as mentorship_count,
            COUNT(cp.id) as community_count
        FROM programs p
        LEFT JOIN leadership_participants lp ON p.name LIKE '%Leadership%'
        LEFT JOIN mentorship_participants mp ON p.name LIKE '%Mentorship%'
        LEFT JOIN community_impact_participants cp ON p.name LIKE '%Community%'
        GROUP BY p.id
    ")->fetchAll();

    // Monthly donations
    $monthlyDonations = $pdo->query("
        SELECT 
            DATE_FORMAT(donation_date, '%Y-%m') as month,
            SUM(amount) as total
        FROM donations
        WHERE donation_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY DATE_FORMAT(donation_date, '%Y-%m')
        ORDER BY month
    ")->fetchAll();

    // Mentor-mentee ratio
    $mentorshipStats = $pdo->query("
        SELECT 
            (SELECT COUNT(*) FROM mentors WHERE status = 'active') as active_mentors,
            (SELECT COUNT(*) FROM mentees) as total_mentees
    ")->fetch();

} catch (PDOException $e) {
    die("Error fetching report data: " . $e->getMessage());
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
    <link rel="stylesheet" href="assets/css/admin.css">
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'header.php'; ?>
        
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Program Participation</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="programChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Monthly Donations</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="donationChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Mentorship Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">Active Mentors</div>
                                        <div class="value"><?= $mentorshipStats['active_mentors'] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">Mentees</div>
                                        <div class="value"><?= $mentorshipStats['total_mentees'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <canvas id="mentorshipChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Recent Activity</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <?php
                                $activities = $pdo->query("
                                    (SELECT 'donation' as type, amount, donation_date as date, 'Donation received' as action
                                    FROM donations ORDER BY donation_date DESC LIMIT 3)
                                    
                                    UNION ALL
                                    
                                    (SELECT 'participant' as type, NULL as amount, created_at as date, 'New participant' as action
                                    FROM leadership_participants ORDER BY created_at DESC LIMIT 3)
                                    
                                    UNION ALL
                                    
                                    (SELECT 'subscriber' as type, NULL as amount, created_at as date, 'New subscriber' as action
                                    FROM subscribers ORDER BY created_at DESC LIMIT 3)
                                    
                                    ORDER BY date DESC LIMIT 5
                                ")->fetchAll();
                                
                                foreach ($activities as $activity):
                                ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <span><?= $activity['action'] ?></span>
                                        <small class="text-muted"><?= date('M j, g:i a', strtotime($activity['date'])) ?></small>
                                    </div>
                                    <?php if ($activity['amount']): ?>
                                    <div class="text-end">
                                        <span class="badge bg-success">$<?= number_format($activity['amount'], 2) ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Program Participation Chart
        const programCtx = document.getElementById('programChart').getContext('2d');
        new Chart(programCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($programParticipation, 'program')) ?>,
                datasets: [
                    {
                        label: 'Leadership',
                        data: <?= json_encode(array_column($programParticipation, 'leadership_count')) ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Mentorship',
                        data: <?= json_encode(array_column($programParticipation, 'mentorship_count')) ?>,
                        backgroundColor: 'rgba(255, 206, 86, 0.7)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Community',
                        data: <?= json_encode(array_column($programParticipation, 'community_count')) ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Monthly Donations Chart
        const donationCtx = document.getElementById('donationChart').getContext('2d');
        new Chart(donationCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($monthlyDonations, 'month')) ?>,
                datasets: [{
                    label: 'Monthly Donations',
                    data: <?= json_encode(array_column($monthlyDonations, 'total')) ?>,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Mentorship Chart
        const mentorshipCtx = document.getElementById('mentorshipChart').getContext('2d');
        new Chart(mentorshipCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active Mentors', 'Mentees'],
                datasets: [{
                    data: [
                        <?= $mentorshipStats['active_mentors'] ?>,
                        <?= $mentorshipStats['total_mentees'] ?>
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>
</html>