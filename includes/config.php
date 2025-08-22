<?php
// includes/config.php - Basic configuration for testing

// Environment detection
define('ENVIRONMENT', $_SERVER['SERVER_NAME'] === 'localhost' ? 'development' : 'production');

// Site configuration
define('SITE_NAME', 'Importance Leadership Organization');
define('SITE_URL', ENVIRONMENT === 'development' ? 'http://localhost:8000' : 'https://importanceleadership.org');
define('ADMIN_EMAIL', 'admin@importanceleadership.org');

// Basic error reporting for development
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Start session for future use
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>