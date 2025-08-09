# PHP Website Organization Doctrine

**A practical guide for organizing HTML/PHP websites on shared hosting**

## Core Principle

**Never serve standalone HTML files.** Everything goes through PHP, even static content. This enables componentization, dynamic features, and maintainable code structure.

## File Structure

```
public_html/
├── index.php                 # Main landing page
├── .htaccess                 # URL rewriting & performance
├── robots.txt               # SEO
├── sitemap.xml              # SEO
│
├── css/
│   ├── main.css             # Primary styles
│   └── components.css       # Component-specific styles
│
├── js/
│   ├── main.js              # Primary JavaScript
│   └── components.js        # Component interactions
│
├── images/
│   ├── logo.png
│   └── gallery/
│
├── components/              # Reusable PHP components
│   ├── header.php           # <head> section + opening <body>
│   ├── nav.php              # Navigation menu
│   ├── footer.php           # Footer + closing tags
│   ├── meta.php             # Dynamic meta tags
│   └── sidebar.php          # Sidebar component
│
├── includes/                # Backend functionality
│   ├── config.php           # Database & environment config
│   ├── functions.php        # Utility functions
│   ├── auth.php             # Authentication helpers
│   └── validation.php       # Form validation functions
│
├── pages/                   # Main content pages
│   ├── about.php
│   ├── services.php
│   ├── contact.php
│   ├── gallery.php
│   └── 404.php
│
├── forms/                   # Form processing scripts
│   ├── contact-handler.php  # Contact form processor
│   ├── newsletter.php       # Newsletter signup
│   ├── donation.php         # Donation processing
│   └── appointment.php      # Appointment booking
│
├── api/                     # AJAX endpoints & integrations
│   ├── search.php           # Search functionality
│   ├── newsletter-api.php   # Newsletter API calls
│   └── payment-webhook.php  # Payment provider webhooks
│
├── admin/                   # Admin panel (password protected)
│   ├── index.php            # Admin dashboard
│   ├── login.php            # Admin login
│   ├── posts.php            # Content management
│   └── settings.php         # Site settings
│
└── uploads/                 # User-uploaded content
    ├── documents/
    └── gallery/
```

## Component Architecture

### 1. Header Component
```php
<?php
// components/header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Default Site Title' ?></title>
    <meta name="description" content="<?= $meta_description ?? 'Default description' ?>">
    <meta name="keywords" content="<?= $meta_keywords ?? 'default, keywords' ?>">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/components.css">
    <?= $additional_head ?? '' ?>
</head>
<body class="<?= $body_class ?? '' ?>">
```

### 2. Page Template Pattern
```php
<?php
// pages/about.php
$page_title = "About Us | Your Company";
$meta_description = "Learn about our mission, values, and team";
$body_class = "about-page";

include '../components/header.php';
include '../components/nav.php';
?>

<main class="main-content">
    <section class="hero">
        <h1>About Our Company</h1>
        <p>Your content here...</p>
    </section>
    
    <section class="team">
        <?php
        // Dynamic team member loading
        $team_members = getTeamMembers(); // from functions.php
        foreach ($team_members as $member): ?>
            <div class="team-card">
                <h3><?= htmlspecialchars($member['name']) ?></h3>
                <p><?= htmlspecialchars($member['role']) ?></p>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<?php include '../components/footer.php'; ?>
```

## URL Routing & Clean URLs

### .htaccess Configuration
```apache
RewriteEngine On

# Security: Block access to sensitive files
<FilesMatch "\.(php|inc|conf|sql|bak)$">
    Order Allow,Deny
    Deny from all
</FilesMatch>

# Allow access to actual PHP files we want to serve
<Files "index.php">
    Order Allow,Deny
    Allow from all
</Files>

# Clean URLs - Remove .php extension
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^\.]+)$ pages/$1.php [L]

# Redirect .php to clean URL
RewriteCond %{THE_REQUEST} ^[A-Z]{3,}\s/+pages/([^\s]+)\.php [NC]
RewriteRule ^ /%1? [R=301,L]

# Performance optimizations
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>

# Browser caching
<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/pdf "access plus 1 month"
    ExpiresByType text/javascript "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

## Configuration & Environment

### config.php
```php
<?php
// includes/config.php

// Environment detection
define('ENVIRONMENT', $_SERVER['SERVER_NAME'] === 'localhost' ? 'development' : 'production');

// Database configuration (Hostinger typical setup)
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

// Site configuration
define('SITE_NAME', 'Your Website Name');
define('SITE_URL', ENVIRONMENT === 'development' ? 'http://localhost' : 'https://yourwebsite.com');
define('ADMIN_EMAIL', 'admin@yourwebsite.com');

// Payment processing (for donations, etc.)
define('STRIPE_SECRET_KEY', ENVIRONMENT === 'development' ? 'sk_test_...' : 'sk_live_...');
define('STRIPE_PUBLIC_KEY', ENVIRONMENT === 'development' ? 'pk_test_...' : 'pk_live_...');
define('PAYPAL_CLIENT_ID', 'your_paypal_client_id');

// Security
define('CSRF_SECRET', 'your-random-csrf-secret-key');
define('SESSION_LIFETIME', 3600); // 1 hour

// Error reporting
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', '/path/to/error.log');
}

// Database connection
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
    if (ENVIRONMENT === 'development') {
        die("Database connection failed: " . $e->getMessage());
    } else {
        die("Database connection failed. Please contact support.");
    }
}

// Start session
session_start();
?>
```

## Server-Side Processing

### Contact Form Handler
```php
<?php
// forms/contact-handler.php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/validation.php';

if ($_POST && validateCSRFToken($_POST['csrf_token'])) {
    
    // Validate input
    $name = sanitizeInput($_POST['name']);
    $email = validateEmail($_POST['email']);
    $message = sanitizeInput($_POST['message']);
    
    if ($name && $email && $message) {
        
        // Save to database
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $message]);
        
        // Send email
        $subject = "New Contact Form Submission from " . $name;
        $body = "Name: " . $name . "\nEmail: " . $email . "\nMessage: " . $message;
        
        if (mail(ADMIN_EMAIL, $subject, $body)) {
            $_SESSION['success'] = "Thank you! Your message has been sent.";
        } else {
            $_SESSION['error'] = "Sorry, there was an error sending your message.";
        }
        
    } else {
        $_SESSION['error'] = "Please fill in all required fields correctly.";
    }
    
} else {
    $_SESSION['error'] = "Invalid form submission.";
}

header('Location: /contact');
exit;
?>
```

### Donation Processing
```php
<?php
// forms/donation.php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Stripe integration for donation processing
require_once 'vendor/autoload.php'; // If using Composer
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

if ($_POST && validateCSRFToken($_POST['csrf_token'])) {
    
    $amount = (float) $_POST['amount'];
    $donor_name = sanitizeInput($_POST['donor_name']);
    $donor_email = validateEmail($_POST['donor_email']);
    $anonymous = isset($_POST['anonymous']);
    
    if ($amount >= 1.00 && $donor_email) {
        
        try {
            // Create Stripe payment intent
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $amount * 100, // Convert to cents
                'currency' => 'usd',
                'metadata' => [
                    'donor_name' => $donor_name,
                    'donor_email' => $donor_email,
                    'anonymous' => $anonymous
                ]
            ]);
            
            // Save donation record
            $stmt = $pdo->prepare("
                INSERT INTO donations (amount, donor_name, donor_email, anonymous, stripe_intent_id, status, created_at) 
                VALUES (?, ?, ?, ?, ?, 'pending', NOW())
            ");
            $stmt->execute([$amount, $donor_name, $donor_email, $anonymous, $intent->id]);
            
            // Return client secret for frontend
            echo json_encode(['client_secret' => $intent->client_secret]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Payment processing error']);
        }
        
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid donation data']);
    }
    
} else {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid request']);
}
?>
```

### Payment Webhook Handler
```php
<?php
// api/payment-webhook.php
require_once '../includes/config.php';

// Stripe webhook endpoint
$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$endpoint_secret = 'whsec_your_webhook_secret';

try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
    
    switch ($event['type']) {
        case 'payment_intent.succeeded':
            $payment_intent = $event['data']['object'];
            
            // Update donation status in database
            $stmt = $pdo->prepare("UPDATE donations SET status = 'completed' WHERE stripe_intent_id = ?");
            $stmt->execute([$payment_intent['id']]);
            
            // Send thank you email
            $metadata = $payment_intent['metadata'];
            sendThankYouEmail($metadata['donor_email'], $metadata['donor_name'], $payment_intent['amount'] / 100);
            
            break;
        case 'payment_intent.payment_failed':
            $payment_intent = $event['data']['object'];
            
            // Update donation status
            $stmt = $pdo->prepare("UPDATE donations SET status = 'failed' WHERE stripe_intent_id = ?");
            $stmt->execute([$payment_intent['id']]);
            
            break;
    }
    
    http_response_code(200);
    
} catch(Exception $e) {
    http_response_code(400);
    exit();
}
?>
```

## Security Best Practices

### Form Security
```php
<?php
// includes/validation.php

function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : false;
}

function rateLimitCheck($action, $limit = 5, $window = 300) {
    $key = $action . '_' . $_SERVER['REMOTE_ADDR'];
    $attempts = $_SESSION[$key] ?? ['count' => 0, 'time' => time()];
    
    if (time() - $attempts['time'] > $window) {
        $attempts = ['count' => 1, 'time' => time()];
    } else {
        $attempts['count']++;
    }
    
    $_SESSION[$key] = $attempts;
    
    return $attempts['count'] <= $limit;
}
?>
```

## Development vs Production

### Environment-Specific Handling
```php
<?php
// includes/functions.php

function isDevelopment() {
    return ENVIRONMENT === 'development';
}

function getAssetUrl($asset) {
    $version = isDevelopment() ? time() : '1.0.0'; // Cache busting
    return SITE_URL . '/' . $asset . '?v=' . $version;
}

function debugLog($message) {
    if (isDevelopment()) {
        error_log("[DEBUG] " . $message);
    }
}

function sendEmail($to, $subject, $body) {
    if (isDevelopment()) {
        // In development, just log emails instead of sending
        error_log("EMAIL TO: $to\nSUBJECT: $subject\nBODY: $body");
        return true;
    } else {
        // Production email sending
        return mail($to, $subject, $body, "From: " . ADMIN_EMAIL);
    }
}
?>
```

## Key Benefits of This Architecture

1. **Componentization**: Reusable header, footer, navigation
2. **Maintainability**: Change one file, updates everywhere
3. **Security**: Server-side validation, CSRF protection, input sanitization
4. **SEO**: Dynamic meta tags, clean URLs, proper structure
5. **Performance**: Caching, compression, optimized assets
6. **Scalability**: Easy to add new pages, features, and functionality
7. **Professional**: Handles payments, forms, user management properly

## Hosting Considerations

- **Shared Hosting Friendly**: Works perfectly on Hostinger, cPanel, etc.
- **No Build Process**: Just upload and it works
- **PHP Version**: Ensure PHP 7.4+ for modern features
- **Database**: MySQL/MariaDB typically included
- **SSL**: Essential for payment processing and SEO

This doctrine ensures your website is professional, secure, maintainable, and ready for real-world use including payment processing and user interactions.