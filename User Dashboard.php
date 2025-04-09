<?php 
// Start secure session
session_start();

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'importanceleadership',
    'username' => 'root',
        'password' => 'secret'
    ];
    
    // Error reporting (disable in production)
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Constants
    define('BASE_URL', 'https://importanceleadership.com/user');
    define('SITE_NAME', 'Importance Leadership');
    define('ITEMS_PER_PAGE', 10);
    
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
    
    // Check if user is logged in (simplified version)
    if (!isset($_SESSION['user_id'])) {
        // Redirect to signup page if not logged in
        header("Location: User Dashboard.php");
        exit();
    }
    
    // Get user data
    $userId = $_SESSION['user_id'];
    $userData = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $userData->execute([$userId]);
    $user = $userData->fetch();
    
    // If user doesn't exist, redirect to signup
    if (!$user) {
        header("Location: signup.php");
        exit();
    }


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

// Check if user is logged in (simplified version)
if (!isset($_SESSION['user_id'])) {
    // Redirect to signup page if not logged in
    header("Location: User Dashboard.php");
    exit();
}

// Get user data
$userId = $_SESSION['user_id'];
$userData = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$userData->execute([$userId]);
$user = $userData->fetch();

// If user doesn't exist, redirect to signup
if (!$user) {
    header("Location: signup.php");
    exit();
}

// Dashboard data loading
try {
    // Get user's program participation
    $userPrograms = $pdo->prepare("
        SELECT p.id, p.name, p.description, p.start_date, p.end_date, p.status
        FROM programs p
        JOIN program_participants pp ON p.id = pp.program_id
        WHERE pp.user_id = ?
        ORDER BY p.start_date DESC
        LIMIT 5
    ");
    $userPrograms->execute([$userId]);
    
    // Get user's mentorship status
    $mentorshipStatus = $pdo->prepare("
        SELECT m.firstname, m.lastname, m.profession, m.expertise, 
               mm.start_date, mm.status as mentorship_status
        FROM mentor_mentee mm
        JOIN mentors m ON mm.mentor_id = m.id
        WHERE mm.mentee_id = ?
        ORDER BY mm.start_date DESC
        LIMIT 1
    ");
    $mentorshipStatus->execute([$userId]);
    $mentorship = $mentorshipStatus->fetch();
    
    // Get upcoming events
    $upcomingEvents = $pdo->prepare("
        SELECT e.id, e.title, e.description, e.event_date, e.location
        FROM events e
        JOIN event_participants ep ON e.id = ep.event_id
        WHERE ep.user_id = ? AND e.event_date >= NOW()
        ORDER BY e.event_date ASC
        LIMIT 3
    ");
    $upcomingEvents->execute([$userId]);
    
    // Get user's donations
    $userDonations = $pdo->prepare("
        SELECT amount, donation_date, payment_method
        FROM donations
        WHERE user_id = ?
        ORDER BY donation_date DESC
        LIMIT 5
    ");
    $userDonations->execute([$userId]);
    
    // Check if user is subscribed to newsletter
    $newsletterSubscribed = $pdo->prepare("
        SELECT 1 FROM newsletter_subscribers WHERE email = ?
    ");
    $newsletterSubscribed->execute([$user['email']]);
    $isSubscribed = $newsletterSubscribed->fetchColumn() ? true : false;

} catch (PDOException $e) {
    die("Dashboard load error: " . $e->getMessage());
}

// Logout handler
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(SITE_NAME) ?> - User Dashboard</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --info-color: #2980b9;
            --border-radius: 0.375rem;
            --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem 0;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            padding: 0 1.5rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand img {
            max-width: 180px;
            height: auto;
        }

        .main-content {
            margin-left: 250px;
            padding: 1.5rem;
            min-height: 100vh;
        }

        /* Navigation */
        .nav {
            flex-direction: column;
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.25rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            border-left: 3px solid var(--secondary-color);
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #e0e0e0;
        }

        .header h4 {
            margin: 0;
            color: var(--dark-color);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--secondary-color);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
            background-color: white;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }

        /* Stats Cards */
        .stat-card {
            background-color: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            height: 100%;
        }

        .stat-card .label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .stat-card .value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stat-card .trend {
            font-size: 0.85rem;
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
        }

        .badge-active {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .badge-pending {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .badge-inactive {
            background-color: rgba(108, 117, 125, 0.2);
            color: #6c757d;
        }

        /* Quick Actions */
        .quick-actions {
            position: fixed;
            bottom: 0;
            left: 250px;
            right: 0;
            background-color: var(--primary-color);
            padding: 0.75rem 0;
            z-index: 100;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar-brand, .nav-link span {
                display: none;
            }
            
            .nav-link {
                justify-content: center;
                padding: 1rem;
            }
            
            .nav-link i {
                margin-right: 0;
                font-size: 1.25rem;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .quick-actions {
                left: 70px;
            }
        }

        @media (max-width: 768px) {
            .stat-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="assets/images/logo.png" alt="<?= htmlspecialchars(SITE_NAME) ?> Logo">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="dashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="programs.php">
                    <i class="fas fa-project-diagram"></i>
                    <span>My Programs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="mentorship.php">
                    <i class="fas fa-hands-helping"></i>
                    <span>Mentorship</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="events.php">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Events</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="donations.php">
                    <i class="fas fa-donate"></i>
                    <span>My Donations</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="resources.php">
                    <i class="fas fa-book"></i>
                    <span>Resources</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h4>Welcome, <?= htmlspecialchars($user['firstname']) ?></h4>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown">
                        <img src="assets/images/avatars/<?= $user['avatar'] ?? 'default.png' ?>" alt="User" class="user-avatar me-2"> 
                        <span><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></span>
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

        <!-- Welcome Section -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5>Welcome back, <?= htmlspecialchars($user['firstname']) ?>!</h5>
                        <p class="text-muted">
                            <?php if ($mentorship): ?>
                                You're currently participating in our mentorship program with <?= htmlspecialchars($mentorship['firstname'] . ' ' . $mentorship['lastname']) ?>.
                            <?php else: ?>
                                Thank you for being part of our community.
                            <?php endif; ?>
                        </p>
                        <div class="d-flex">
                            <a href="programs.php" class="btn btn-primary me-2">Explore Programs</a>
                            <?php if (!$mentorship): ?>
                                <a href="mentorship.php" class="btn btn-outline-primary">Find a Mentor</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="assets/images/illustrations/welcome.svg" alt="Welcome" class="img-fluid" style="max-height: 150px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Active Programs</div>
                    <div class="value">
                        <?php 
                            $stmt = $pdo->prepare("SELECT COUNT(*) FROM program_participants WHERE user_id = ? AND status = 'active'");
                            $stmt->execute([$userId]);
                            echo $stmt->fetchColumn();
                        ?>
                    </div>
                    <div class="trend">
                        <a href="programs.php" class="text-primary">View all</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Upcoming Events</div>
                    <div class="value">
                        <?php 
                            $stmt = $pdo->prepare("
                                SELECT COUNT(*) 
                                FROM event_participants ep
                                JOIN events e ON ep.event_id = e.id
                                WHERE ep.user_id = ? AND e.event_date >= NOW()
                            ");
                            $stmt->execute([$userId]);
                            echo $stmt->fetchColumn();
                        ?>
                    </div>
                    <div class="trend">
                        <a href="events.php" class="text-primary">View calendar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Total Donations</div>
                    <div class="value">
                        $<?php 
                            $stmt = $pdo->prepare("SELECT IFNULL(SUM(amount), 0) FROM donations WHERE user_id = ?");
                            $stmt->execute([$userId]);
                            echo number_format($stmt->fetchColumn(), 2);
                        ?>
                    </div>
                    <div class="trend">
                        <a href="donations.php" class="text-primary">View history</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="label">Community Impact</div>
                    <div class="value">
                        <?php 
                            $stmt = $pdo->prepare("SELECT COUNT(*) FROM community_impact WHERE user_id = ?");
                            $stmt->execute([$userId]);
                            echo $stmt->fetchColumn();
                        ?>
                    </div>
                    <div class="trend">
                        <a href="impact.php" class="text-primary">Your contributions</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Programs -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">My Current Programs</h5>
                <a href="programs.php" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if ($userPrograms->rowCount() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Program</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($userPrograms as $program): ?>
                                <tr>
                                    <td><?= htmlspecialchars($program['name']) ?></td>
                                    <td><?= date('M j, Y', strtotime($program['start_date'])) ?></td>
                                    <td><?= date('M j, Y', strtotime($program['end_date'])) ?></td>
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
                <?php else: ?>
                    <div class="alert alert-info">
                        You're not currently enrolled in any programs. <a href="programs.php" class="alert-link">Browse available programs</a> to get involved.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mentorship Status -->
        <?php if ($mentorship): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">My Mentorship</h5>
                <a href="mentorship.php" class="btn btn-sm btn-primary">View Details</a>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center">
                        <img src="assets/images/mentors/<?= $mentorship['id'] ?>.jpg" alt="Mentor" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        <h5><?= htmlspecialchars($mentorship['firstname'] . ' ' . $mentorship['lastname']) ?></h5>
                        <p class="text-muted"><?= htmlspecialchars($mentorship['profession']) ?></p>
                    </div>
                    <div class="col-md-5">
                        <h6>Expertise</h6>
                        <p><?= htmlspecialchars($mentorship['expertise']) ?></p>
                        
                        <h6 class="mt-3">Mentorship Status</h6>
                        <span class="badge <?= $mentorship['mentorship_status'] == 'active' ? 'badge-active' : 'badge-pending' ?>">
                            <?= ucfirst($mentorship['mentorship_status']) ?>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <h6>Started On</h6>
                        <p><?= date('F j, Y', strtotime($mentorship['start_date'])) ?></p>
                        
                        <h6 class="mt-3">Next Steps</h6>
                        <a href="mentorship.php" class="btn btn-sm btn-outline-primary">Schedule Meeting</a>
                        <a href="messages.php" class="btn btn-sm btn-outline-secondary ms-2">Send Message</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Upcoming Events -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Upcoming Events</h5>
                        <a href="events.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <?php if ($upcomingEvents->rowCount() > 0): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($upcomingEvents as $event): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="mb-1"><?= htmlspecialchars($event['title']) ?></h6>
                                            <small class="text-muted">
                                                <?= date('F j, Y, g:i a', strtotime($event['event_date'])) ?>
                                            </small>
                                            <p class="mb-1 small"><?= htmlspecialchars($event['location']) ?></p>
                                        </div>
                                        <div>
                                            <a href="event_details.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-outline-primary">Details</a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                No upcoming events. <a href="events.php" class="alert-link">Browse events</a> to participate.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Donations</h5>
                        <a href="donations.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <?php if ($userDonations->rowCount() > 0): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($userDonations as $donation): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Donation</h6>
                                        <small class="text-muted">
                                            <?= date('F j, Y', strtotime($donation['donation_date'])) ?>
                                        </small>
                                        <p class="mb-1 small"><?= htmlspecialchars($donation['payment_method']) ?></p>
                                    </div>
                                    <span class="badge bg-success">$<?= number_format($donation['amount'], 2) ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                No donation history. <a href="donate.php" class="alert-link">Make a donation</a> to support our cause.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Footer -->
    <div class="quick-actions">
        <div class="container">
            <div class="d-flex justify-content-between">
                <a href="programs.php" class="btn btn-outline-light">
                    <i class="fas fa-project-diagram me-2"></i> Join Program
                </a>
                <a href="events.php" class="btn btn-outline-light">
                    <i class="fas fa-calendar-alt me-2"></i> Register for Event
                </a>
                <a href="donate.php" class="btn btn-outline-light">
                    <i class="fas fa-donate me-2"></i> Make Donation
                </a>
                <a href="resources.php" class="btn btn-outline-light">
                    <i class="fas fa-book me-2"></i> Access Resources
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>