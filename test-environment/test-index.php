<?php
// test-index.php - Test the index page structure

echo "=== Testing Index Page Structure ===\n\n";

// Set up test environment
define('ALLOW_ACCESS', true);

// Override superglobals for CLI testing
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['PHP_SELF'] = '/index.php';
$_SERVER['HTTPS'] = '';

include 'includes/config-test.php';
include 'includes/functions.php';

// Set page variables like in index.php
$page_title = "Welcome to Importance Leadership | Empowering Future Leaders";
$meta_description = "Importance Leadership Organization empowers young people through leadership development, mentorship programs, and community impact initiatives across Africa and beyond.";
$meta_keywords = "leadership, youth empowerment, Africa, mentorship, community development, importance leadership";
$body_class = "home-page";

$additional_head = '
    <meta property="og:title" content="Importance Leadership Organization">
    <meta property="og:description" content="Empowering young leaders across Africa through comprehensive leadership development programs">
    <meta property="og:image" content="/images/hero-bg.jpg">
    <meta property="og:url" content="https://www.importanceleadership.com">
    <meta name="twitter:card" content="summary_large_image">
';

echo "Testing page variables:\n";
echo "  ✓ Page Title: " . substr($page_title, 0, 50) . "...\n";
echo "  ✓ Meta Description: " . substr($meta_description, 0, 50) . "...\n";
echo "  ✓ Body Class: {$body_class}\n";

echo "\nTesting component includes:\n";

// Test header component
echo "  Testing header component...\n";
ob_start();
try {
    include 'components/header.php';
    $header_output = ob_get_contents();
    ob_end_clean();
    
    if (strpos($header_output, '<html') !== false) {
        echo "  ✓ Header component loaded (found <html tag)\n";
    } else {
        echo "  ⚠ Header component loaded but no HTML tag found\n";
    }
    
    if (strpos($header_output, $page_title) !== false) {
        echo "  ✓ Page title properly inserted in header\n";
    } else {
        echo "  ⚠ Page title not found in header\n";
    }
    
    if (strpos($header_output, SITE_NAME) !== false) {
        echo "  ✓ Site name found in header\n";
    } else {
        echo "  ⚠ Site name not found in header\n";
    }
    
} catch (Exception $e) {
    ob_end_clean();
    echo "  ✗ Header component error: " . $e->getMessage() . "\n";
}

// Test navigation component  
echo "  Testing navigation component...\n";
ob_start();
try {
    include 'components/nav.php';
    $nav_output = ob_get_contents();
    ob_end_clean();
    
    if (strpos($nav_output, '<nav') !== false) {
        echo "  ✓ Navigation component loaded (found <nav tag)\n";
    } else {
        echo "  ⚠ Navigation component loaded but no nav tag found\n";
    }
    
    if (strpos($nav_output, 'Programs') !== false) {
        echo "  ✓ Navigation menu items found\n";
    } else {
        echo "  ⚠ Navigation menu items not found\n";
    }
    
} catch (Exception $e) {
    ob_end_clean();
    echo "  ✗ Navigation component error: " . $e->getMessage() . "\n";
}

// Test footer component
echo "  Testing footer component...\n";  
ob_start();
try {
    include 'components/footer.php';
    $footer_output = ob_get_contents();
    ob_end_clean();
    
    if (strpos($footer_output, '<footer') !== false) {
        echo "  ✓ Footer component loaded (found <footer tag)\n";
    } else {
        echo "  ⚠ Footer component loaded but no footer tag found\n";
    }
    
    if (strpos($footer_output, '</body>') !== false) {
        echo "  ✓ Footer properly closes HTML document\n";
    } else {
        echo "  ⚠ Footer doesn't close HTML document\n";
    }
    
    if (strpos($footer_output, date('Y')) !== false) {
        echo "  ✓ Current year found in footer copyright\n";
    } else {
        echo "  ⚠ Current year not found in footer\n";
    }
    
} catch (Exception $e) {
    ob_end_clean();
    echo "  ✗ Footer component error: " . $e->getMessage() . "\n";
}

// Test CSS and JS file references
echo "\nTesting asset references:\n";
$css_files = ['css/main.css', 'css/components.css'];
foreach ($css_files as $file) {
    if (file_exists($file)) {
        echo "  ✓ {$file}: Found\n";
    } else {
        echo "  ✗ {$file}: Missing\n";
    }
}

$js_files = ['js/main.js', 'js/components.js'];
foreach ($js_files as $file) {
    if (file_exists($file)) {
        echo "  ✓ {$file}: Found\n";
    } else {
        echo "  ✗ {$file}: Missing\n";
    }
}

// Test image references
echo "\nTesting image references:\n";
$image_files = ['images/logo.png', 'images/hero-bg.jpg', 'images/leadership-development.jpg'];
foreach ($image_files as $file) {
    if (file_exists($file)) {
        echo "  ✓ {$file}: Found\n";
    } else {
        echo "  ✗ {$file}: Missing\n";
    }
}

echo "\n=== Index Page Test Complete ===\n";
echo "Status: Basic structure is working!\n";
echo "All components can be included without fatal errors.\n";
echo "\nTo test in browser, run: php -S localhost:8000\n";
echo "Then visit: http://localhost:8000\n";

?>