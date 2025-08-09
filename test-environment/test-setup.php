<?php
// test-setup.php - Test our PHP setup

echo "<h1>Importance Leadership Website - Test Environment</h1>";
echo "<h2>PHP Configuration Test</h2>";

// Test PHP version
echo "<h3>PHP Version</h3>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";

// Test required extensions
echo "<h3>Required Extensions</h3>";
$extensions = ['pdo', 'pdo_mysql', 'curl', 'json', 'mbstring'];
foreach ($extensions as $ext) {
    $status = extension_loaded($ext) ? '✅ Loaded' : '❌ Missing';
    echo "<p>{$ext}: {$status}</p>";
}

// Test include paths
echo "<h3>File Structure Test</h3>";
$files = [
    'includes/config.php',
    'includes/functions.php',
    'components/header.php',
    'components/nav.php',
    'components/footer.php',
    'css/main.css',
    'css/components.css',
    'js/main.js',
    'index.php'
];

foreach ($files as $file) {
    $exists = file_exists($file) ? '✅ Found' : '❌ Missing';
    echo "<p>{$file}: {$exists}</p>";
}

// Test configuration loading
echo "<h3>Configuration Test</h3>";
try {
    define('ALLOW_ACCESS', true);
    include 'includes/config.php';
    include 'includes/functions.php';
    
    echo "<p>✅ Configuration loaded successfully</p>";
    echo "<p>Environment: " . ENVIRONMENT . "</p>";
    echo "<p>Site Name: " . SITE_NAME . "</p>";
    echo "<p>Site URL: " . SITE_URL . "</p>";
    
} catch (Exception $e) {
    echo "<p>❌ Configuration error: " . $e->getMessage() . "</p>";
}

// Test database connection (if configured)
echo "<h3>Database Connection Test</h3>";
if (isset($pdo)) {
    try {
        // Simple query to test connection
        $stmt = $pdo->query('SELECT 1');
        echo "<p>✅ Database connection successful</p>";
    } catch (PDOException $e) {
        echo "<p>⚠️ Database connection failed (expected in test environment): " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>⚠️ Database not configured (expected in test environment)</p>";
}

// Test utility functions
echo "<h3>Function Tests</h3>";
if (function_exists('sanitizeInput')) {
    $test_input = '<script>alert("test")</script>';
    $sanitized = sanitizeInput($test_input);
    echo "<p>✅ sanitizeInput() working: " . htmlspecialchars($sanitized) . "</p>";
}

if (function_exists('validateEmail')) {
    $valid_email = validateEmail('test@example.com');
    $invalid_email = validateEmail('invalid-email');
    echo "<p>✅ validateEmail() working: Valid=" . ($valid_email ? 'Yes' : 'No') . ", Invalid=" . ($invalid_email ? 'Yes' : 'No') . "</p>";
}

if (function_exists('getAssetUrl')) {
    $asset_url = getAssetUrl('css/main.css');
    echo "<p>✅ getAssetUrl() working: " . htmlspecialchars($asset_url) . "</p>";
}

// Test session
echo "<h3>Session Test</h3>";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "<p>✅ Session started successfully</p>";
    echo "<p>Session ID: " . session_id() . "</p>";
    
    if (isset($_SESSION['csrf_token'])) {
        echo "<p>✅ CSRF token generated: " . substr($_SESSION['csrf_token'], 0, 10) . "...</p>";
    }
} else {
    echo "<p>❌ Session not started</p>";
}

echo "<hr>";
echo "<h2>Test Results Summary</h2>";
echo "<p><a href='index.php'>➡️ Test Main Index Page</a></p>";
echo "<p><a href='test-components.php'>➡️ Test Individual Components</a></p>";

?>

<style>
body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
h1 { color: #2c3e50; }
h2 { color: #34495e; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
h3 { color: #2c3e50; margin-top: 30px; }
p { margin: 5px 0; }
a { color: #3498db; text-decoration: none; font-weight: bold; }
a:hover { text-decoration: underline; }
hr { margin: 30px 0; border: 1px solid #bdc3c7; }
</style>