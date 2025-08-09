<?php
// includes/functions.php

// Prevent direct access
if (!defined('ALLOW_ACCESS')) {
    die('Direct access not permitted.');
}

/**
 * Environment and Development Functions
 */
function isDevelopment() {
    return ENVIRONMENT === 'development';
}

function getAssetUrl($asset) {
    $version = isDevelopment() ? time() : '1.0.0'; // Cache busting
    return SITE_URL . '/' . ltrim($asset, '/') . '?v=' . $version;
}

function debugLog($message) {
    if (isDevelopment()) {
        error_log("[DEBUG] " . $message);
    }
}

/**
 * Security Functions
 */
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
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : false;
}

function validatePhone($phone) {
    // Remove all non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    // Check if it's a valid length (10-15 digits)
    return (strlen($phone) >= 10 && strlen($phone) <= 15) ? $phone : false;
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

/**
 * Database Helper Functions
 */
function dbQuery($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        debugLog("Database error: " . $e->getMessage());
        if (isDevelopment()) {
            throw $e;
        }
        return false;
    }
}

function dbFetchAll($sql, $params = []) {
    $stmt = dbQuery($sql, $params);
    return $stmt ? $stmt->fetchAll() : [];
}

function dbFetchOne($sql, $params = []) {
    $stmt = dbQuery($sql, $params);
    return $stmt ? $stmt->fetch() : false;
}

function dbInsert($table, $data) {
    $columns = implode(',', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
    
    $stmt = dbQuery($sql, $data);
    return $stmt ? $stmt->rowCount() : false;
}

/**
 * Email Functions
 */
function sendEmail($to, $subject, $body, $isHTML = true) {
    if (isDevelopment()) {
        // In development, just log emails instead of sending
        error_log("EMAIL TO: $to\nSUBJECT: $subject\nBODY: $body");
        return true;
    }
    
    // Production email sending using PHP mail() or SMTP
    $headers = [
        'From: ' . FROM_NAME . ' <' . FROM_EMAIL . '>',
        'Reply-To: ' . FROM_EMAIL,
        'X-Mailer: PHP/' . phpversion()
    ];
    
    if ($isHTML) {
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'MIME-Version: 1.0';
    }
    
    return mail($to, $subject, $body, implode("\r\n", $headers));
}

function sendWelcomeEmail($email, $name) {
    $subject = "Welcome to " . SITE_NAME;
    $body = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Welcome</title>
    </head>
    <body style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
        <h1 style='color: #2c3e50;'>Welcome to Importance Leadership, {$name}!</h1>
        <p>Thank you for joining our mission to empower young leaders across Africa and beyond.</p>
        <p>We're excited to have you as part of our community!</p>
        <p>Best regards,<br>The Importance Leadership Team</p>
    </body>
    </html>";
    
    return sendEmail($email, $subject, $body, true);
}

/**
 * File Upload Functions
 */
function uploadFile($file, $destination_folder, $allowed_types = []) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'No file uploaded or upload error'];
    }
    
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'error' => 'File too large'];
    }
    
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!empty($allowed_types) && !in_array($extension, $allowed_types)) {
        return ['success' => false, 'error' => 'File type not allowed'];
    }
    
    // Generate unique filename
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $destination = $destination_folder . '/' . $filename;
    
    if (!is_dir($destination_folder)) {
        mkdir($destination_folder, 0755, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => true, 'filename' => $filename, 'path' => $destination];
    }
    
    return ['success' => false, 'error' => 'Failed to move uploaded file'];
}

/**
 * URL and Routing Functions
 */
function redirect($url, $permanent = false) {
    $status_code = $permanent ? 301 : 302;
    
    if (!headers_sent()) {
        http_response_code($status_code);
        header('Location: ' . $url);
        exit();
    }
    
    // Fallback if headers already sent
    echo "<script>window.location.href = '{$url}';</script>";
    exit();
}

function getCurrentUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    return $protocol . $_SERVER['HTTP_HOST'];
}

/**
 * Template and Display Functions
 */
function formatDate($date, $format = 'F j, Y') {
    return date($format, strtotime($date));
}

function truncateText($text, $length = 150, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

function formatCurrency($amount, $currency = 'USD') {
    return '$' . number_format($amount, 2);
}

/**
 * Session and User Functions
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return false;
    }
    
    return dbFetchOne("SELECT * FROM users WHERE id = ?", [$_SESSION['user_id']]);
}

function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['redirect_after_login'] = getCurrentUrl();
        redirect('/admin/login');
    }
}

/**
 * Flash Messages
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash_messages'][] = ['type' => $type, 'message' => $message];
}

function getFlashMessages() {
    $messages = $_SESSION['flash_messages'] ?? [];
    unset($_SESSION['flash_messages']);
    return $messages;
}

function hasFlashMessages() {
    return !empty($_SESSION['flash_messages']);
}

/**
 * Utility Functions
 */
function generateSlug($text) {
    // Convert to lowercase and replace spaces/special chars with hyphens
    $slug = strtolower($text);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

function isValidJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function getPaginationData($total_items, $current_page = 1, $items_per_page = ITEMS_PER_PAGE) {
    $total_pages = ceil($total_items / $items_per_page);
    $offset = ($current_page - 1) * $items_per_page;
    
    return [
        'total_items' => $total_items,
        'total_pages' => $total_pages,
        'current_page' => $current_page,
        'items_per_page' => $items_per_page,
        'offset' => $offset,
        'has_prev' => $current_page > 1,
        'has_next' => $current_page < $total_pages
    ];
}

/**
 * Content Management Functions
 */
function getPageContent($page_slug) {
    return dbFetchOne("SELECT * FROM pages WHERE slug = ? AND status = 'published'", [$page_slug]);
}

function getBlogPosts($limit = 10, $offset = 0) {
    return dbFetchAll("
        SELECT * FROM blog_posts 
        WHERE status = 'published' 
        ORDER BY created_at DESC 
        LIMIT ? OFFSET ?
    ", [$limit, $offset]);
}

function getEvents($limit = 10, $upcoming_only = true) {
    $sql = "SELECT * FROM events WHERE status = 'published'";
    if ($upcoming_only) {
        $sql .= " AND event_date >= CURDATE()";
    }
    $sql .= " ORDER BY event_date ASC LIMIT ?";
    
    return dbFetchAll($sql, [$limit]);
}

?>