<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Set admin-related session data (customize as needed)
$_SESSION['admin_id'] = $_SESSION['user_id'];
$_SESSION['admin_auth_token'] = bin2hex(random_bytes(32));
$_SESSION['admin_auth_time'] = time();
$_SESSION['created'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Importance Leadership</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="styles/success.css">
</head>
<body>

  <!-- Header -->
  <header id="header-container"></header>
  <script src="loadHeader.js"></script>

  <!-- Animated Background -->
  <div class="background-gradient">
    <div class="gradient-circle circle-1"></div>
    <div class="gradient-circle circle-2"></div>
  </div>

  <!-- Success Container -->
  <main class="success-container">
    <div class="success-icon">
      <i class="fas fa-check"></i>
    </div>

    <h1 class="success-title">Registration Successful</h1>
    <h2 class="success-subtitle">Welcome to Importance Leadership</h2>

    <p class="success-message">
      Thank you for joining our community of leaders and changemakers. We're excited to have you on board.
    </p>

    <ul class="benefits-list text-warning">
      <li><i class="fas fa-unlock-alt"></i> Immediate access to leadership resources</li>
      <li><i class="fas fa-calendar-check"></i> Invitations to exclusive events</li>
      <li><i class="fas fa-user-graduate"></i> Personalized mentorship program</li>
      <li><i class="fas fa-envelope-open-text"></i> Welcome package with starter guides</li>
      <li><i class="fas fa-headset"></i> Dedicated support team available 24/7</li>
    </ul>

    <p class="success-message">
      We've sent a confirmation email with your login details and next steps. Please check your inbox.
    </p>

    <!-- Action Buttons -->
    <div class="action-buttons">
      <form id="dashboardForm" action="verify-dashboard-access.php" method="post">
        <input type="hidden" name="access_token" value="<?php echo $_SESSION['admin_auth_token']; ?>">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-tachometer-alt"></i> Access Dashboard
        </button>
      </form>

      <a href="index.html" class="btn btn-info">
        <i class="fas fa-home"></i> Return Home
      </a>
    </div>
  </main>

  <!-- Footer -->
  <script src="loadFooter.js"></script>

  <!-- Small interaction script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const container = document.querySelector('.success-container');
      container.addEventListener('mouseenter', () => {
        container.style.transform = 'translateY(-5px)';
      });
      container.addEventListener('mouseleave', () => {
        container.style.transform = 'translateY(0)';
      });
    });
  </script>

</body>
</html>
