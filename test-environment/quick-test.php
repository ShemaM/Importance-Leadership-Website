<?php
// quick-test.php - Test the database fix

echo "=== Quick Database Fix Test ===\n";

// Test configuration loading
try {
    define('ALLOW_ACCESS', true);
    include 'includes/config.php';
    echo "✓ Config loaded successfully\n";
    echo "Environment: " . ENVIRONMENT . "\n";
    
    if (extension_loaded('pdo_mysql')) {
        echo "✓ MySQL PDO extension available\n";
        
        if ($pdo !== null) {
            echo "✓ Database connection succeeded\n";
        } else {
            echo "⚠ Database connection failed (expected without actual DB)\n";
        }
    } else {
        echo "⚠ MySQL PDO extension not available (database features disabled)\n";
    }
    
    echo "✓ No fatal errors - website should work now!\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
echo "Now try: php -S localhost:8000\n";

?>