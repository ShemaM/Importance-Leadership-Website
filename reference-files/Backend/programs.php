<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$pageTitle = "Program Management Dashboard";
$activePage = "programs";

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Define our core programs
$corePrograms = [
    'Community Impact' => [
        'description' => 'Initiatives that connect participants with community service opportunities',
        'table' => 'community_impact_participants'
    ],
    'Leadership' => [
        'description' => 'Develop essential leadership skills through workshops and real-world projects',
        'table' => 'leadership_participants'
    ],
    'Mentorship' => [
        'description' => 'Pair experienced mentors with mentees for professional development',
        'table' => 'mentorship_participants'
    ]
];

// Get participant counts for each program
$programStats = [];
$totalParticipants = 0;
$activeParticipants = 0;
$newThisMonth = 0;

foreach ($corePrograms as $name => $program) {
    try {
        $table = $program['table'];
        
        // Total participants
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
        $total = $stmt->fetchColumn();
        
        // New this month
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)");
        $new = $stmt->fetchColumn();
        
        $programStats[$name] = [
            'total' => $total,
            'new' => $new,
            'table' => $table,
            'description' => $program['description']
        ];
        
        $totalParticipants += $total;
        $newThisMonth += $new;
        
    } catch (PDOException $e) {
        $programStats[$name] = [
            'total' => 0,
            'new' => 0,
            'table' => $table,
            'description' => $program['description']
        ];
        $_SESSION['error'] = "Error loading program data: " . $e->getMessage();
    }
}

// Get recent participants across all programs (last 10 signups)
$recentParticipants = [];
try {
    $query = "
        (SELECT id, CONCAT(firstname, ' ', lastname) as name, email, 'Community Impact' as program, created_at 
         FROM community_impact_participants 
         ORDER BY created_at DESC LIMIT 5)
        
        UNION ALL
        
        (SELECT id, CONCAT(firstname, ' ', lastname) as name, email, 'Leadership' as program, created_at 
         FROM leadership_participants 
         ORDER BY created_at DESC LIMIT 5)
        
        UNION ALL
        
        (SELECT id, CONCAT(firstname, ' ', lastname) as name, email, 'Mentorship' as program, created_at 
         FROM mentorship_participants 
         ORDER BY created_at DESC LIMIT 5)
        
        ORDER BY created_at DESC 
        LIMIT 10
    ";
    
    $recentParticipants = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Error loading recent participants: " . $e->getMessage();
}

// Get gender distribution for each program
$genderStats = [];
foreach ($corePrograms as $name => $program) {
    try {
        $table = $program['table'];
        $stmt = $pdo->query("
            SELECT gender, COUNT(*) as count 
            FROM $table 
            GROUP BY gender
        ");
        $genderStats[$name] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (PDOException $e) {
        $genderStats[$name] = [];
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4cc9f0;
            --primary-dark: #3f37c9;
            --secondary: #7209b7;
            --success: #4bb543;
            --warning: #ffbe0b;
            --danger: #f72585;
            --light: #f8f9fa;
            --dark: #1a1a2e;
            --gray: #6c757d;
            --light-gray: #e9ecef;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: var(--dark);
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--dark) 0%, #16213e 100%);
            color: white;
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        .sidebar-brand img {
            max-width: 180px;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 20px;
            margin: 0 10px 5px;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .nav-link.active i {
            color: var(--primary-light);
        }
        
        .main-content {
            margin-left: 260px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .header {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h4 {
            margin: 0;
            font-weight: 600;
            color: var(--dark);
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card .label {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 5px;
        }
        
        .stat-card .value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }
        
        .stat-card .trend {
            font-size: 0.85rem;
            display: flex;
            align-items: center;
        }
        
        .stat-card .trend.up {
            color: var(--success);
        }
        
        .stat-card .trend.down {
            color: var(--danger);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
            border-radius: 10px 10px 0 0 !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--dark);
        }
        
        .badge {
            font-weight: 500;
            padding: 5px 10px;
            font-size: 0.75rem;
        }
        
        .badge-primary {
            background-color: rgba(67, 97, 238, 0.2);
            color: var(--primary);
        }
        
        .badge-success {
            background-color: rgba(75, 181, 67, 0.2);
            color: var(--success);
        }
        
        .badge-warning {
            background-color: rgba(255, 190, 11, 0.2);
            color: var(--warning);
        }
        
        .program-card {
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }
        
        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .participant-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .progress {
            height: 8px;
            border-radius: 4px;
        }
        
        .progress-bar {
            background-color: var(--primary);
        }
        
        .gender-male {
            color: #3a86ff;
        }
        
        .gender-female {
            color: #ff006e;
        }
        
        .gender-other {
            color: #8338ec;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'header.php'; ?>
        
        <!-- Messages/Alerts -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $_SESSION['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Stats Overview -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Total Programs</div>
                    <div class="value"><?= count($corePrograms) ?></div>
                    <div class="trend up">
                        <i class="fas fa-project-diagram"></i> 
                        All programs active
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Total Participants</div>
                    <div class="value"><?= number_format($totalParticipants) ?></div>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i> 
                        <?= $newThisMonth ?> new this month
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Community Impact</div>
                    <div class="value"><?= number_format($programStats['Community Impact']['total']) ?></div>
                    <div class="trend up">
                        <i class="fas fa-users"></i> 
                        <?= $programStats['Community Impact']['new'] ?> new
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Leadership</div>
                    <div class="value"><?= number_format($programStats['Leadership']['total']) ?></div>
                    <div class="trend up">
                        <i class="fas fa-users"></i> 
                        <?= $programStats['Leadership']['new'] ?> new
                    </div>
                </div>
            </div>
        </div>

        <!-- Programs Overview -->
        <div class="row">
            <!-- Program Statistics -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Program Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Program</th>
                                        <th>Participants</th>
                                        <th>New (30 days)</th>
                                        <th>Gender Distribution</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($corePrograms as $name => $program): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($name) ?></strong>
                                            <p class="text-muted small mb-0"><?= htmlspecialchars($program['description']) ?></p>
                                        </td>
                                        <td><?= number_format($programStats[$name]['total']) ?></td>
                                        <td><?= number_format($programStats[$name]['new']) ?></td>
                                        <td>
                                            <div class="d-flex gap-3">
                                                <?php 
                                                $genderData = $genderStats[$name] ?? [];
                                                foreach (['Male', 'Female', 'Other'] as $gender): 
                                                    $count = $genderData[$gender] ?? 0;
                                                    if ($count > 0):
                                                ?>
                                                <span class="gender-<?= strtolower($gender) ?>">
                                                    <i class="fas fa-<?= strtolower($gender) == 'male' ? 'mars' : (strtolower($gender) == 'female' ? 'venus' : 'transgender') ?>"></i>
                                                    <?= $count ?>
                                                </span>
                                                <?php endif; endforeach; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="program_participants.php?program=<?= urlencode($name) ?>" class="btn btn-sm btn-outline-primary">
                                                View Participants
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
            
            <!-- Recent Participants -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Signups</h5>
                        <span class="badge bg-primary">Last 10</span>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recentParticipants)): ?>
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-users-slash fa-3x mb-3"></i>
                                <h5>No recent participants</h5>
                                <p>New signups will appear here</p>
                            </div>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recentParticipants as $participant): ?>
                                <div class="list-group-item border-0 px-0 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0"><?= htmlspecialchars($participant['name']) ?></h6>
                                            <small class="text-muted"><?= htmlspecialchars($participant['email']) ?></small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted"><?= date('M j', strtotime($participant['created_at'])) ?></small>
                                            <span class="badge bg-primary d-block mt-1"><?= htmlspecialchars($participant['program']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Program Details -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Program Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($corePrograms as $name => $program): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 program-card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($name) ?></h5>
                                <p class="text-muted small"><?= htmlspecialchars($program['description']) ?></p>
                                
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="text-muted small">Participants</span>
                                        <h4 class="mb-0"><?= number_format($programStats[$name]['total']) ?></h4>
                                    </div>
                                    <div>
                                        <span class="text-muted small">New (30d)</span>
                                        <h4 class="mb-0"><?= number_format($programStats[$name]['new']) ?></h4>
                                    </div>
                                </div>
                                
                                <div class="progress mb-3">
                                    <div class="progress-bar" style="width: <?= 
                                        $programStats[$name]['total'] > 0 ? 
                                        min(100, ($programStats[$name]['new']/$programStats[$name]['total'])*100) : 0 
                                    ?>%"></div>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <a href="program_participants.php?program=<?= urlencode($name) ?>" class="btn btn-sm btn-outline-primary">
                                        View Participants
                                    </a>
                                    <a href="export_program.php?program=<?= urlencode($name) ?>" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-download"></i> Export
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
</body>
</html>