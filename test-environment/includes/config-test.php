<?php
// includes/config-test.php - Test version of config

// Prevent direct access
if (!defined('ALLOW_ACCESS')) {
    define('ALLOW_ACCESS', true);
}

// Set test environment variables for CLI
if (!isset($_SERVER['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = 'localhost';
}
if (!isset($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = 'localhost';
}
if (!isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = '/';
}
if (!isset($_SERVER['PHP_SELF'])) {
    $_SERVER['PHP_SELF'] = '/test.php';
}

// Environment detection
define('ENVIRONMENT', $_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1' ? 'development' : 'production');

// Database configuration - disabled for CLI testing
define('DB_HOST', 'localhost');
define('DB_NAME', 'test_database');
define('DB_USER', 'test_user');
define('DB_PASS', 'test_password');

// Site configuration
define('SITE_NAME', 'Importance Leadership Organization');
define('SITE_URL', ENVIRONMENT === 'development' ? 'http://localhost:8000' : 'https://www.importanceleadership.com');
define('ADMIN_EMAIL', 'admin@importanceleadership.com');

// Payment processing (test keys)
define('STRIPE_SECRET_KEY', 'sk_test_test_key_here');
define('STRIPE_PUBLIC_KEY', 'pk_test_test_key_here');
define('PAYPAL_CLIENT_ID', 'test_paypal_client_id');

// Security
define('CSRF_SECRET', 'test-csrf-secret-key');
define('SESSION_LIFETIME', 3600); // 1 hour

// File upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_DOCUMENT_TYPES', ['pdf', 'doc', 'docx', 'txt']);

// Email settings
define('SMTP_HOST', 'smtp.test.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'test@test.com');
define('SMTP_PASSWORD', 'test_password');
define('FROM_EMAIL', 'noreply@importanceleadership.com');
define('FROM_NAME', 'Importance Leadership Organization');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Database connection - skip for CLI testing
$pdo = null;
if (extension_loaded('pdo_mysql')) {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    } catch(PDOException $e) {
        // Silently fail in test environment
        $pdo = null;
    }
}

// Start session if not in CLI mode
if (php_sapi_name() !== 'cli' && session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CSRF Token generation
if (php_sapi_name() !== 'cli') {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

// Timezone
date_default_timezone_set('UTC');

// Application constants
define('ITEMS_PER_PAGE', 12);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_ATTEMPT_TIMEOUT', 300); // 5 minutes

// Cache settings
define('CACHE_ENABLED', false); // Disabled for testing
define('CACHE_LIFETIME', 3600); // 1 hour

?>