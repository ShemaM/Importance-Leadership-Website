<?php
// Start secure session with enhanced settings
session_start([
    'cookie_lifetime' => 86400, // 1 day
    'cookie_secure' => !empty($_SERVER['HTTPS']), // Auto HTTPS detection
    'cookie_httponly' => true,
    'use_strict_mode' => true,
    'cookie_samesite' => 'Strict'
]);

// Regenerate session ID periodically to prevent fixation
if (!isset($_SESSION['created'])) {
    session_regenerate_id(true);
    $_SESSION['created'] = time();
} elseif (time() - $_SESSION['created'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}

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
    // Get admin data with all needed fields in one query
    $stmt = $pdo->prepare("
        SELECT id, first_name, last_name, email, admin_level, last_login 
        FROM admin_users 
        WHERE id = ? AND auth_token = ? AND last_active > DATE_SUB(NOW(), INTERVAL 30 MINUTE)
    ");
    $stmt->execute([$_SESSION['admin_id'], $_SESSION['admin_auth_token']]);
    $admin_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin_data) {
        header("Location: admin-login.php?error=invalid_credentials");
        exit();
    }

    // Update last active time
    $pdo->prepare("UPDATE admin_users SET last_active = NOW() WHERE id = ?")
        ->execute([$_SESSION['admin_id']]);

    // Get system statistics in a transaction
    $pdo->beginTransaction();
    
    try {
        // User statistics
        $user_stats = $pdo->query("
            SELECT 
                COUNT(*) as total_users,
                SUM(CASE WHEN created_at > DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as new_users,
                (SELECT COUNT(*) FROM user_programs WHERE enrollment_status = 'active') as active_programs
            FROM users
        ")->fetch(PDO::FETCH_ASSOC);

        // Content statistics
        $content_stats = $pdo->query("
            SELECT 
                (SELECT COUNT(*) FROM videos) as total_videos,
                (SELECT COUNT(*) FROM articles) as total_articles,
                (SELECT COUNT(*) FROM events WHERE event_date >= CURDATE()) as upcoming_events
        ")->fetch(PDO::FETCH_ASSOC);

        // Recent activity
        $recent_activity = $pdo->query("
            SELECT activity_type, description, created_at 
            FROM admin_logs 
            ORDER BY created_at DESC 
            LIMIT 10
        ")->fetchAll(PDO::FETCH_ASSOC);

        // Get featured content
        $videos = $pdo->query("SELECT id, title, thumbnail_url, duration, difficulty FROM videos ORDER BY created_at DESC LIMIT 2")->fetchAll(PDO::FETCH_ASSOC);
        $articles = $pdo->query("SELECT id, title, image_url, read_time, has_pdf FROM articles ORDER BY created_at DESC LIMIT 2")->fetchAll(PDO::FETCH_ASSOC);
        $events = $pdo->query("SELECT id, title, event_date, location, tags FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 2")->fetchAll(PDO::FETCH_ASSOC);
        $conferences = $pdo->query("SELECT id, title, image_url, 
                                  (SELECT COUNT(*) FROM conference_videos WHERE conference_id = conferences.id) as video_count,
                                  (SELECT COUNT(*) FROM conference_resources WHERE conference_id = conferences.id) as resource_count
                                  FROM conferences ORDER BY created_at DESC LIMIT 2")->fetchAll(PDO::FETCH_ASSOC);

        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Admin dashboard error: " . $e->getMessage());
        header("Location: admin-error.php?code=dashboard_load");
        exit();
    }

} catch (PDOException $e) {
    error_log("Admin access error: " . $e->getMessage());
    header("Location: admin-login.php?error=db_error");
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
    <!-- Content Security Policy -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; img-src 'self' data: https:;">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <img src="image/logo.png" alt="Leadership Portal">
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
                <h2>Welcome Back, <span id="user-name"><?php echo htmlspecialchars($admin_data['first_name']); ?></span></h2>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="image/website-logo.png" alt="User" class="user-avatar me-2">
                        <span><?php echo htmlspecialchars($admin_data['first_name'] . ' ' . $admin_data['last_name']); ?></span>
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

            <!-- Stats Overview -->
            <div class="stats-overview mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo htmlspecialchars($user_stats['total_users']); ?></h3>
                                <p>Total Users</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-success">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo htmlspecialchars($user_stats['new_users']); ?></h3>
                                <p>New Users</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-info">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo htmlspecialchars($content_stats['total_videos']); ?></h3>
                                <p>Total Videos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo htmlspecialchars($content_stats['upcoming_events']); ?></h3>
                                <p>Upcoming Events</p>
                            </div>
                        </div>
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
                        <?php foreach ($videos as $video): ?>
                        <div class="media-item">
                            <div class="media-thumbnail" style="background-image: url('<?php echo htmlspecialchars($video['thumbnail_url']); ?>')">
                                <i class="fas fa-play"></i>
                            </div>
                            <h4 class="media-title"><?php echo htmlspecialchars($video['title']); ?></h4>
                            <p class="media-meta"><?php echo htmlspecialchars($video['duration']); ?> • <?php echo htmlspecialchars($video['difficulty']); ?></p>
                        </div>
                        <?php endforeach; ?>
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
                        <?php foreach ($articles as $article): ?>
                        <div class="media-item">
                            <div class="media-thumbnail" style="background-image: url('<?php echo htmlspecialchars($article['image_url']); ?>')">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h4 class="media-title"><?php echo htmlspecialchars($article['title']); ?></h4>
                            <p class="media-meta"><?php echo htmlspecialchars($article['read_time']); ?> read<?php echo $article['has_pdf'] ? ' • PDF Available' : ''; ?></p>
                        </div>
                        <?php endforeach; ?>
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
                        <?php foreach ($events as $event): 
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
                        <?php endforeach; ?>
                        <a href="events.php" class="view-all">View all events →</a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="resource-card">
                    <div class="card-header">
                        <i class="fas fa-history"></i>
                        <h3>Recent Activity</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_activity as $activity): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($activity['activity_type']); ?></td>
                                        <td><?php echo htmlspecialchars($activity['description']); ?></td>
                                        <td><?php echo htmlspecialchars($activity['created_at']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="activity-logs.php" class="view-all">View all activity →</a>
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
                        <?php foreach ($conferences as $conference): ?>
                        <div class="col-md-6">
                            <div class="media-item">
                                <div class="media-thumbnail" style="background-image: url('<?php echo htmlspecialchars($conference['image_url']); ?>')">
                                    <i class="fas fa-play-circle"></i>
                                </div>
                                <h4 class="media-title"><?php echo htmlspecialchars($conference['title']); ?></h4>
                                <p class="media-meta"><?php echo htmlspecialchars($conference['video_count']); ?> Videos • <?php echo htmlspecialchars($conference['resource_count']); ?> Resources</p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="conferences.php" class="view-all">Browse all conferences →</a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="resource-card">
                <div class="card-header">
                    <i class="fas fa-link"></i>
                    <h3>Quick Actions</h3>
                </div>
                <div class="card-body"> 
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="add-content.php" class="btn-action btn-primary w-100">
                                <i class="fas fa-plus"></i> Add Content
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="user-management.php" class="btn-action btn-success w-100">
                                <i class="fas fa-users-cog"></i> Manage Users
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="reports.php" class="btn-action btn-info w-100">
                                <i class="fas fa-chart-bar"></i> View Reports
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="settings.php" class="btn-action btn-secondary w-100">
                                <i class="fas fa-cog"></i> Settings
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
            document.getElementById('user-name').textContent = greeting + ', <?php echo addslashes($admin_data['first_name']); ?>';
        });
    </script>
</body>
</html>