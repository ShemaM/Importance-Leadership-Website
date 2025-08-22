<?php
// includes/security.php - Basic security functions for testing

/**
 * Basic security manager class
 */
class SecurityManager {
    
    /**
     * Generate CSRF token
     * @return string
     */
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate CSRF token
     * @param string $token
     * @return bool
     */
    public static function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Sanitize input data
     * @param string $data
     * @param string $type
     * @return string
     */
    public static function sanitizeInput($data, $type = 'general') {
        $data = trim($data);
        
        switch($type) {
            case 'email':
                return filter_var($data, FILTER_SANITIZE_EMAIL);
            case 'url':
                return filter_var($data, FILTER_SANITIZE_URL);
            case 'int':
                return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
            case 'float':
                return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            default:
                return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
    }
    
    /**
     * Validate email address
     * @param string $email
     * @return bool|string
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    /**
     * Basic rate limiting (session-based for testing)
     * @param string $action
     * @param string $identifier
     * @param int $limit
     * @param int $window
     * @return bool
     */
    public static function rateLimitCheck($action, $identifier = null, $limit = 5, $window = 300) {
        // Simple implementation for testing
        return true;
    }
    
    /**
     * Log security events
     * @param string $event
     * @param string $details
     */
    public static function logSecurityEvent($event, $details = '') {
        if (ENVIRONMENT === 'development') {
            error_log("SECURITY EVENT: {$event} - {$details}");
        }
    }
}
?>