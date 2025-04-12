
<?php 
// Start secure session
session_start([
    'cookie_lifetime' => 86400,
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'use_strict_mode' => true
]);

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Constants
define('BASE_URL', 'https://importanceleadership.com/admin');
define('SITE_NAME', 'Importance Leadership');
define('ITEMS_PER_PAGE', 20);

// Database configuration
$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'importanceleadership',
    'username' => 'root',
    'password' => 'secret'
];

// Establish PDO connection
try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// CSRF protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Authentication check
function requireAuth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: admin-login.php?error=session_expired");
        exit();
    }
}

// Admin table setup
try {
    // Check if table exists
    $tableExists = $pdo->query("SHOW TABLES LIKE 'admin_users'")->rowCount() > 0;

    if (!$tableExists) {
        $pdo->exec("CREATE TABLE admin_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    } else {
        // Clean old password column if it still exists
        $passwordColExists = $pdo->query("SHOW COLUMNS FROM admin_users LIKE 'password'")->rowCount() > 0;
        if ($passwordColExists) {
            $pdo->exec("ALTER TABLE admin_users DROP COLUMN password");
        }

        // Ensure password_hash column exists
        $hashColExists = $pdo->query("SHOW COLUMNS FROM admin_users LIKE 'password_hash'")->rowCount() > 0;
        if (!$hashColExists) {
            $pdo->exec("ALTER TABLE admin_users ADD COLUMN password_hash VARCHAR(255) NOT NULL AFTER username");
        }
    }

    // Create default admin if table is empty
    $adminCount = $pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
    if ($adminCount == 0) {
        $username = 'admin';
        $password = 'admin123'; // Change in production!
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
        $stmt->execute([$username, $hash]);

        if (strpos(BASE_URL, 'yourdomain.com') !== false) {
            echo "Default admin created — Username: <strong>admin</strong>, Password: <strong>admin123</strong><br>";
            echo "⚠️ Please change this password immediately!";
        }
    }
} catch (PDOException $e) {
    die("Admin user setup error: " . $e->getMessage());
}

// Logout handler
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: admin-login.php?error=session_expired");
    exit();
}

// Require authentication before loading dashboard
requireAuth();

// Validate required tables and columns
$requiredTables = [
    'admin_users' => ['id', 'username', 'password_hash', 'created_at'],
    'community_impact_participants' => ['id', 'firstname', 'lastname', 'email', 'created_at'],
    'leadership_participants' => ['id', 'firstname', 'lastname', 'email', 'created_at'],
    'mentorship_participants' => ['id', 'firstname', 'lastname', 'email', 'created_at'],
    'donations' => ['id', 'amount', 'donation_date', 'user_id'],
    'contactmessages' => ['id', 'name', 'email', 'message', 'created_at'],
    'users' => ['id', 'firstname', 'lastname', 'email', 'created_at'],
    'mentors' => ['id', 'firstname', 'lastname', 'email', 'password', 'profession', 'expertise', 'created_at'],
    'newsletter_subscribers' => ['id', 'email', 'created_at'],
    'mentees' => ['id', 'firstname', 'lastname', 'email', 'password', 'interests', 'goals', 'created_at'],
    'programs' => ['id', 'name', 'description', 'start_date', 'end_date', 'status'],
    'subscribers' => ['id', 'email', 'created_at'],
];

foreach ($requiredTables as $table => $columns) {
    try {
        $stmt = $pdo->query("DESCRIBE $table");
        $existingCols = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $missing = array_diff($columns, $existingCols);

        if (!empty($missing)) {
            die("Error: Missing columns in `$table`: " . implode(', ', $missing));
        }
    } catch (PDOException $e) {
        die("Error: Table '$table' not found or not accessible.");
    }
}

// Dashboard data loading
try {
    // Fetch unread notifications count
    $unreadNotificationsCount = $pdo->query("SELECT COUNT(*) FROM notifications WHERE is_read = 0")->fetchColumn();
    $totalParticipants = $pdo->query("
        SELECT 
            (SELECT COUNT(*) FROM leadership_participants) +
            (SELECT COUNT(*) FROM mentorship_participants) +
            (SELECT COUNT(*) FROM community_impact_participants) +
            (SELECT COUNT(*) FROM mentees)
        AS total
    ")->fetch()['total'];

    $recentDonations = $pdo->query("
        SELECT d.amount, d.donation_date, u.firstname, u.lastname
        FROM donations d
        LEFT JOIN users u ON d.user_id = u.id
        ORDER BY d.donation_date DESC
        LIMIT 5
    ")->fetchAll();

    $programStats = $pdo->query("
        SELECT 
            p.name AS program,
            COUNT(DISTINCT lp.id) + COUNT(DISTINCT mp.id) + COUNT(DISTINCT cp.id) AS participants,
            DATEDIFF(p.end_date, p.start_date) AS duration_days,
            p.status
        FROM programs p
        LEFT JOIN leadership_participants lp ON p.name LIKE '%Leadership%'
        LEFT JOIN mentorship_participants mp ON p.name LIKE '%Mentorship%'
        LEFT JOIN community_impact_participants cp ON p.name LIKE '%Community%'
        GROUP BY p.id
    ")->fetchAll();

    $totalDonations = $pdo->query("SELECT SUM(amount) as total FROM donations")->fetch()['total'];

    $monthlyDonations = $pdo->query("
        SELECT SUM(amount) as total 
        FROM donations 
        WHERE donation_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
    ")->fetch()['total'];

    $mentorshipStats = $pdo->query("
        SELECT 
            COUNT(*) as total_mentors,
            (SELECT COUNT(*) FROM mentees) as total_mentees,
            (SELECT COUNT(*) FROM mentors WHERE status = 'active') as active_mentors,
            (SELECT COUNT(*) FROM mentors WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) as new_mentors
        FROM mentors
    ")->fetch();

    $subscriberStats = $pdo->query("
        SELECT 
            (SELECT COUNT(*) FROM newsletter_subscribers) as newsletter_subscribers,
            (SELECT COUNT(*) FROM subscribers) as general_subscribers,
            (SELECT COUNT(*) FROM newsletter_subscribers WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) as new_newsletter_subscribers
    ")->fetch();

} catch (PDOException $e) {
    die("Dashboard load error: " . $e->getMessage());
}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(SITE_NAME) ?> - Admin Dashboard</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles/admin.css">
  
    
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="image/website-logo.png" alt="<?= htmlspecialchars(SITE_NAME) ?> Logo">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="dashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="programs.php">
                    <i class="fas fa-project-diagram"></i>
                    <span>Programs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="participants.php">
                    <i class="fas fa-users"></i>
                    <span>Participants</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="mentors.php">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Mentors</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="mentees.php">
                    <i class="fas fa-user-graduate"></i>
                    <span>Mentees</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="events.php">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Events</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="donations.php">
                    <i class="fas fa-donate"></i>
                    <span>Donations</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="subscribers.php">
                    <i class="fas fa-envelope"></i>
                    <span>Subscribers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reports.php">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="settings.php">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h4>Admin Dashboard</h4>
            <div class="d-flex align-items-center">
                <div class="me-3 position-relative">
                    <a href="notifications.php" class="text-dark">
                            <?= htmlspecialchars($unreadNotificationsCount) ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $pdo->query("SELECT COUNT(*) FROM notifications WHERE is_read = 0")->fetchColumn() ?>
                        </span>
                    </a>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown">
                        <img src="image/shema.png" alt="Admin" class="admin-avatar me-2"> 
                        <span><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="?logout=1"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Total Participants</div>
                    <div class="value"><?= number_format($totalParticipants) ?></div>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i> 
                        <?php
                        $stmt = $pdo->query("
                            SELECT 
                                (SELECT COUNT(*) FROM leadership_participants WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) +
                                (SELECT COUNT(*) FROM mentorship_participants WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) +
                                (SELECT COUNT(*) FROM community_impact_participants WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) +
                                (SELECT COUNT(*) FROM mentees WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) AS current_month
                        ");
                        echo $stmt->fetch()['current_month'] . ' new this month';
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Mentorship Pairs</div>
                    <div class="value">
                        <?= number_format(min($mentorshipStats['active_mentors'], $mentorshipStats['total_mentees'])) ?>
                    </div>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i> 
                        <?= $mentorshipStats['new_mentors'] ?> new mentors
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Active Programs</div>
                    <div class="value">
                        <?= $pdo->query("SELECT COUNT(*) FROM programs WHERE status = 'active'")->fetchColumn() ?>
                    </div>
                    <div class="trend up">
                        <i class="fas fa-check-circle"></i> 
                        <?= $pdo->query("SELECT COUNT(*) FROM programs")->fetchColumn() ?> total
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Subscribers</div>
                    <div class="value"><?= number_format($subscriberStats['newsletter_subscribers'] + $subscriberStats['general_subscribers']) ?></div>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i> 
                        <?= $subscriberStats['new_newsletter_subscribers'] ?> new newsletter
                    </div>
                </div>
            </div>
        </div>

        <!-- Programs Overview -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Programs Overview</h5>
                <a href="programs.php" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th>Participants</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($programStats as $program): ?>
                            <tr>
                                <td><?= htmlspecialchars($program['program']) ?></td>
                                <td><?= number_format($program['participants']) ?></td>
                                <td><?= $program['duration_days'] ?> days</td>
                                <td>
                                    <span class="badge <?= $program['status'] == 'active' ? 'badge-active' : ($program['status'] == 'pending' ? 'badge-pending' : 'badge-inactive') ?>">
                                        <?= ucfirst($program['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="program_details.php?id=<?= $program['id'] ?>" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Mentorship Stats -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Mentorship Statistics</h5>
                <a href="mentors.php" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="label">Total Mentors</div>
                            <div class="value"><?= number_format($mentorshipStats['total_mentors']) ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="label">Active Mentors</div>
                            <div class="value"><?= number_format($mentorshipStats['active_mentors']) ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="label">Total Mentees</div>
                            <div class="value"><?= number_format($mentorshipStats['total_mentees']) ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="label">New This Month</div>
                            <div class="value"><?= number_format($mentorshipStats['new_mentors']) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Donations</h5>
                        <a href="donations.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <?php foreach ($recentDonations as $donation): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">
                                        <?= htmlspecialchars($donation['firstname'] . ' ' . $donation['lastname']) ?>
                                    </h6>
                                    <small class="text-muted">
                                        <?= date('F j, Y, g:i a', strtotime($donation['donation_date'])) ?>
                                    </small>
                                </div>
                                <span class="badge bg-success">$<?= number_format($donation['amount'], 2) ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Subscribers</h5>
                        <a href="subscribers.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $recentSubscribers = $pdo->query("
                                        SELECT email, 'Newsletter' as type, created_at 
                                        FROM newsletter_subscribers
                                        UNION ALL
                                        SELECT email, 'General' as type, created_at 
                                        FROM subscribers
                                        ORDER BY created_at DESC
                                        LIMIT 5
                                    ")->fetchAll();
                                    
                                    foreach ($recentSubscribers as $subscriber):
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($subscriber['email']) ?></td>
                                        <td><?= htmlspecialchars($subscriber['type']) ?></td>
                                        <td><?= date('M j, H:i', strtotime($subscriber['created_at'])) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Dynamic chart for program participation
        document.addEventListener('DOMContentLoaded', function() {
            // Program Participation Chart
            const programCtx = document.createElement('canvas');
            programCtx.id = 'programChart';
            document.querySelector('.card-body').prepend(programCtx);
            
            fetch('api/program_stats.php')
                .then(response => response.json())
                .then(data => {
                    new Chart(programCtx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Participants',
                                data: data.values,
                                backgroundColor: data.colors,
                                borderColor: data.borderColors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.parsed.y.toLocaleString();
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return value.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error loading program chart data:', error));

            // Mentorship Stats Chart
            const mentorshipCtx = document.createElement('canvas');
            mentorshipCtx.id = 'mentorshipChart';
            document.querySelector('.card-body').appendChild(mentorshipCtx);
            
            fetch('api/mentorship_stats.php')
                .then(response => response.json())
                .then(data => {
                    new Chart(mentorshipCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Active Mentors', 'Available Mentors', 'Mentees'],
                            datasets: [{
                                data: [data.active_mentors, data.available_mentors, data.mentees],
                                backgroundColor: [
                                    'rgba(40, 167, 69, 0.7)',
                                    'rgba(255, 193, 7, 0.7)',
                                    'rgba(16, 62, 108, 0.7)'
                                ],
                                borderColor: [
                                    'rgba(40, 167, 69, 1)',
                                    'rgba(255, 193, 7, 1)',
                                    'rgba(16, 62, 108, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error loading mentorship chart data:', error));
        });
    </script>
</body>
</html>