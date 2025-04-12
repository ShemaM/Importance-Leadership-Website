<?php
// Start secure session
session_start([
    'cookie_lifetime' => 86400, // 1 day
    'cookie_secure' => !empty($_SERVER['HTTPS']), // Auto HTTPS detection
    'cookie_httponly' => true,
    'use_strict_mode' => true
]);

// 1. Verify admin authentication
if (empty($_SESSION['admin_auth_token'])) {
    header("Location: admin-login.php?error=session_expired");
    exit();
}

// 2. Verify token age (30 minute limit)
if (time() - ($_SESSION['admin_auth_time'] ?? 0) > 1800) {
    header("Location: admin-login.php?error=session_timeout");
    exit();
}

// 3. Verify admin privileges
require_once 'db_connect.php';
try {
    $stmt = $pdo->prepare("
        SELECT admin_level 
        FROM admin_users 
        WHERE id = ? AND auth_token = ? AND last_active > DATE_SUB(NOW(), INTERVAL 30 MINUTE)
    ");
    $stmt->execute([$_SESSION['admin_id'], $_SESSION['admin_auth_token']]);
    $admin = $stmt->fetch();

    if (!$admin) {
        header("Location: admin-login.php?error=invalid_credentials");
        exit();
    }

    // Update last active time
    $pdo->prepare("UPDATE admin_users SET last_active = NOW() WHERE id = ?")
        ->execute([$_SESSION['admin_id']]);

} catch (PDOException $e) {
    error_log("Admin access error: " . $e->getMessage());
    header("Location: admin-login.php?error=db_error");
    exit();
}

// Database connection
try {
    $db = new mysqli('localhost', 'admin_db_user', 'StrongAdminPassword123!', 'importanceleadership');
    
    if ($db->connect_error) {
        throw new Exception("Database connection failed");
    }

    // Get admin data
    $admin_stmt = $db->prepare("
        SELECT first_name, last_name, email, admin_level, last_login 
        FROM admin_users 
        WHERE id = ?
    ");
    $admin_stmt->bind_param("i", $_SESSION['admin_id']);
    $admin_stmt->execute();
    $admin_data = $admin_stmt->get_result()->fetch_assoc();

    if (!$admin_data) {
        throw new Exception("Admin record not found");
    }

    // Get system statistics in a transaction
    $db->begin_transaction();
    
    try {
        // User statistics
        $user_stats = $db->query("
            SELECT 
                COUNT(*) as total_users,
                SUM(CASE WHEN created_at > DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as new_users,
                (SELECT COUNT(*) FROM user_programs WHERE enrollment_status = 'active') as active_programs
            FROM users
        ")->fetch_assoc();

        // Content statistics
        $content_stats = $db->query("
            SELECT 
                (SELECT COUNT(*) FROM videos) as total_videos,
                (SELECT COUNT(*) FROM articles) as total_articles,
                (SELECT COUNT(*) FROM events WHERE event_date >= CURDATE()) as upcoming_events
        ")->fetch_assoc();

        // Recent activity
        $recent_activity = $db->query("
            SELECT activity_type, description, created_at 
            FROM admin_logs 
            ORDER BY created_at DESC 
            LIMIT 10
        ")->fetch_all(MYSQLI_ASSOC);

        $db->commit();
    } catch (Exception $e) {
        $db->rollback();
        throw $e;
    }

} catch (Exception $e) {
    error_log("Admin dashboard error: " . $e->getMessage());
    header("Location: admin-error.php?code=dashboard_load");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leadership Portal Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/userDashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <img src="image/website-logo.png" alt="Leadership Portal">
            </div>
            <nav>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="videos.php">
                            <i class="fas fa-video"></i>
                            <span>Videos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="articles.php">
                            <i class="fas fa-newspaper"></i>
                            <span>Articles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="events.php">
                            <i class="fas fa-calendar-check"></i>
                            <span>Events</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mentorship.php">
                            <i class="fas fa-user-graduate"></i>
                            <span>Mentorship</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="community.php">
                            <i class="fas fa-users"></i>
                            <span>Community</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="dashboard-header">
                <h2>Welcome Back, <span id="user-name"><?php echo htmlspecialchars($user['first_name']); ?></span></h2>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?php echo htmlspecialchars($user['avatar'] ?? 'image/website-logo.png'); ?>" alt="User" class="user-avatar me-2">
                        <span><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1>Your Leadership Journey Starts Here</h1>
                        <p class="mb-0">Access exclusive resources, connect with mentors, and join our community of leaders</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="image/website-logo.png" alt="Welcome" class="img-fluid">
                    </div>
                </div>
            </div>

            <!-- Resource Grid -->
            <div class="resource-grid">
                <!-- Featured Videos -->
                <div class="resource-card">
                    <div class="card-header">
                        <i class="fas fa-video"></i>
                        <h3>Featured Videos</h3>
                    </div>
                    <div class="card-body">
                        <?php while ($video = $videos->fetch_assoc()): ?>
                        <div class="media-item">
                            <div class="media-thumbnail" style="background-image: url('<?php echo htmlspecialchars($video['thumbnail_url']); ?>')">
                                <i class="fas fa-play"></i>
                            </div>
                            <h4 class="media-title"><?php echo htmlspecialchars($video['title']); ?></h4>
                            <p class="media-meta"><?php echo htmlspecialchars($video['duration']); ?> • <?php echo htmlspecialchars($video['difficulty']); ?></p>
                        </div>
                        <?php endwhile; ?>
                        <a href="videos.php" class="view-all">View all videos →</a>
                    </div>
                </div>

                <!-- Latest Articles -->
                <div class="resource-card">
                    <div class="card-header">
                        <i class="fas fa-newspaper"></i>
                        <h3>Latest Articles</h3>
                    </div>
                    <div class="card-body">
                        <?php while ($article = $articles->fetch_assoc()): ?>
                        <div class="media-item">
                            <div class="media-thumbnail" style="background-image: url('<?php echo htmlspecialchars($article['image_url']); ?>')">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h4 class="media-title"><?php echo htmlspecialchars($article['title']); ?></h4>
                            <p class="media-meta"><?php echo htmlspecialchars($article['read_time']); ?> read<?php echo $article['has_pdf'] ? ' • PDF Available' : ''; ?></p>
                        </div>
                        <?php endwhile; ?>
                        <a href="articles.php" class="view-all">View all articles →</a>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="resource-card">
                    <div class="card-header">
                        <i class="fas fa-calendar-check"></i>
                        <h3>Upcoming Events</h3>
                    </div>
                    <div class="card-body">
                        <?php while ($event = $events->fetch_assoc()): 
                            $event_date = new DateTime($event['event_date']);
                        ?>
                        <div class="event-item">
                            <div class="event-date">
                                <span class="event-day"><?php echo $event_date->format('d'); ?></span>
                                <span class="event-month"><?php echo $event_date->format('M'); ?></span>
                            </div>
                            <div class="event-details">
                                <h4><?php echo htmlspecialchars($event['title']); ?></h4>
                                <p class="event-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($event['location']); ?></p>
                                <div class="event-tags">
                                    <?php 
                                    $tags = explode(',', $event['tags']);
                                    foreach ($tags as $tag): 
                                    ?>
                                    <span class="tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                        <a href="events.php" class="view-all">View all events →</a>
                    </div>
                </div>

                <!-- Mentorship Program -->
                <div class="resource-card">
                    <div class="card-header">
                        <i class="fas fa-user-graduate"></i>
                        <h3>Mentorship Program</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($mentor): ?>
                        <div class="mentor-profile">
                            <img src="<?php echo htmlspecialchars($mentor['photo_url']); ?>" alt="Mentor" class="mentor-photo">
                            <div>
                                <h4 class="mentor-name"><?php echo htmlspecialchars($mentor['name']); ?></h4>
                                <p class="mentor-title"><?php echo htmlspecialchars($mentor['title']); ?></p>
                                <div class="mentor-specialties">
                                    <?php 
                                    $specialties = explode(',', $mentor['specialties']);
                                    foreach ($specialties as $specialty): 
                                    ?>
                                    <span class="specialty"><?php echo htmlspecialchars(trim($specialty)); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="mentorship.php?action=schedule" class="btn-action btn-primary">
                                <i class="fas fa-video"></i> Schedule Session
                            </a>
                            <a href="mentorship.php?action=resources" class="btn-action btn-secondary">
                                <i class="fas fa-book"></i> Resources
                            </a>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-3">
                            <p>You don't have a mentor assigned yet.</p>
                            <a href="mentorship.php" class="btn-action btn-primary">
                                <i class="fas fa-search"></i> Find a Mentor
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Conference Archives -->
            <div class="resource-card mb-4">
                <div class="card-header">
                    <i class="fas fa-video"></i>
                    <h3>Conference Archives</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php while ($conference = $conferences->fetch_assoc()): ?>
                        <div class="col-md-6">
                            <div class="media-item">
                                <div class="media-thumbnail" style="background-image: url('<?php echo htmlspecialchars($conference['image_url']); ?>')">
                                    <i class="fas fa-play-circle"></i>
                                </div>
                                <h4 class="media-title"><?php echo htmlspecialchars($conference['title']); ?></h4>
                                <p class="media-meta"><?php echo htmlspecialchars($conference['video_count']); ?> Videos • <?php echo htmlspecialchars($conference['resource_count']); ?> Resources</p>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <a href="conferences.php" class="view-all">Browse all conferences →</a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="resource-card">
                <div class="card-header">
                    <i class="fas fa-link"></i>
                    <h3>Quick Links</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="podcasts.php" class="btn-action btn-secondary w-100">
                                <i class="fas fa-podcast"></i> Leadership Podcasts
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="assessment.php" class="btn-action btn-secondary w-100">
                                <i class="fas fa-chart-line"></i> Self-Assessment
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="forum.php" class="btn-action btn-secondary w-100">
                                <i class="fas fa-users"></i> Community Forum
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple greeting based on time of day
        document.addEventListener('DOMContentLoaded', function() {
            const hour = new Date().getHours();
            const greeting = hour < 12 ? 'Good Morning' : hour < 18 ? 'Good Afternoon' : 'Good Evening';
            document.getElementById('user-name').textContent = greeting + ', <?php echo addslashes($user["first_name"]); ?>';
        });
    </script>
</body>
</html>
<?php
// Close database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/userDashboard.css">

</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <img src="image/website-logo.png" alt="Leadership Portal">
            </div>
            <nav>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="videos.php">
                            <i class="fas fa-video"></i>
                            <span>Videos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-newspaper"></i>
                            <span>Articles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar-check"></i>
                            <span>Events</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user-graduate"></i>
                            <span>Mentorship</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-users"></i>
                            <span>Community</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="dashboard-header">
                <h2>Welcome Back, <span id="user-name">Alex</span></h2>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="image/website-logo.png" alt="User" class="user-avatar me-2">
                        <span>Alex Johnson</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1>Your Leadership Journey Starts Here</h1>
                        <p class="mb-0">Access exclusive resources, connect with mentors, and join our community of leaders</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="image/website-logo.png" alt="Welcome" class="img-fluid">
                    </div>
                </div>
            </div>

            <!-- Resource Grid -->
            <div class="resource-grid">
                <!-- Featured Videos -->
                <div class="resource-card">
                    <div class="card-header">
                        <i class="fas fa-video"></i>
                        <h3>Featured Videos</h3>
                    </div>
                    <div class="card-body">
                        <div class="media-item">
                            <div class="media-thumbnail" style="background-image: url('image/community\ engagement.jpg')">
                                <i class="fas fa-play"></i>
                            </div>
                            <h4 class="media-title">5 Pillars of Effective Leadership</h4>
                            <p class="media-meta">32 min • Beginner</p>
                        </div>
                        <div class="media-item">
                            <div class="media-thumbnail" style="background-image: url('image/leadershipDevelopemnt.jpg')">
                                <i class="fas fa-play"></i>
                            </div>
                            <h4 class="media-title">Decision Making Under Pressure</h4>
                            <p class="media-meta">24 min • Intermediate</p>
                        </div>
                        <a href="#" class="view-all">View all videos →</a>
                    </div>
                </div>

                <!-- Latest Articles -->
                <div class="resource-card">
                    <div class="card-header">
                        <i class="fas fa-newspaper"></i>
                        <h3>Latest Articles</h3>
                    </div>
                    <div class="card-body">
                        <div class="media-item">
                            <div class="media-thumbnail" style="background-image: url('image/diversity.jpg')">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h4 class="media-title">Emotional Intelligence in Leadership</h4>
                            <p class="media-meta">12 min read • PDF Available</p>
                        </div>
                        <div class="media-item">
                            <div class="media-thumbnail" style="background-image: url('image/leadershipCoaching.jpg')">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h4 class="media-title">Building High-Performance Teams</h4>
                            <p class="media-meta">18 min read</p>
                        </div>
                        <a href="#" class="view-all">View all articles →</a>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="resource-card">
                    <div class="card-header">
                        <i class="fas fa-calendar-check"></i>
                        <h3>Upcoming Events</h3>
                    </div>
                    <div class="card-body">
                        <div class="event-item">
                            <div class="event-date">
                                <span class="event-day">15</span>
                                <span class="event-month">OCT</span>
                            </div>
                            <div class="event-details">
                                <h4>Global Leadership Summit 2023</h4>
                                <p class="event-location"><i class="fas fa-map-marker-alt"></i> Virtual & London</p>
                                <div class="event-tags">
                                    <span class="tag">Keynote</span>
                                    <span class="tag">Networking</span>
                                </div>
                            </div>
                        </div>
                        <div class="event-item">
                            <div class="event-date">
                                <span class="event-day">28</span>
                                <span class="event-month">NOV</span>
                            </div>
                            <div class="event-details">
                                <h4>Women in Leadership Workshop</h4>
                                <p class="event-location"><i class="fas fa-map-marker-alt"></i> New York</p>
                                <div class="event-tags">
                                    <span class="tag">Workshop</span>
                                    <span class="tag">Limited Seats</span>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="view-all">View all events →</a>
                    </div>
                </div>

                <!-- Mentorship Program -->
                <div class="resource-card">
                    <div class="card-header">
                        <i class="fas fa-user-graduate"></i>
                        <h3>Mentorship Program</h3>
                    </div>
                    <div class="card-body">
                        <div class="mentor-profile">
                            <img src="https://via.placeholder.com/80" alt="Mentor" class="mentor-photo">
                            <div>
                                <h4 class="mentor-name">Dr. Sarah Johnson</h4>
                                <p class="mentor-title">Executive Coach | 15+ years experience</p>
                                <div class="mentor-specialties">
                                    <span class="specialty">Strategic Thinking</span>
                                    <span class="specialty">Emotional Intelligence</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn-action btn-primary">
                                <i class="fas fa-video"></i> Schedule Session
                            </button>
                            <button class="btn-action btn-secondary">
                                <i class="fas fa-book"></i> Resources
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conference Archives -->
            <div class="resource-card mb-4">
                <div class="card-header">
                    <i class="fas fa-video"></i>
                    <h3>Conference Archives</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="media-item">
                                <div class="media-thumbnail" style="background-image: url('https://via.placeholder.com/400x225?text=Conference+1')">
                                    <i class="fas fa-play-circle"></i>
                                </div>
                                <h4 class="media-title">2023 Annual Leadership Forum</h4>
                                <p class="media-meta">8 Videos • 12 Presentations</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media-item">
                                <div class="media-thumbnail" style="background-image: url('https://via.placeholder.com/400x225?text=Conference+2')">
                                    <i class="fas fa-play-circle"></i>
                                </div>
                                <h4 class="media-title">Innovation Leadership Series</h4>
                                <p class="media-meta">5 Videos • 7 Worksheets</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="view-all">Browse all conferences →</a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="resource-card">
                <div class="card-header">
                    <i class="fas fa-link"></i>
                    <h3>Quick Links</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="#" class="btn-action btn-secondary w-100">
                                <i class="fas fa-podcast"></i> Leadership Podcasts
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="#" class="btn-action btn-secondary w-100">
                                <i class="fas fa-chart-line"></i> Self-Assessment
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="#" class="btn-action btn-secondary w-100">
                                <i class="fas fa-users"></i> Community Forum
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple greeting based on time of day
        document.addEventListener('DOMContentLoaded', function() {
            const hour = new Date().getHours();
            const greeting = hour < 12 ? 'Good Morning' : hour < 18 ? 'Good Afternoon' : 'Good Evening';
            document.getElementById('user-name').textContent = greeting + ', Alex';
        });
    </script>
</body>
</html>