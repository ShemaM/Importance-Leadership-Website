<?php 
// Start secure session
session_start();
requireAuth(); // Ensure user is authenticated
require_once 'db_connect.php'; // Database connection
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
        
        die("Auth check failed: ".print_r($_SESSION, true));
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
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            last_login TIMESTAMP NULL,
            is_superadmin TINYINT(1) DEFAULT 0,
            status ENUM('active','suspended') DEFAULT 'active'
        )");
        
        // Create admin logs table
        $pdo->exec("CREATE TABLE admin_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            admin_id INT NOT NULL,
            activity_type VARCHAR(50) NOT NULL,
            description TEXT,
            ip_address VARCHAR(45),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (admin_id) REFERENCES admin_users(id)
        )");
    }

    // Create default admin if table is empty
    $adminCount = $pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
    if ($adminCount == 0) {
        $username = 'admin';
        $password = 'admin123'; // Change in production!
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash, is_superadmin) VALUES (?, ?, 1)");
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
    // Log admin activity
    if (isset($_SESSION['admin_id'])) {
        $stmt = $pdo->prepare("INSERT INTO admin_logs (admin_id, activity_type, description, ip_address) VALUES (?, 'logout', 'Admin logged out', ?)");
        $stmt->execute([$_SESSION['admin_id'], $_SERVER['REMOTE_ADDR']]);
    }
    
    session_unset();
    session_destroy();
    header("Location: admin-login.php?error=session_expired");
    exit();
}

// Require authentication before loading dashboard
requireAuth();

// Validate required tables and columns with proper relationships
$requiredTables = [
    'admin_users' => [
        'columns' => ['id', 'username', 'password_hash', 'created_at', 'last_login', 'is_superadmin', 'status'],
        'relations' => []
    ],
    'community_impact_participants' => [
        'columns' => ['id', 'firstname', 'lastname', 'email', 'phone', 'created_at'],
        'relations' => []
    ],
    'leadership_participants' => [
        'columns' => ['id', 'firstname', 'lastname', 'email', 'phone', 'created_at'],
        'relations' => []
    ],
    'mentorship_participants' => [
        'columns' => ['id', 'firstname', 'lastname', 'email', 'phone', 'created_at'],
        'relations' => []
    ],
    'donations' => [
        'columns' => ['id', 'amount', 'donation_date', 'user_id', 'payment_method', 'status'],
        'relations' => [
            'user_id' => ['table' => 'users', 'column' => 'id']
        ]
    ],
    'contactmessages' => [
        'columns' => ['id', 'name', 'email', 'subject', 'message', 'status', 'created_at'],
        'relations' => []
    ],
    'mentors' => [
        'columns' => ['id', 'firstname', 'lastname', 'email', 'password', 'profession', 'expertise', 'status', 'created_at'],
        'relations' => []
    ],
    'newsletter_subscribers' => [
        'columns' => ['id', 'email', 'created_at', 'unsubscribed_at'],
        'relations' => []
    ],
    'mentees' => [
        'columns' => ['id', 'firstname', 'lastname', 'email', 'password', 'interests', 'goals', 'status', 'created_at'],
        'relations' => []
    ],
    'programs' => [
        'columns' => ['id', 'name', 'description', 'start_date', 'end_date', 'status', 'max_participants', 'created_by'],
        'relations' => [
            'created_by' => ['table' => 'admin_users', 'column' => 'id']
        ]
    ],
    'subscribers' => [
        'columns' => ['id', 'email', 'created_at', 'unsubscribed_at'],
        'relations' => []
    ],
    'admin_logs' => [
        'columns' => ['id', 'admin_id', 'activity_type', 'description', 'ip_address', 'created_at'],
        'relations' => [
            'admin_id' => ['table' => 'admin_users', 'column' => 'id']
        ]
    ],
    'events' => [
        'columns' => ['id', 'title', 'description', 'event_date', 'is_virtual', 'location', 'virtual_meeting_url', 'created_at', 'updated_at', 'cancelled_at', 'created_by', 'cancelled_by', 'updated_by', 'status', 'cancellation_reason', 'start_datetime', 'end_datetime', 'max_attendees', 'registration_required', 'registration_deadline', 'thumbnail_url', 'banner_url', 'event_subtitle'],
        'relations' => [
            'created_by' => ['table' => 'admin_users', 'column' => 'id'],
            'cancelled_by' => ['table' => 'admin_users', 'column' => 'id'],
            'updated_by' => ['table' => 'admin_users', 'column' => 'id']
        ]
    ],
    'event_audit_log' => [
        'columns' => ['id', 'event_id', 'action', 'performed_by', 'details', 'created_at'],
        'relations' => [
            'event_id' => ['table' => 'events', 'column' => 'id'],
            'performed_by' => ['table' => 'admin_users', 'column' => 'id']
        ]
    ],
    'event_media' => [
        'columns' => ['id', 'event_id', 'media_type', 'file_url', 'file_name', 'file_size', 'file_mime_type', 'thumbnail_url', 'caption', 'display_order', 'uploaded_by', 'uploaded_at', 'is_featured'],
        'relations' => [
            'event_id' => ['table' => 'events', 'column' => 'id'],
            'uploaded_by' => ['table' => 'admin_users', 'column' => 'id']
        ]
    ],
    'feedback' => [
        'columns' => ['id', 'name', 'email', 'program', 'feedback', 'rating', 'submitted_at'],
        'relations' => []
    ],
   
    'notifications' => [
        'columns' => ['id', 'user_id', 'title', 'message', 'is_read', 'created_at', 'updated_at'],
        'relations' => [
            'user_id' => ['table' => 'users', 'column' => 'id']
        ]
    ],
    'participants' => [
        'columns' => ['id', 'name', 'phone', 'email', 'gender', 'dob', 'country', 'city', 'education', 'organization', 'job_title', 'program', 'goals', 'motivation', 'created_at'],
        'relations' => []
    ],
    'users' => [
        'columns' => ['id', 'firstname', 'lastname', 'email', 'password', 'status', 'created_at', 'last_login'],
        'relations' => []
    ],
    'user_sessions' => [
        'columns' => ['id', 'user_id', 'session_token', 'ip_address', 'user_agent', 'expires_at'],
        'relations' => [
            'user_id' => ['table' => 'users', 'column' => 'id']
        ]
    ],

];

// Validate database structure
foreach ($requiredTables as $table => $config) {
    try {
        // Check if table exists
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() == 0) {
            die("Error: Required table '$table' not found in database.");
        }
        
        // Check columns
        $stmt = $pdo->query("DESCRIBE $table");
        $existingCols = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $missing = array_diff($config['columns'], $existingCols);
        
        if (!empty($missing)) {
            die("Error: Missing columns in `$table`: " . implode(', ', $missing));
        }
        
        // Check foreign key relationships
        foreach ($config['relations'] as $column => $relation) {
            $stmt = $pdo->query("
                SELECT COUNT(*) FROM $table t
                LEFT JOIN {$relation['table']} r ON t.$column = r.{$relation['column']}
                WHERE t.$column IS NOT NULL AND r.{$relation['column']} IS NULL
            ");
            $orphaned = $stmt->fetchColumn();
            
            if ($orphaned > 0) {
                die("Error: Found $orphaned orphaned records in `$table.$column` referencing non-existent records in {$relation['table']}.{$relation['column']}");
            }
        }
        
    } catch (PDOException $e) {
        die("Database validation error for table '$table': " . $e->getMessage());
    }
}

// Dashboard data loading
try {
    // Track admin activity
    if (isset($_SESSION['admin_id'])) {
        $stmt = $pdo->prepare("INSERT INTO admin_logs (admin_id, activity_type, description, ip_address) VALUES (?, 'page_view', 'Viewed dashboard', ?)");
        $stmt->execute([$_SESSION['admin_id'], $_SERVER['REMOTE_ADDR']]);
    }
    
    // Fetch unread notifications count
    $unreadNotificationsCount = $pdo->query("SELECT COUNT(*) FROM notifications WHERE is_read = 0")->fetchColumn();
    
    // Get total participants across all programs
    $totalParticipants = $pdo->query("
        SELECT COUNT(*) as total FROM (
            SELECT id FROM leadership_participants
            UNION ALL
            SELECT id FROM mentorship_participants
            UNION ALL
            SELECT id FROM community_impact_participants
            UNION ALL
            SELECT id FROM mentees
            UNION ALL
            SELECT id FROM participants
        ) as all_participants
    ")->fetch()['total'];

    // Recent donations with user info
    $recentDonations = $pdo->query("
        SELECT d.id, d.amount, d.donation_date, d.status, 
               u.firstname, u.lastname, u.email
        FROM donations d
        LEFT JOIN users u ON d.user_id = u.id
        ORDER BY d.donation_date DESC
        LIMIT 5
    ")->fetchAll();

    // Program statistics with proper participant counts
   
$programStats = $pdo->query("
SELECT 
    p.id,
    p.name as program,
    COUNT(pa.id) as participants,
    DATEDIFF(p.end_date, p.start_date) as duration_days,
    p.status
FROM programs p
LEFT JOIN participants pa ON pa.program = p.id
GROUP BY p.id, p.name, p.start_date, p.end_date, p.status
")->fetchAll(PDO::FETCH_ASSOC);

// Get gender distribution for each program
$genderStats = $pdo->query("
SELECT 
    /* Community Impact gender */
    (SELECT COUNT(*) FROM community_impact_participants WHERE gender = 'Male') as community_male,
    (SELECT COUNT(*) FROM community_impact_participants WHERE gender = 'Female') as community_female,
    (SELECT COUNT(*) FROM community_impact_participants WHERE gender = 'Other') as community_other,
    
    /* Leadership gender */
    (SELECT COUNT(*) FROM leadership_participants WHERE gender = 'Male') as leadership_male,
    (SELECT COUNT(*) FROM leadership_participants WHERE gender = 'Female') as leadership_female,
    (SELECT COUNT(*) FROM leadership_participants WHERE gender = 'Other') as leadership_other,
    
    /* Mentorship gender */
    (SELECT COUNT(*) FROM mentorship_participants WHERE gender = 'Male') as mentorship_male,
    (SELECT COUNT(*) FROM mentorship_participants WHERE gender = 'Female') as mentorship_female,
    (SELECT COUNT(*) FROM mentorship_participants WHERE gender = 'Other') as mentorship_other
")->fetch(PDO::FETCH_ASSOC);
    

    // Financial stats
    $financialStats = $pdo->query("
        SELECT 
            SUM(amount) as total_donations,
            COUNT(*) as donation_count,
            (SELECT SUM(amount) FROM donations WHERE donation_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) as monthly_donations,
            (SELECT COUNT(*) FROM donations WHERE donation_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) as monthly_donation_count
        FROM donations
    ")->fetch();

    // Mentorship statistics
    $mentorshipStats = $pdo->query("
        SELECT 
            COUNT(*) as total_mentors,
            (SELECT COUNT(*) FROM mentees) as total_mentees,
            (SELECT COUNT(*) FROM mentors WHERE status = 'active') as active_mentors,
            (SELECT COUNT(*) FROM mentors WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) as new_mentors,
            (SELECT COUNT(*) FROM mentees WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) as new_mentees
        FROM mentors
    ")->fetch();

    // Subscriber statistics
    $subscriberStats = $pdo->query("
        SELECT 
            (SELECT COUNT(*) FROM newsletter_subscribers WHERE unsubscribed_at IS NULL) as newsletter_subscribers,
            (SELECT COUNT(*) FROM subscribers WHERE unsubscribed_at IS NULL) as general_subscribers,
            (SELECT COUNT(*) FROM newsletter_subscribers WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) as new_newsletter_subscribers,
            (SELECT COUNT(*) FROM subscribers WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)) as new_subscribers
        FROM dual
    ")->fetch();

    // Recent events
    $recentEvents = $pdo->query("
        SELECT e.id, e.title, e.event_date, e.status, 
               a.username as created_by
        FROM events e
        LEFT JOIN admin_users a ON e.created_by = a.id
        ORDER BY e.event_date DESC
        LIMIT 5
    ")->fetchAll();

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
    <link rel="stylesheet" href="../styles/admin.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <style>
    /* Base Variables */
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --dark-color: #1d1f21;
        --light-color: #f4f5f7;
        --text-color: #333333;
        --text-muted: #6c757d;
        --sidebar-width: 240px;
        --header-height: 60px;
        --transition: all 0.3s ease;
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.15);
        --sidebar-bg: var(--dark-color);
        --sidebar-text: rgba(255, 255, 255, 0.8);
        --sidebar-active: rgba(255, 255, 255, 0.2);
    }

    /* Base Styles */
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background-color: var(--light-color);
        color: var(--text-color);
        overflow-x: hidden;
    }

    /* Stat Cards */
    .stat-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        height: 100%;
        margin-bottom: 20px;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .stat-card .value {
        font-size: 2rem;
        font-weight: 700;
        margin: 10px 0;
        color: var(--text-color);
    }

    .stat-card .label {
        color: var(--text-muted);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .trend {
        font-size: 0.85rem;
        display: flex;
        align-items: center;
    }

    .trend i {
        margin-right: 5px;
    }

    .trend.up {
        color: var(--success-color);
    }

    .trend.down {
        color: var(--danger-color);
    }

    /* Badges */
    .badge {
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    .badge-active {
        background-color: var(--success-color);
        color: white;
    }

    .badge-pending {
        background-color: var(--warning-color);
        color: var(--text-color);
    }

    .badge-inactive {
        background-color: var(--text-muted);
        color: white;
    }

    /* Sidebar */
    .sidebar {
        background-color:rgb(5, 37, 69);
        color: #fff;
        height: 100vh;
        padding: 15px;
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        transform: translateX(0);
        transition: transform 0.3s ease-in-out;
        z-index: 1000;
    }

    .sidebar.hidden {
        transform: translateX(-100%);
    }

    .sidebar-brand img {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    .nav-link {
        color:#ffff;
        font-size: 17px;
        font-weight:bold;
        border-radius: 5px;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
    }

    .nav-link i {
        margin-right: 10px;
    }

    .nav-link:hover {
        background-color: #495057;
        color: #fff;
    }

    .nav-link.active {
        background-color: #007bff;
        color: #fff;
    }

    .nav-item {
        margin-bottom: 10px;
    }

    .sidebar ul {
        padding-left: 0;
        list-style: none;
    }

    .toggle-btn {
        position: fixed;
        top: 15px;
        left: 15px;
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        z-index: 1100;
        border-radius: 5px;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .toggle-btn {
            top: 10px;
            left: 10px;
        }
    }


    .nav-link:hover,
    .nav-link.active {
        color: white;
        background: var(--sidebar-active);
        text-decoration: none;
    }

    .nav-link i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    /* Main Content */
    .main-content {
        margin-left: var(--sidebar-width);
        min-height: 100vh;
        padding: 20px;
        transition: var(--transition);
    }

    /* Header */
    .header {
        position: sticky;
        top: 0;
        background: white;
        padding: 15px 20px;
        box-shadow: var(--shadow-sm);
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1040;
        margin: -20px -20px 20px -20px;
    }

    .admin-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-color);
    }

    .menu-toggle {
        display: none;
        cursor: pointer;
        font-size: 1.5rem;
        color: var(--text-color);
    }

    /* Mobile Styles */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
            padding-top: calc(var(--header-height) + 20px);
        }

        .header {
            position: fixed;
            width: 100%;
        }

        .menu-toggle {
            display: inline-block;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade {
        animation: fadeIn 0.4s ease forwards;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.querySelector('.toggle-btn');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('hidden');
        });
    });
</script>

<button class="toggle-btn">☰</button>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="../image/website-logo.png" alt="<?= htmlspecialchars(SITE_NAME) ?> Logo">
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
                <a class="nav-link" href="admin-logs.php">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Activity Logs</span>
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
                        <i class="fas fa-bell fa-lg"></i>
                        <?php if ($unreadNotificationsCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= htmlspecialchars($unreadNotificationsCount) ?>
                        </span>
                        <?php endif; ?>
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
        <div class="container-fluid mt-4">
            <div class="row mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="label">Total Participants</div>
                        <div class="value"><?= number_format($totalParticipants) ?></div>
                        <div class="trend up">
                            <i class="fas fa-arrow-up"></i> 
                            <?php
                            $newParticipants = $pdo->query("
                                SELECT COUNT(*) FROM (
                                    SELECT id FROM leadership_participants WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
                                    UNION ALL
                                    SELECT id FROM mentorship_participants WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
                                    UNION ALL
                                    SELECT id FROM community_impact_participants WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
                                    UNION ALL
                                    SELECT id FROM mentees WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
                                    UNION ALL
                                    SELECT id FROM participants WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
                                ) as new_participants
                            ")->fetchColumn();
                            echo number_format($newParticipants) . ' new this month';
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
                            <?= $mentorshipStats['new_mentors'] ?> new mentors, <?= $mentorshipStats['new_mentees'] ?> new mentees
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
                        <div class="label">Total Donations</div>
                        <div class="value">$<?= number_format($financialStats['total_donations'], 2) ?></div>
                        <div class="trend up">
                            <i class="fas fa-arrow-up"></i> 
                            $<?= number_format($financialStats['monthly_donations'], 2) ?> this month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Programs and Events Row -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Programs Overview</h5>
                            <a href="programs.php" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="programsTable">
                                    <thead>
                                        <tr>
                                            <th>Program</th>
                                            <th>Participants</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
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
                                        <?php endforeach; ?></td>
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
                </div>
                
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Upcoming Events</h5>
                            <a href="events.php" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <?php foreach ($recentEvents as $event): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1"><?= htmlspecialchars($event['title']) ?></h6>
                                            <small class="text-muted">
                                                <?= date('M j, Y', strtotime($event['event_date'])) ?>
                                            </small>
                                        </div>
                                        <span class="badge <?= $event['status'] == 'active' ? 'badge-active' : ($event['status'] == 'pending' ? 'badge-pending' : 'badge-inactive') ?>">
                                            <?= ucfirst($event['status']) ?>
                                        </span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mentorship and Financial Stats -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Mentorship Statistics</h5>
                            <a href="mentors.php" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">Total Mentors</div>
                                        <div class="value"><?= number_format($mentorshipStats['total_mentors']) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">Active Mentors</div>
                                        <div class="value"><?= number_format($mentorshipStats['active_mentors']) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">Total Mentees</div>
                                        <div class="value"><?= number_format($mentorshipStats['total_mentees']) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">New This Month</div>
                                        <div class="value"><?= number_format($mentorshipStats['new_mentors'] + $mentorshipStats['new_mentees']) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Financial Overview</h5>
                            <a href="donations.php" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">Total Donations</div>
                                        <div class="value">$<?= number_format($financialStats['total_donations'], 2) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">Monthly Donations</div>
                                        <div class="value">$<?= number_format($financialStats['monthly_donations'], 2) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">Total Transactions</div>
                                        <div class="value"><?= number_format($financialStats['donation_count']) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">Monthly Transactions</div>
                                        <div class="value"><?= number_format($financialStats['monthly_donation_count']) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Recent Activity -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Donations</h5>
                            <a href="donations.php" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Donor</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentDonations as $donation): ?>
                                        <tr>
                                            <td>
                                                <?= htmlspecialchars($donation['firstname'] . ' ' . $donation['lastname']) ?>
                                                <br><small><?= htmlspecialchars($donation['email']) ?></small>
                                            </td>
                                            <td>$<?= number_format($donation['amount'], 2) ?></td>
                                            <td><?= date('M j, H:i', strtotime($donation['donation_date'])) ?></td>
                                            <td>
                                                <span class="badge <?= $donation['status'] == 'completed' ? 'badge-active' : 'badge-pending' ?>">
                                                    <?= ucfirst($donation['status']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
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
                                            WHERE unsubscribed_at IS NULL
                                            UNION ALL
                                            SELECT email, 'General' as type, created_at 
                                            FROM subscribers
                                            WHERE unsubscribed_at IS NULL
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
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Initialize DataTables
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable for programs
            $('#programsTable').DataTable({
                responsive: true,
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                order: [[3, 'desc']]
            });
            
            // Program Participation Chart
            const programCtx = document.createElement('canvas');
            programCtx.id = 'programChart';
            document.querySelector('#programsTable_wrapper').before(programCtx);
            
            const programData = {
                labels: <?= json_encode(array_column($programStats, 'program')) ?>,
                datasets: [{
                    label: 'Participants',
                    data: <?= json_encode(array_column($programStats, 'participants')) ?>,
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(0, 123, 255, 0.7)',
                        'rgba(220, 53, 69, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(23, 162, 184, 0.7)'
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(0, 123, 255, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(23, 162, 184, 1)'
                    ],
                    borderWidth: 1
                }]
            };
            
            new Chart(programCtx, {
                type: 'bar',
                data: programData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
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

            // Mentorship Stats Chart
            const mentorshipCtx = document.createElement('canvas');
            mentorshipCtx.id = 'mentorshipChart';
            document.querySelector('.card-body').appendChild(mentorshipCtx);
            
            new Chart(mentorshipCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Active Mentors', 'Available Mentors', 'Mentees'],
                    datasets: [{
                        data: [
                            <?= $mentorshipStats['active_mentors'] ?>,
                            <?= $mentorshipStats['total_mentors'] - $mentorshipStats['active_mentors'] ?>,
                            <?= $mentorshipStats['total_mentees'] ?>
                        ],
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
                        legend: { position: 'bottom' }
                    }
                }
            });
        });
    </script>
</body>
</html>