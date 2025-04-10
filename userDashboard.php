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