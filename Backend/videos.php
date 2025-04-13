<?php
// Start secure session
session_start();

// Database configuration
$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'importanceleadership',
    'username' => 'root',
    'password' => 'secret'
];

// Constants
define('BASE_URL', 'https://importanceleadership.com/user');
define('SITE_NAME', 'Importance Leadership');

try {
    // Establish PDO connection
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

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: userDashboard.php");
    exit();
}

// Get user data
$userId = $_SESSION['user_id'];
$userData = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$userData->execute([$userId]);
$user = $userData->fetch();

if (!$user) {
    header("Location: join-us.php");
    exit();
}

// Get video categories
$categories = $pdo->query("SELECT * FROM video_categories ORDER BY name")->fetchAll();

// Get featured videos
$featuredVideos = $pdo->prepare("
    SELECT v.*, vc.name as category_name 
    FROM videos v
    JOIN video_categories vc ON v.category_id = vc.id
    WHERE v.is_featured = 1
    ORDER BY v.created_at DESC
    LIMIT 4
");
$featuredVideos->execute();

// Get all videos (paginated)
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 8;
$offset = ($currentPage - 1) * $itemsPerPage;

$totalVideos = $pdo->query("SELECT COUNT(*) FROM videos")->fetchColumn();
$totalPages = ceil($totalVideos / $itemsPerPage);

$videos = $pdo->prepare("
    SELECT v.*, vc.name as category_name 
    FROM videos v
    JOIN video_categories vc ON v.category_id = vc.id
    ORDER BY v.created_at DESC
    LIMIT ? OFFSET ?
");
$videos->bindValue(1, $itemsPerPage, PDO::PARAM_INT);
$videos->bindValue(2, $offset, PDO::PARAM_INT);
$videos->execute();

// Get recently watched videos (for logged in users)
$recentlyWatched = $pdo->prepare("
    SELECT v.* 
    FROM user_video_history uv
    JOIN videos v ON uv.video_id = v.id
    WHERE uv.user_id = ?
    ORDER BY uv.watched_at DESC
    LIMIT 3
");
$recentlyWatched->execute([$userId]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(SITE_NAME) ?> - Video Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --radius: 12px;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .video-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: var(--radius);
            overflow: hidden;
        }

        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .video-thumbnail {
            position: relative;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
            background-size: cover;
            background-position: center;
        }

        .video-thumbnail::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
        }

        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 3rem;
            z-index: 1;
            opacity: 0.9;
        }

        .video-duration {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            z-index: 1;
        }

        .category-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--secondary);
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            z-index: 1;
        }

        .progress-bar {
            height: 4px;
            background: #e9ecef;
            position: relative;
        }

        .progress-completed {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            background: var(--secondary);
            width: 0%;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .video-card {
                margin-bottom: 1.5rem;
            }
            
            .featured-section {
                padding: 1rem 0;
            }
            
            .video-filter {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Include your dashboard sidebar and header -->
    <?php include('partials/sidebar.php'); ?>
    
    <div class="main-content">
        <?php include('partials/header.php'); ?>
        
        <!-- Video Library Header -->
        <div class="container-fluid mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2"><i class="fas fa-video me-2"></i> Video Library</h1>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search me-1"></i> Search Videos
                    </button>
                </div>
            </div>
            
            <!-- Video Filter Controls -->
            <div class="video-filter d-flex justify-content-between align-items-center mb-4">
                <div class="btn-group">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Categories
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item active" href="#">All Categories</a></li>
                        <?php foreach ($categories as $category): ?>
                        <li><a class="dropdown-item" href="#"><?= htmlspecialchars($category['name']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="btn-group">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Sort By
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item active" href="#">Newest First</a></li>
                        <li><a class="dropdown-item" href="#">Most Popular</a></li>
                        <li><a class="dropdown-item" href="#">A-Z</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Recently Watched Section -->
        <?php if ($recentlyWatched->rowCount() > 0): ?>
        <div class="container-fluid mb-5">
            <h3 class="h4 mb-3">Continue Watching</h3>
            <div class="row">
                <?php foreach ($recentlyWatched as $video): ?>
                <div class="col-md-4 mb-4">
                    <div class="video-card card h-100">
                        <div class="video-thumbnail" style="background-image: url('<?= htmlspecialchars($video['thumbnail_url']) ?>')">
                            <a href="watch.php?id=<?= $video['id'] ?>" class="stretched-link">
                                <i class="fas fa-play play-button"></i>
                            </a>
                            <span class="video-duration"><?= gmdate("i:s", $video['duration']) ?></span>
                            <span class="category-badge"><?= htmlspecialchars($video['category_name']) ?></span>
                        </div>
                        <div class="card-body">
                            <div class="progress-bar mb-2">
                                <div class="progress-completed" style="width: <?= rand(10, 90) ?>%"></div>
                            </div>
                            <h4 class="card-title"><?= htmlspecialchars($video['title']) ?></h4>
                            <p class="card-text text-muted small"><?= htmlspecialchars($video['instructor']) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Featured Videos Section -->
        <div class="container-fluid mb-5 featured-section">
            <h3 class="h4 mb-3">Featured Videos</h3>
            <div class="row">
                <?php foreach ($featuredVideos as $video): ?>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="video-card card h-100">
                        <div class="video-thumbnail" style="background-image: url('<?= htmlspecialchars($video['thumbnail_url']) ?>')">
                            <a href="watch.php?id=<?= $video['id'] ?>" class="stretched-link">
                                <i class="fas fa-play play-button"></i>
                            </a>
                            <span class="video-duration"><?= gmdate("i:s", $video['duration']) ?></span>
                            <span class="category-badge"><?= htmlspecialchars($video['category_name']) ?></span>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?= htmlspecialchars($video['title']) ?></h4>
                            <p class="card-text text-muted small"><?= htmlspecialchars($video['instructor']) ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-dark"><i class="fas fa-eye me-1"></i> <?= number_format($video['views']) ?></span>
                                <span class="badge bg-light text-dark"><i class="fas fa-star me-1"></i> <?= number_format($video['rating'], 1) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- All Videos Section -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h4">All Videos</h3>
                <div class="text-muted small">Showing <?= ($offset + 1) ?>-<?= min($offset + $itemsPerPage, $totalVideos) ?> of <?= number_format($totalVideos) ?> videos</div>
            </div>
            
            <div class="row">
                <?php foreach ($videos as $video): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="video-card card h-100">
                        <div class="video-thumbnail" style="background-image: url('<?= htmlspecialchars($video['thumbnail_url']) ?>')">
                            <a href="watch.php?id=<?= $video['id'] ?>" class="stretched-link">
                                <i class="fas fa-play play-button"></i>
                            </a>
                            <span class="video-duration"><?= gmdate("i:s", $video['duration']) ?></span>
                            <span class="category-badge"><?= htmlspecialchars($video['category_name']) ?></span>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?= htmlspecialchars($video['title']) ?></h4>
                            <p class="card-text text-muted small"><?= htmlspecialchars($video['instructor']) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <nav aria-label="Video pagination">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a>
                    </li>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    
    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Search Videos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg" placeholder="Search for videos...">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Duration</label>
                                <select class="form-select">
                                    <option value="">Any Length</option>
                                    <option value="short">Short (under 5 min)</option>
                                    <option value="medium">Medium (5-20 min)</option>
                                    <option value="long">Long (20+ min)</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    
                    <div class="search-results mt-4">
                        <h6 class="text-muted mb-3">Popular Searches</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="btn btn-sm btn-outline-secondary">Leadership Basics</a>
                            <a href="#" class="btn btn-sm btn-outline-secondary">Team Building</a>
                            <a href="#" class="btn btn-sm btn-outline-secondary">Communication</a>
                            <a href="#" class="btn btn-sm btn-outline-secondary">Decision Making</a>
                            <a href="#" class="btn btn-sm btn-outline-secondary">Motivation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Video hover effect for touch devices
        document.addEventListener('DOMContentLoaded', function() {
            if ('ontouchstart' in window) {
                const videoCards = document.querySelectorAll('.video-card');
                videoCards.forEach(card => {
                    card.style.transition = 'none';
                });
            }
        });
    </script>
</body>
</html>