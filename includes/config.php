<?php
// includes/config.php

// Prevent direct access
if (!defined('ALLOW_ACCESS')) {
    define('ALLOW_ACCESS', true);
}

// Environment detection
define('ENVIRONMENT', $_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1' ? 'development' : 'production');

// Database configuration (Hostinger typical setup)
// In production, these should be in environment variables or separate config file
if (ENVIRONMENT === 'development') {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'importance_leadership_dev');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'your_hostinger_database_name');
    define('DB_USER', 'your_hostinger_username');
    define('DB_PASS', 'your_hostinger_password');
}

// Site configuration
define('SITE_NAME', 'Importance Leadership Organization');
define('SITE_URL', ENVIRONMENT === 'development' ? 'http://localhost:8000' : 'https://www.importanceleadership.com');
define('ADMIN_EMAIL', 'admin@importanceleadership.com');

// Payment processing (for donations, etc.)
if (ENVIRONMENT === 'development') {
    define('STRIPE_SECRET_KEY', 'sk_test_your_test_key_here');
    define('STRIPE_PUBLIC_KEY', 'pk_test_your_test_key_here');
} else {
    define('STRIPE_SECRET_KEY', 'sk_live_your_live_key_here');
    define('STRIPE_PUBLIC_KEY', 'pk_live_your_live_key_here');
}
define('PAYPAL_CLIENT_ID', 'your_paypal_client_id');

// Security
define('CSRF_SECRET', 'your-random-csrf-secret-key-change-in-production');
define('SESSION_LIFETIME', 3600); // 1 hour

// File upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_DOCUMENT_TYPES', ['pdf', 'doc', 'docx', 'txt']);

// Email settings
define('SMTP_HOST', 'smtp.hostinger.com'); // Hostinger SMTP
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'noreply@importanceleadership.com');
define('SMTP_PASSWORD', 'your_smtp_password');
define('FROM_EMAIL', 'noreply@importanceleadership.com');
define('FROM_NAME', 'Importance Leadership Organization');

// Error reporting
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/error.log');
}

// Session configuration
ini_set('session.cookie_lifetime', SESSION_LIFETIME);
ini_set('session.cookie_secure', ENVIRONMENT === 'production' ? '1' : '0');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Strict');

// Database connection
$pdo = null;
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );
} catch(PDOException $e) {
    if (ENVIRONMENT === 'development') {
        die("Database connection failed: " . $e->getMessage());
    } else {
        error_log("Database connection failed: " . $e->getMessage());
        die("Database connection failed. Please contact support.");
    }
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CSRF Token generation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Timezone
date_default_timezone_set('UTC');

// Application constants
define('ITEMS_PER_PAGE', 12);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_ATTEMPT_TIMEOUT', 300); // 5 minutes

// Cache settings
define('CACHE_ENABLED', ENVIRONMENT === 'production');
define('CACHE_LIFETIME', 3600); // 1 hour

?>