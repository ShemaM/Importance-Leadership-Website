<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'importanceleadership'); // Replace with your database name
define('DB_USER', 'root'); // Replace with your database username
define('DB_PASS', 'secret'); // Replace with your database password

// Create a PDO instance to handle the database connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable error handling
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch results as associative arrays
            PDO::ATTR_EMULATE_PREPARES => false // Disable emulated prepared statements (use real prepared statements)
        ]
    );
} catch (PDOException $e) {
    // Handle any connection errors
    die("Database connection failed: " . $e->getMessage());
}

// Optional: Set the default timezone
date_default_timezone_set('America/New_York'); // Change to your preferred timezone
?>
