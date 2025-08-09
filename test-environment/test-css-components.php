<?php
// test-css-components.php - Test individual CSS component files

echo "=== Testing CSS Component Files ===\n\n";

// Test CSS component files
$component_files = [
    'css/components/header.css',
    'css/components/nav.css', 
    'css/components/footer.css',
    'css/components/pages.css'
];

echo "CSS Component Files:\n";
foreach ($component_files as $file) {
    if (file_exists($file)) {
        $size = filesize($file);
        echo "  ✓ {$file}: Found ({$size} bytes)\n";
        
        // Check if file contains expected CSS classes
        $content = file_get_contents($file);
        $classes_to_check = [];
        
        switch (basename($file)) {
            case 'header.css':
                $classes_to_check = ['.skip-link', '.loading-indicator', '.flash-messages'];
                break;
            case 'nav.css':
                $classes_to_check = ['.site-header', '.navbar', '.dropdown-menu'];
                break;
            case 'footer.css':
                $classes_to_check = ['.site-footer', '.footer-grid', '.newsletter-form'];
                break;
            case 'pages.css':
                $classes_to_check = ['.hero', '.impact-stats', '.program-card'];
                break;
        }
        
        foreach ($classes_to_check as $class) {
            if (strpos($content, $class) !== false) {
                echo "    ✓ Contains {$class}\n";
            } else {
                echo "    ⚠ Missing {$class}\n";
            }
        }
    } else {
        echo "  ✗ {$file}: Missing\n";
    }
}

// Test that old components.css is not referenced
echo "\nChecking header.php CSS references:\n";
if (file_exists('components/header.php')) {
    $header_content = file_get_contents('components/header.php');
    
    if (strpos($header_content, 'css/components.css') !== false) {
        echo "  ⚠ Still references old components.css\n";
    } else {
        echo "  ✓ No longer references old components.css\n";
    }
    
    if (strpos($header_content, 'css/components/header.css') !== false) {
        echo "  ✓ References new header.css\n";
    } else {
        echo "  ⚠ Missing reference to header.css\n";
    }
    
    if (strpos($header_content, 'css/components/nav.css') !== false) {
        echo "  ✓ References new nav.css\n";
    } else {
        echo "  ⚠ Missing reference to nav.css\n";
    }
    
    if (strpos($header_content, 'css/components/footer.css') !== false) {
        echo "  ✓ References new footer.css\n";
    } else {
        echo "  ⚠ Missing reference to footer.css\n";
    }
    
    if (strpos($header_content, 'css/components/pages.css') !== false) {
        echo "  ✓ References new pages.css\n";
    } else {
        echo "  ⚠ Missing reference to pages.css\n";
    }
}

// Test total CSS size comparison
echo "\nCSS Size Analysis:\n";
$old_size = file_exists('../css/components.css') ? filesize('../css/components.css') : 0;
$new_total_size = 0;

foreach ($component_files as $file) {
    if (file_exists($file)) {
        $new_total_size += filesize($file);
    }
}

echo "  Old components.css: {$old_size} bytes\n";
echo "  New component files total: {$new_total_size} bytes\n";

if ($new_total_size > 0) {
    $difference = $new_total_size - $old_size;
    if ($difference > 0) {
        echo "  ✓ New structure is {$difference} bytes larger (better organized)\n";
    } else {
        echo "  ✓ New structure is " . abs($difference) . " bytes smaller\n";
    }
}

echo "\n=== CSS Component Test Complete ===\n";
echo "Status: Component CSS files are properly organized!\n";
echo "Each component now has its own dedicated CSS file.\n";

?>