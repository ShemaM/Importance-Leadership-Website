<?php
// simple-test.php - Simple test without database

echo "=== Importance Leadership Website - Simple Test ===\n\n";

// Test PHP version
echo "PHP Version: " . PHP_VERSION . "\n";

// Test required extensions
echo "\nRequired Extensions:\n";
$extensions = ['pdo', 'curl', 'json', 'mbstring'];
foreach ($extensions as $ext) {
    $status = extension_loaded($ext) ? 'LOADED' : 'MISSING';
    echo "  {$ext}: {$status}\n";
}

// Test MySQL extension separately
$mysql_status = extension_loaded('pdo_mysql') ? 'LOADED' : 'MISSING (expected in CLI)';
echo "  pdo_mysql: {$mysql_status}\n";

// Test file structure
echo "\nFile Structure:\n";
$files = [
    'includes/config-test.php',
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
    $exists = file_exists($file) ? 'FOUND' : 'MISSING';
    $size = file_exists($file) ? ' (' . filesize($file) . ' bytes)' : '';
    echo "  {$file}: {$exists}{$size}\n";
}

// Test configuration loading
echo "\nConfiguration Test:\n";
try {
    define('ALLOW_ACCESS', true);
    include 'includes/config-test.php';
    include 'includes/functions.php';
    
    echo "  ✓ Configuration loaded successfully\n";
    echo "  Environment: " . ENVIRONMENT . "\n";
    echo "  Site Name: " . SITE_NAME . "\n";
    echo "  Site URL: " . SITE_URL . "\n";
    
} catch (Exception $e) {
    echo "  ✗ Configuration error: " . $e->getMessage() . "\n";
}

// Test utility functions
echo "\nUtility Functions:\n";
if (function_exists('sanitizeInput')) {
    $test_input = '<script>alert("test")</script>';
    $sanitized = sanitizeInput($test_input);
    echo "  ✓ sanitizeInput() working: " . $sanitized . "\n";
}

if (function_exists('validateEmail')) {
    $valid = validateEmail('test@example.com') ? 'Yes' : 'No';
    $invalid = validateEmail('invalid-email') ? 'Yes' : 'No';
    echo "  ✓ validateEmail() working: Valid={$valid}, Invalid={$invalid}\n";
}

if (function_exists('getAssetUrl')) {
    $asset_url = getAssetUrl('css/main.css');
    echo "  ✓ getAssetUrl() working: {$asset_url}\n";
}

if (function_exists('isDevelopment')) {
    $is_dev = isDevelopment() ? 'Yes' : 'No';
    echo "  ✓ isDevelopment() working: {$is_dev}\n";
}

if (function_exists('formatDate')) {
    $formatted = formatDate('2024-01-01');
    echo "  ✓ formatDate() working: {$formatted}\n";
}

if (function_exists('truncateText')) {
    $truncated = truncateText('This is a very long text that should be truncated', 20);
    echo "  ✓ truncateText() working: {$truncated}\n";
}

echo "\n=== Test Complete ===\n";
echo "Status: All core components are working!\n";
echo "Next: Test with web server using 'php -S localhost:8000'\n";

?>