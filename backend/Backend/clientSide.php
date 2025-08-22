<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leadership Portal Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color:rgb(140, 171, 202);
    }
    .dashboard-container {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 250px;
      background-color: #123456;
      color: #ffff;
      padding: 20px 0;
    }
    .sidebar-brand img {
      width: 150px;
      display: block;
      margin: 0 auto 30px;
    }
    .sidebar .nav-link {
      color: #ccc;
      padding: 12px 20px;
    }
    .sidebar .nav-link.active, .sidebar .nav-link:hover {
      background-color: #218838;
      color: #fff;
    }
    .main-content {
      flex-grow: 1;
      padding: 30px;
      background-color: #fff;
    }
    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }
    .welcome-banner {
      background-color:rgb(71, 96, 147);
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
    }
    .stats-overview .stat-card {
      display: flex;
      align-items: center;
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }
    .stat-icon {
      font-size: 30px;
      padding: 15px;
      border-radius: 50%;
      color: #fff;
      margin-right: 20px;
    }
    .bg-primary { background-color: #007bff; }
    .bg-success { background-color: #28a745; }
    .bg-info { background-color: #17a2b8; }
    .bg-warning { background-color: #ffc107; color: #212529; }
    .resource-card {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .resource-card .card-header {
      display: flex;
      align-items: center;
      font-size: 20px;
      margin-bottom: 15px;
    }
    .resource-card .card-header i {
      margin-right: 10px;
    }
    .media-item {
      margin-bottom: 15px;
    }
    .media-thumbnail {
      width: 100%;
      height: 180px;
      background-size: cover;
      background-position: center;
      border-radius: 8px;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .media-thumbnail i {
      font-size: 30px;
      color: #fff;
    }
    .media-title {
      margin-top: 10px;
      font-size: 16px;
      font-weight: 600;
    }
    .media-meta {
      font-size: 14px;
      color: #6c757d;
    }
    .event-item {
      display: flex;
      margin-bottom: 15px;
    }
    .event-date {
      background: #218838;
      color: white;
      padding: 10px;
      text-align: center;
      border-radius: 10px;
      margin-right: 15px;
    }
    .event-day {
      font-size: 24px;
      font-weight: bold;
    }
    .event-month {
      font-size: 14px;
    }
    .event-details h4 {
      margin: 0 0 5px;
    }
    .event-location {
      font-size: 14px;
      color: #6c757d;
    }
    .event-tags .tag {
      background: #dee2e6;
      color: #333;
      padding: 3px 8px;
      font-size: 12px;
      border-radius: 5px;
      margin-right: 5px;
    }
    .view-all {
      display: inline-block;
      margin-top: 10px;
      color: #218838;
      font-weight: 500;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <div class="sidebar">
      <div class="sidebar-brand">
        <img src="../image/website-logo.png" alt="Logo">
      </div>
      <nav>
        <ul class="nav flex-column">
          <li class="nav-item"><a class="nav-link active" href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="videos.php"><i class="fas fa-video"></i> Videos</a></li>
          <li class="nav-item"><a class="nav-link" href="articles.php"><i class="fas fa-newspaper"></i> Articles</a></li>
          <li class="nav-item"><a class="nav-link" href="events.php"><i class="fas fa-calendar-check"></i> Events</a></li>
          <li class="nav-item"><a class="nav-link" href="mentorship.php"><i class="fas fa-user-graduate"></i> Mentorship</a></li>
          <li class="nav-item"><a class="nav-link" href="community.php"><i class="fas fa-users"></i> Community</a></li>
          <li class="nav-item"><a class="nav-link" href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
      </nav>
    </div>

    <div class="main-content">
      <div class="dashboard-header">
        <h2>Welcome Back, <span>Leader</span></h2>
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <img src="../image/website-logo.png" alt="User" class="user-avatar me-2">
            <span>Guest User</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i> Profile</a></li>
            <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
          </ul>
        </div>
      </div>

      <div class="welcome-banner">
        <div class="row align-items-center">
          <div class="col-md-8">
            <h1>Your Leadership Journey Starts Here</h1>
            <p class="mb-0">Access exclusive resources, connect with mentors, and join our community of leaders</p>
          </div>
          <div class="col-md-4 text-center">
            <img src="../image/leadershipDevelopemnt.jpg" alt="Welcome" class="img-fluid">
          </div>
        </div>
      </div>

      <div class="stats-overview row">
        <div class="col-md-3"><div class="stat-card"><div class="stat-icon bg-primary"><i class="fas fa-users"></i></div><div class="stat-info"><h3>0</h3><p>Total Users</p></div></div></div>
        <div class="col-md-3"><div class="stat-card"><div class="stat-icon bg-success"><i class="fas fa-user-plus"></i></div><div class="stat-info"><h3>0</h3><p>New Users</p></div></div></div>
        <div class="col-md-3"><div class="stat-card"><div class="stat-icon bg-info"><i class="fas fa-video"></i></div><div class="stat-info"><h3>0</h3><p>Total Videos</p></div></div></div>
        <div class="col-md-3"><div class="stat-card"><div class="stat-icon bg-warning"><i class="fas fa-calendar"></i></div><div class="stat-info"><h3>0</h3><p>Upcoming Events</p></div></div></div>
      </div>

      <div class="resource-card">
        <div class="card-header"><i class="fas fa-video"></i><h3>Featured Videos</h3></div>
        <div class="card-body">
          <p>No videos available at the moment.</p>
          <a href="videos.php" class="view-all">View all videos →</a>
        </div>
      </div>

      <div class="resource-card">
        <div class="card-header"><i class="fas fa-newspaper"></i><h3>Latest Articles</h3></div>
        <div class="card-body">
          <p>No articles available at the moment.</p>
          <a href="articles.php" class="view-all">View all articles →</a>
        </div>
      </div>

      <div class="resource-card">
        <div class="card-header"><i class="fas fa-calendar-check"></i><h3>Upcoming Events</h3></div>
        <div class="card-body">
          <p>No events available at the moment.</p>
          <a href="events.php" class="view-all">View all events →</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
