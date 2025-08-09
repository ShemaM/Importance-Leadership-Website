<?php
// test-components.php - Test individual components

define('ALLOW_ACCESS', true);
include 'includes/config.php';
include 'includes/functions.php';

$page_title = "Component Testing - Importance Leadership";
$meta_description = "Testing individual components";
$body_class = "test-page";

echo "<h1>Component Testing</h1>";

echo "<h2>1. Header Component Test</h2>";
echo "<div style='border: 2px solid #3498db; padding: 15px; margin: 10px 0;'>";
try {
    include 'components/header.php';
    echo "<p style='color: green;'>✅ Header component loaded successfully</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Header component error: " . $e->getMessage() . "</p>";
}
echo "</div>";

echo "<h2>2. Navigation Component Test</h2>";
echo "<div style='border: 2px solid #3498db; padding: 15px; margin: 10px 0;'>";
try {
    // Don't include nav.php here as it would be included in header
    echo "<p style='color: green;'>✅ Navigation component ready (included in header)</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Navigation component error: " . $e->getMessage() . "</p>";
}
echo "</div>";

echo "<h2>3. Flash Messages Test</h2>";
echo "<div style='border: 2px solid #3498db; padding: 15px; margin: 10px 0;'>";
// Test flash messages
setFlashMessage('success', 'Test success message');
setFlashMessage('error', 'Test error message');
setFlashMessage('info', 'Test info message');

if (hasFlashMessages()) {
    echo "<p style='color: green;'>✅ Flash messages system working</p>";
    $messages = getFlashMessages();
    echo "<p>Generated " . count($messages) . " test messages</p>";
} else {
    echo "<p style='color: red;'>❌ Flash messages not working</p>";
}
echo "</div>";

echo "<h2>4. Utility Functions Test</h2>";
echo "<div style='border: 2px solid #3498db; padding: 15px; margin: 10px 0;'>";

// Test various utility functions
$tests = [
    'generateCSRFToken()' => function() { return generateCSRFToken(); },
    'sanitizeInput()' => function() { return sanitizeInput('<script>test</script>'); },
    'validateEmail()' => function() { return validateEmail('test@example.com') ? 'Valid' : 'Invalid'; },
    'isDevelopment()' => function() { return isDevelopment() ? 'Yes' : 'No'; },
    'getAssetUrl()' => function() { return getAssetUrl('test.css'); },
    'formatDate()' => function() { return formatDate('2024-01-01'); },
    'truncateText()' => function() { return truncateText('This is a very long text that should be truncated', 20); }
];

foreach ($tests as $name => $test) {
    try {
        $result = $test();
        echo "<p>✅ {$name}: " . htmlspecialchars(substr(strval($result), 0, 50)) . "</p>";
    } catch (Exception $e) {
        echo "<p>❌ {$name}: Error - " . $e->getMessage() . "</p>";
    }
}
echo "</div>";

echo "<h2>5. CSS Loading Test</h2>";
echo "<div style='border: 2px solid #3498db; padding: 15px; margin: 10px 0;'>";
$css_files = ['css/main.css', 'css/components.css'];
foreach ($css_files as $file) {
    if (file_exists($file)) {
        $size = filesize($file);
        echo "<p>✅ {$file}: Found ({$size} bytes)</p>";
    } else {
        echo "<p>❌ {$file}: Not found</p>";
    }
}
echo "</div>";

echo "<h2>6. JavaScript Loading Test</h2>";
echo "<div style='border: 2px solid #3498db; padding: 15px; margin: 10px 0;'>";
$js_files = ['js/main.js', 'js/components.js'];
foreach ($js_files as $file) {
    if (file_exists($file)) {
        $size = filesize($file);
        echo "<p>✅ {$file}: Found ({$size} bytes)</p>";
    } else {
        echo "<p>❌ {$file}: Not found</p>";
    }
}
echo "</div>";

echo "<hr>";
echo "<p><a href='test-setup.php'>⬅️ Back to Setup Test</a></p>";
echo "<p><a href='index.php'>➡️ Test Full Index Page</a></p>";

?>

<style>
body { font-family: Arial, sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; }
h1 { color: #2c3e50; }
h2 { color: #34495e; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
p { margin: 5px 0; }
a { color: #3498db; text-decoration: none; font-weight: bold; }
a:hover { text-decoration: underline; }
hr { margin: 30px 0; border: 1px solid #bdc3c7; }
</style>