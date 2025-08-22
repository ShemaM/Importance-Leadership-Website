<?php
/**
 * Importance Leadership - Complete Admin System
 * Includes: Articles, Podcasts, Donations, Analytics, Programs, 
 *           Activity Logs, Form Submissions, Site Health, Settings
 */

// =============================================
// 1. INITIALIZATION & SECURITY
// =============================================

// Error reporting (disable in production)
define('DEBUG_MODE', 1);
error_reporting(DEBUG_MODE ? E_ALL : 0);
ini_set('display_errors', DEBUG_MODE ? '1' : '0');

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Session configuration
session_set_cookie_params([
    'lifetime' => 86400 * 7, // 1 week
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();

// Application constants
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));
define('SITE_NAME', 'Importance Leadership');
define('ITEMS_PER_PAGE', 15);
define('CSRF_TOKEN_LIFETIME', 3600); // 1 hour

// =============================================
// 2. DATABASE CONNECTION & SETUP
// =============================================

class Database {
    private $pdo;
    private static $instance = null;

    private function __construct() {
        try {
            // Configure these for your environment
            $host = 'localhost';
            $dbname = 'importanceleadership';
            $username = 'root';
            $password = 'secret'; // Change this!
            
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            
            $this->setupDatabase();
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }

    private function setupDatabase() {
        $tables = [
            // Admin users table
            "CREATE TABLE IF NOT EXISTS admin_users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                role ENUM('super_admin','admin','content_manager','event_manager') NOT NULL DEFAULT 'admin',
                status ENUM('active','inactive') DEFAULT 'active',
                last_login DATETIME DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",
            
            // Content tables
            "CREATE TABLE IF NOT EXISTS articles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL UNIQUE,
                content LONGTEXT NOT NULL,
                excerpt TEXT,
                featured_image VARCHAR(255),
                author_id INT NOT NULL,
                status ENUM('draft','published','archived') DEFAULT 'draft',
                meta_title VARCHAR(255),
                meta_description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL,
                published_at DATETIME NULL,
                FOREIGN KEY (author_id) REFERENCES admin_users(id)
            )",
            
            "CREATE TABLE IF NOT EXISTS podcasts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                audio_file VARCHAR(255) NOT NULL,
                duration VARCHAR(20),
                episode_number INT,
                featured_image VARCHAR(255),
                status ENUM('draft','published','archived') DEFAULT 'draft',
                created_by INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                published_at DATETIME NULL,
                FOREIGN KEY (created_by) REFERENCES admin_users(id)
            )",
            
            // Donations
            "CREATE TABLE IF NOT EXISTS donations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                donor_name VARCHAR(100) NOT NULL,
                donor_email VARCHAR(100) NOT NULL,
                amount DECIMAL(10,2) NOT NULL,
                currency VARCHAR(3) DEFAULT 'USD',
                payment_method VARCHAR(50) NOT NULL,
                transaction_id VARCHAR(100),
                status ENUM('pending','completed','failed') DEFAULT 'pending',
                donation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                notes TEXT
            )",
            
            // Analytics
            "CREATE TABLE IF NOT EXISTS site_analytics (
                id INT AUTO_INCREMENT PRIMARY KEY,
                visit_date DATE NOT NULL,
                country_code CHAR(2) NOT NULL,
                country_name VARCHAR(100) NOT NULL,
                page_views INT DEFAULT 1,
                unique_visitors INT DEFAULT 1,
                UNIQUE KEY (visit_date, country_code)
            )",
            
            // Programs
            "CREATE TABLE IF NOT EXISTS programs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                start_date DATE NOT NULL,
                end_date DATE,
                location VARCHAR(255),
                is_virtual BOOLEAN DEFAULT 0,
                max_participants INT,
                status ENUM('planning','active','completed','cancelled') DEFAULT 'planning',
                created_by INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL,
                FOREIGN KEY (created_by) REFERENCES admin_users(id)
            )",
            
            // Activity logs
            "CREATE TABLE IF NOT EXISTS activity_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NULL,
                user_type ENUM('admin','member','guest') NULL,
                action VARCHAR(100) NOT NULL,
                details TEXT,
                ip_address VARCHAR(45),
                user_agent TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX (action),
                INDEX (created_at)
            )",
            
            // Form submissions
            "CREATE TABLE IF NOT EXISTS form_submissions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                form_type VARCHAR(50) NOT NULL,
                form_data JSON NOT NULL,
                ip_address VARCHAR(45),
                user_agent TEXT,
                status ENUM('unread','read','archived') DEFAULT 'unread',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL,
                INDEX (form_type),
                INDEX (status)
            )",
            
            // Site settings
            "CREATE TABLE IF NOT EXISTS site_settings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                setting_key VARCHAR(100) NOT NULL UNIQUE,
                setting_value TEXT,
                setting_group VARCHAR(50),
                is_public BOOLEAN DEFAULT 0,
                updated_at TIMESTAMP NULL,
                updated_by INT NULL,
                FOREIGN KEY (updated_by) REFERENCES admin_users(id)
            )",
            
            // Members/users table
            "CREATE TABLE IF NOT EXISTS members (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                status ENUM('active','inactive','suspended') DEFAULT 'active',
                last_login DATETIME NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL
            )",
            
            // Scheduled tasks
            "CREATE TABLE IF NOT EXISTS scheduled_tasks (
                id INT AUTO_INCREMENT PRIMARY KEY,
                task_name VARCHAR(100) NOT NULL,
                task_description TEXT,
                last_run DATETIME NULL,
                next_run DATETIME NULL,
                frequency VARCHAR(50) NOT NULL,
                is_active BOOLEAN DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL
            )",
            
            // Rate limiting
            "CREATE TABLE IF NOT EXISTS rate_limits (
                id INT AUTO_INCREMENT PRIMARY KEY,
                identifier VARCHAR(100) NOT NULL,
                timestamp INT NOT NULL,
                INDEX (identifier),
                INDEX (timestamp)
            )"
        ];

        foreach ($tables as $table) {
            $this->pdo->exec($table);
        }

        // (Removed: Create default admin if none exists)
        $adminCount = $this->pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
        if ($adminCount == 0) {
            $stmt = $this->pdo->prepare("
                INSERT INTO admin_users 
                (username, email, password_hash, role) 
                VALUES (?, ?, ?, 'super_admin')
            ");
            $stmt->execute([
                'admin',
                'admin@importanceleadership.com',
                password_hash('secret', PASSWORD_DEFAULT) // Change this!
            ]);
        }
        
        // Create default scheduled tasks
        $taskCount = $this->pdo->query("SELECT COUNT(*) FROM scheduled_tasks")->fetchColumn();
        if ($taskCount == 0) {
            $defaultTasks = [
                [
                    'task_name' => 'cleanup_old_logs',
                    'task_description' => 'Cleanup activity logs older than 30 days',
                    'frequency' => 'weekly'
                ],
                [
                    'task_name' => 'backup_database',
                    'task_description' => 'Create database backup',
                    'frequency' => 'daily'
                ]
            ];
            
            foreach ($defaultTasks as $task) {
                $this->pdo->prepare("
                    INSERT INTO scheduled_tasks 
                    (task_name, task_description, frequency)
                    VALUES (?, ?, ?)
                ")->execute([$task['task_name'], $task['task_description'], $task['frequency']]);
            }
        }
    }
}

$pdo = Database::getInstance();

// =============================================
// 3. AUTHENTICATION SYSTEM
// =============================================

class Auth {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function login($username, $password) {
        $stmt = $this->pdo->prepare("
            SELECT id, username, password_hash, role 
            FROM admin_users 
            WHERE username = ? AND status = 'active'
        ");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];
            $_SESSION['admin_last_active'] = time();
            
            // Update last login
            $this->pdo->prepare("
                UPDATE admin_users SET last_login = NOW() WHERE id = ?
            ")->execute([$user['id']]);
            
            return true;
        }
        return false;
    }
    
    public function logout() {
        session_unset();
        session_destroy();
    }
    
    public function isAuthenticated() {
        return isset($_SESSION['admin_id'], $_SESSION['admin_last_active']) && 
               $_SESSION['admin_last_active'] > time() - 3600;
    }
    
    public function requireAuth() {
        if (!$this->isAuthenticated()) {
            header("Location: " . BASE_URL . "?login");
            exit();
        }
    }
    
    public function requireRole($role) {
        $this->requireAuth();
        if ($_SESSION['admin_role'] !== $role) {
            header("HTTP/1.1 403 Forbidden");
            exit("Access denied");
        }
    }
    
    public function generateCSRFToken() {
        if (empty($_SESSION['csrf_token']) || time() - ($_SESSION['csrf_token_time'] ?? 0) > CSRF_TOKEN_LIFETIME) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['csrf_token_time'] = time();
        }
        return $_SESSION['csrf_token'];
    }
    
    public function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && 
               hash_equals($_SESSION['csrf_token'], $token);
    }
}

$auth = new Auth($pdo);

// =============================================
// 4. MANAGER CLASSES FOR ALL FEATURES
// =============================================

class ArticleManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function createArticle($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO articles 
            (title, slug, content, excerpt, featured_image, author_id, status, meta_title, meta_description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['excerpt'] ?? '',
            $data['featured_image'] ?? '',
            $_SESSION['admin_id'],
            $data['status'] ?? 'draft',
            $data['meta_title'] ?? '',
            $data['meta_description'] ?? ''
        ]);
        return $this->pdo->lastInsertId();
    }
    
    public function getArticles($limit = 10) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, u.username as author 
            FROM articles a
            JOIN admin_users u ON a.author_id = u.id
            ORDER BY a.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}

class PodcastManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function createPodcast($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO podcasts 
            (title, description, audio_file, duration, episode_number, featured_image, status, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['audio_file'],
            $data['duration'] ?? '00:00',
            $data['episode_number'] ?? null,
            $data['featured_image'] ?? '',
            $data['status'] ?? 'draft',
            $_SESSION['admin_id']
        ]);
        return $this->pdo->lastInsertId();
    }
    
    public function getPodcasts($limit = 10) {
        $stmt = $this->pdo->prepare("
            SELECT p.*, u.username as author 
            FROM podcasts p
            JOIN admin_users u ON p.created_by = u.id
            ORDER BY p.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}

class DonationManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function recordDonation($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO donations 
            (donor_name, donor_email, amount, currency, payment_method, transaction_id, status, notes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['donor_name'],
            $data['donor_email'],
            $data['amount'],
            $data['currency'] ?? 'USD',
            $data['payment_method'],
            $data['transaction_id'] ?? null,
            $data['status'] ?? 'completed',
            $data['notes'] ?? ''
        ]);
        return $this->pdo->lastInsertId();
    }
    
    public function getDonations($limit = 10) {
        $stmt = $this->pdo->query("
            SELECT * FROM donations 
            ORDER BY donation_date DESC
            LIMIT $limit
        ");
        return $stmt->fetchAll();
    }
    
    public function getDonationStats() {
        $stats = [];
        
        // Total donations
        $stmt = $this->pdo->query("SELECT SUM(amount) as total FROM donations WHERE status = 'completed'");
        $stats['total'] = $stmt->fetchColumn() ?? 0;
        
        // Monthly donations
        $stmt = $this->pdo->query("
            SELECT DATE_FORMAT(donation_date, '%Y-%m') as month, 
                   SUM(amount) as total
            FROM donations
            WHERE status = 'completed'
            GROUP BY month
            ORDER BY month DESC
            LIMIT 6
        ");
        $stats['monthly'] = $stmt->fetchAll();
        
        return $stats;
    }
}

class AnalyticsManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getCountryStats() {
        $stmt = $this->pdo->query("
            SELECT country_code, country_name, 
                   SUM(page_views) as page_views,
                   SUM(unique_visitors) as unique_visitors
            FROM site_analytics
            GROUP BY country_code, country_name
            ORDER BY page_views DESC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }
    
    public function getTrafficTrends() {
        $stmt = $this->pdo->query("
            SELECT visit_date, 
                   SUM(page_views) as page_views,
                   SUM(unique_visitors) as unique_visitors
            FROM site_analytics
            GROUP BY visit_date
            ORDER BY visit_date DESC
            LIMIT 30
        ");
        return $stmt->fetchAll();
    }
}

class ProgramManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function createProgram($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO programs 
            (name, description, start_date, end_date, location, is_virtual, max_participants, status, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['name'],
            $data['description'],
            $data['start_date'],
            $data['end_date'] ?? null,
            $data['location'] ?? '',
            $data['is_virtual'] ?? 0,
            $data['max_participants'] ?? null,
            $data['status'] ?? 'planning',
            $_SESSION['admin_id']
        ]);
        return $this->pdo->lastInsertId();
    }
    
    public function getPrograms($limit = 10) {
        $stmt = $this->pdo->prepare("
            SELECT p.*, u.username as creator 
            FROM programs p
            JOIN admin_users u ON p.created_by = u.id
            ORDER BY p.start_date DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}

class ActivityLogger {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function logActivity($action, $details = null, $userId = null, $userType = null) {
        $stmt = $this->pdo->prepare("
            INSERT INTO activity_logs 
            (user_id, user_type, action, details, ip_address, user_agent)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $userId,
            $userType,
            $action,
            $details,
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);
    }
    
    public function getRecentActivities($limit = 50) {
        $stmt = $this->pdo->prepare("
            SELECT l.*, 
                   COALESCE(a.username, m.email, 'Guest') as user_identifier
            FROM activity_logs l
            LEFT JOIN admin_users a ON l.user_id = a.id AND l.user_type = 'admin'
            LEFT JOIN members m ON l.user_id = m.id AND l.user_type = 'member'
            ORDER BY l.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}

class FormSubmissionManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function recordSubmission($formType, $formData) {
        $stmt = $this->pdo->prepare("
            INSERT INTO form_submissions 
            (form_type, form_data, ip_address, user_agent)
            VALUES (?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $formType,
            json_encode($formData),
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);
        
        return $this->pdo->lastInsertId();
    }
    
    public function getSubmissions($formType = null, $status = null, $limit = 50) {
        $where = [];
        $params = [];
        
        if ($formType) {
            $where[] = "form_type = ?";
            $params[] = $formType;
        }
        
        if ($status) {
            $where[] = "status = ?";
            $params[] = $status;
        }
        
        $query = "SELECT * FROM form_submissions";
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        $query .= " ORDER BY created_at DESC LIMIT ?";
        $params[] = $limit;
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function updateSubmissionStatus($id, $status) {
        $stmt = $this->pdo->prepare("
            UPDATE form_submissions 
            SET status = ?, updated_at = NOW()
            WHERE id = ?
        ");
        return $stmt->execute([$status, $id]);
    }
}

class SiteHealthMonitor {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function checkSystemHealth() {
        $health = [];
        
        // Database connection check
        try {
            $this->pdo->query("SELECT 1");
            $health['database'] = [
                'status' => 'ok',
                'message' => 'Database connection is working'
            ];
        } catch (PDOException $e) {
            $health['database'] = [
                'status' => 'error',
                'message' => 'Database connection failed: ' . $e->getMessage()
            ];
        }
        
        // Disk space check
        $freeSpace = disk_free_space(__DIR__);
        $totalSpace = disk_total_space(__DIR__);
        $percentFree = ($freeSpace / $totalSpace) * 100;
        
        $health['disk_space'] = [
            'status' => $percentFree > 10 ? 'ok' : ($percentFree > 5 ? 'warning' : 'error'),
            'message' => sprintf('%.1f%% free space (%.1f GB of %.1f GB)', 
                $percentFree, 
                $freeSpace / (1024 * 1024 * 1024),
                $totalSpace / (1024 * 1024 * 1024))
        ];
        
        // PHP version check
        $phpVersion = phpversion();
        $health['php_version'] = [
            'status' => version_compare($phpVersion, '8.0.0') >= 0 ? 'ok' : 'warning',
            'message' => "PHP $phpVersion"
        ];
        
        // PHP extensions check
        $requiredExtensions = ['pdo', 'pdo_mysql', 'gd', 'mbstring', 'json'];
        $health['extensions'] = [
            'status' => 'ok',
            'message' => 'All required extensions loaded',
            'details' => []
        ];
        
        foreach ($requiredExtensions as $ext) {
            $loaded = extension_loaded($ext);
            $health['extensions']['details'][$ext] = $loaded ? 'ok' : 'missing';
            if (!$loaded) {
                $health['extensions']['status'] = 'error';
                $health['extensions']['message'] = 'Some required extensions are missing';
            }
        }
        
        // Recent errors check
        try {
            $errorCount = $this->pdo->query("
                SELECT COUNT(*) FROM activity_logs 
                WHERE action = 'error' 
                AND created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)
            ")->fetchColumn();
            
            $health['recent_errors'] = [
                'status' => $errorCount > 10 ? 'warning' : ($errorCount > 50 ? 'error' : 'ok'),
                'message' => "$errorCount errors in last 24 hours"
            ];
        } catch (Exception $e) {
            $health['recent_errors'] = [
                'status' => 'error',
                'message' => 'Could not check recent errors'
            ];
        }
        
        return $health;
    }
}

class SiteSettingsManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getSetting($key, $default = null) {
        $stmt = $this->pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetchColumn();
        return $result !== false ? $result : $default;
    }
    
    public function setSetting($key, $value, $group = null, $isPublic = false, $userId = null) {
        $stmt = $this->pdo->prepare("
            INSERT INTO site_settings 
            (setting_key, setting_value, setting_group, is_public, updated_by, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE 
            setting_value = VALUES(setting_value),
            setting_group = VALUES(setting_group),
            is_public = VALUES(is_public),
            updated_by = VALUES(updated_by),
            updated_at = NOW()
        ");
        
        return $stmt->execute([$key, $value, $group, $isPublic ? 1 : 0, $userId]);
    }
    
    public function getAllSettings($group = null) {
        $query = "SELECT * FROM site_settings";
        $params = [];
        
        if ($group) {
            $query .= " WHERE setting_group = ?";
            $params[] = $group;
        }
        
        $query .= " ORDER BY setting_group, setting_key";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}

class TaskRunner {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function runScheduledTasks() {
        $tasks = $this->pdo->query("
            SELECT * FROM scheduled_tasks 
            WHERE is_active = 1 
            AND (next_run IS NULL OR next_run <= NOW())
        ")->fetchAll();
        
        foreach ($tasks as $task) {
            try {
                $this->runTask($task);
                $this->updateTaskSchedule($task);
            } catch (Exception $e) {
                $this->logTaskError($task, $e);
            }
        }
    }
    
    private function runTask($task) {
        switch ($task['task_name']) {
            case 'cleanup_old_logs':
                $days = 30;
                $this->pdo->prepare("
                    DELETE FROM activity_logs 
                    WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)
                ")->execute([$days]);
                break;
                
            case 'backup_database':
                // Implement database backup logic
                break;
                
            // Add more tasks as needed
        }
    }
    
    private function updateTaskSchedule($task) {
        $nextRun = null;
        
        switch ($task['frequency']) {
            case 'daily':
                $nextRun = date('Y-m-d H:i:s', strtotime('+1 day'));
                break;
            case 'weekly':
                $nextRun = date('Y-m-d H:i:s', strtotime('+1 week'));
                break;
            case 'monthly':
                $nextRun = date('Y-m-d H:i:s', strtotime('+1 month'));
                break;
        }
        
        $this->pdo->prepare("
            UPDATE scheduled_tasks 
            SET last_run = NOW(), 
                next_run = ?
            WHERE id = ?
        ")->execute([$nextRun, $task['id']]);
    }
    
    private function logTaskError($task, $exception) {
        $this->pdo->prepare("
            INSERT INTO activity_logs 
            (action, details, created_at)
            VALUES (?, ?, NOW())
        ")->execute([
            'task_error',
            "Task {$task['task_name']} failed: " . $exception->getMessage()
        ]);
    }
}

class RateLimiter {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function checkRateLimit($key, $limit, $windowSeconds) {
        $now = time();
        $windowStart = $now - $windowSeconds;
        
        // Clean up old entries
        $this->pdo->prepare("
            DELETE FROM rate_limits 
            WHERE timestamp < ?
        ")->execute([$windowStart]);
        
        // Count recent attempts
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM rate_limits 
            WHERE identifier = ? AND timestamp >= ?
        ");
        $stmt->execute([$key, $windowStart]);
        $count = $stmt->fetchColumn();
        
        if ($count >= $limit) {
            return false;
        }
        
        // Record this attempt
        $this->pdo->prepare("
            INSERT INTO rate_limits (identifier, timestamp)
            VALUES (?, ?)
        ")->execute([$key, $now]);
        
        return true;
    }
}

// Initialize all managers
$articleManager = new ArticleManager($pdo);
$podcastManager = new PodcastManager($pdo);
$donationManager = new DonationManager($pdo);
$analyticsManager = new AnalyticsManager($pdo);
$programManager = new ProgramManager($pdo);
$activityLogger = new ActivityLogger($pdo);
$formSubmissionManager = new FormSubmissionManager($pdo);
$siteHealthMonitor = new SiteHealthMonitor($pdo);
$siteSettingsManager = new SiteSettingsManager($pdo);
$taskRunner = new TaskRunner($pdo);
$rateLimiter = new RateLimiter($pdo);

// Log admin activities
if ($auth->isAuthenticated()) {
    $activityLogger->logActivity(
        'admin_access',
        'Accessed ' . ($_SERVER['REQUEST_URI'] ?? ''),
        $_SESSION['admin_id'],
        'admin'
    );
}

// Error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) use ($activityLogger) {
    if (!(error_reporting() & $errno)) {
        return false;
    }
    
    $errorTypes = [
        E_ERROR => 'Error',
        E_WARNING => 'Warning',
        E_PARSE => 'Parse Error',
        E_NOTICE => 'Notice',
        E_CORE_ERROR => 'Core Error',
        E_CORE_WARNING => 'Core Warning',
        E_COMPILE_ERROR => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR => 'User Error',
        E_USER_WARNING => 'User Warning',
        E_USER_NOTICE => 'User Notice',
        
        E_RECOVERABLE_ERROR => 'Recoverable Error',
        E_DEPRECATED => 'Deprecated',
        E_USER_DEPRECATED => 'User Deprecated'
    ];
    
    $errorType = $errorTypes[$errno] ?? 'Unknown Error';
    
    $activityLogger->logActivity(
        'error',
        "$errorType: $errstr in $errfile on line $errline",
        $_SESSION['admin_id'] ?? null,
        isset($_SESSION['admin_id']) ? 'admin' : null
    );
    
    // Let PHP handle the error normally if in debug mode
    return DEBUG_MODE ? false : true;
});

// Exception handler
set_exception_handler(function($exception) use ($activityLogger) {
    $activityLogger->logActivity(
        'exception',
        "Uncaught Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine(),
        $_SESSION['admin_id'] ?? null,
        isset($_SESSION['admin_id']) ? 'admin' : null
    );
    
    if (DEBUG_MODE) {
        echo "<div class='alert alert-danger'>";
        echo "<h4>Uncaught Exception</h4>";
        echo "<p>" . htmlspecialchars($exception->getMessage()) . "</p>";
        echo "<pre>" . htmlspecialchars($exception->getTraceAsString()) . "</pre>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger'> An unexpected error occurred. The team has been notified.</div>";
        exit;
    }
    exit;
});

// =============================================
// 5. REQUEST HANDLING
// =============================================

// Handle logout
if (isset($_GET['logout'])) {
    $auth->logout();
    header("Location: " . BASE_URL);
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!$auth->validateCSRFToken($csrfToken)) {
        $loginError = "CSRF token validation failed";
    } else {
        $loginKey = 'login_' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
        if (!$rateLimiter->checkRateLimit($loginKey, 5, 300)) {
            $loginError = "Too many login attempts. Please try again later.";
            $activityLogger->logActivity('rate_limit', "Login rate limit exceeded for IP " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
        } elseif ($auth->login($_POST['username'], $_POST['password'])) {
            header("Location: " . BASE_URL);
            exit();
        } else {
            $loginError = "Invalid username or password";
        }
    }
}

// Handle API requests
if (isset($_GET['api'])) {
    header('Content-Type: application/json');
    
    try {
        switch ($_GET['api']) {
            case 'get_submission':
                if (!$auth->isAuthenticated()) {
                    throw new Exception("Unauthorized");
                }
                
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    throw new Exception("Missing submission ID");
                }
                
                $stmt = $pdo->prepare("
                    SELECT * FROM form_submissions WHERE id = ?
                ");
                $stmt->execute([$id]);
                $submission = $stmt->fetch();
                
                if (!$submission) {
                    throw new Exception("Submission not found");
                }
                
                echo json_encode([
                    'success' => true,
                    'data' => $submission
                ]);
                break;
                
            case 'mark_read':
                if (!$auth->isAuthenticated()) {
                    throw new Exception("Unauthorized");
                }
                
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    throw new Exception("Missing submission ID");
                }
                
                $formSubmissionManager->updateSubmissionStatus($id, 'read');
                
                echo json_encode([
                    'success' => true
                ]);
                break;
                
            default:
                throw new Exception("Unknown API endpoint");
        }
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    
    exit();
}

// Handle other form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $auth->isAuthenticated()) {
    $csrfToken = $_POST['csrf_token'] ?? '';
    
    if (!$auth->validateCSRFToken($csrfToken)) {
        die("CSRF token validation failed");
    }
    
    // Handle article creation
    if (isset($_POST['create_article'])) {
        try {
            $articleManager->createArticle([
                'title' => $_POST['title'],
                'slug' => $_POST['slug'],
                'content' => $_POST['content'],
                'excerpt' => $_POST['excerpt'],
                'status' => $_POST['status'],
                'meta_title' => $_POST['meta_title'],
                'meta_description' => $_POST['meta_description']
            ]);
            $successMessage = "Article created successfully!";
        } catch (PDOException $e) {
            $errorMessage = "Error creating article: " . $e->getMessage();
        }
    }
    
    // Handle podcast creation
    if (isset($_POST['create_podcast'])) {
        try {
            $podcastManager->createPodcast([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'audio_file' => $_POST['audio_file'],
                'duration' => $_POST['duration'],
                'episode_number' => $_POST['episode_number'],
                'status' => $_POST['status']
            ]);
            $successMessage = "Podcast created successfully!";
        } catch (PDOException $e) {
            $errorMessage = "Error creating podcast: " . $e->getMessage();
        }
    }
    
    // Handle program creation
    if (isset($_POST['create_program'])) {
        try {
            $programManager->createProgram([
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'location' => $_POST['location'],
                'is_virtual' => isset($_POST['is_virtual']) ? 1 : 0,
                'max_participants' => $_POST['max_participants'],
                'status' => $_POST['status']
            ]);
            $successMessage = "Program created successfully!";
        } catch (PDOException $e) {
            $errorMessage = "Error creating program: " . $e->getMessage();
        }
    }
    
    // Handle site settings update
    if (isset($_POST['save_settings'])) {
        try {
            foreach ($_POST['settings'] as $key => $value) {
                $siteSettingsManager->setSetting(
                    $key,
                    $value,
                    $_POST['setting_groups'][$key] ?? null,
                    isset($_POST['is_public'][$key]),
                    $_SESSION['admin_id']
                );
            }
            
            // Handle new setting if provided
            if (!empty($_POST['new_setting_key'])) {
                $siteSettingsManager->setSetting(
                    $_POST['new_setting_key'],
                    $_POST['new_setting_value'],
                    $_POST['new_setting_group'] ?? null,
                    isset($_POST['new_setting_public']),
                    $_SESSION['admin_id']
                );
            }
            
            $successMessage = "Settings updated successfully!";
        } catch (PDOException $e) {
            $errorMessage = "Error updating settings: " . $e->getMessage();
        }
    }
}

// Run scheduled tasks if this is a cron request
if (isset($_GET['run_tasks'])) {
    $taskRunner->runScheduledTasks();
    exit("Tasks executed");
}

// Generate CSRF token
$csrfToken = $auth->generateCSRFToken();

// =============================================
// 6. HTML OUTPUT
// =============================================
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(SITE_NAME) ?> Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css">
    <style>
        :root {
            --primary: #3498db;
            --secondary: #2c3e50;
            --success: #2ecc71;
            --info: #17a2b8;
            --warning: #f39c12;
            --danger: #e74c3c;
            --light: #f8f9fa;
            --dark: #343a40;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: var(--secondary);
            color: white;
            position: fixed;
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .main-content {
            margin-left: 280px;
            transition: all 0.3s;
            min-height: 100vh;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 2px 0;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.15);
            text-decoration: none;
        }
        
        .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 10px;
        }
        
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            height: 100%;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .stat-card .value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
        }
        
        .stat-card .label {
            font-size: 0.9rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            margin-bottom: 24px;
        }
        
        .card-header {
            background: var(--primary);
            color: white;
            border-radius: 8px 8px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                margin-left: -280px;
            }
            .sidebar.active {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
        
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1050;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
        }
        
        @media (max-width: 992px) {
            .sidebar-toggle {
                display: block;
            }
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            background: #f8f9fa;
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            color: #6c757d;
        }
        
        .badge {
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        
        .badge-primary { background: var(--primary); }
        .badge-secondary { background: var(--secondary); }
        .badge-success { background: var(--success); }
        .badge-info { background: var(--info); }
        .badge-warning { background: var(--warning); }
        .badge-danger { background: var(--danger); }
        
        .form-control, .form-select {
            border-radius: 4px;
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
        }
        
        .btn {
            border-radius: 4px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background: #2980b9;
            border-color: #2980b9;
        }
        
        .country-flag {
            width: 20px;
            height: 15px;
            margin-right: 8px;
            border-radius: 2px;
        }
        
        .health-status.ok {
            color: var(--success);
        }
        .health-status.warning {
            color: var(--warning);
        }
        .health-status.error {
            color: var(--danger);
        }
    </style>
</head>
<body>
    <!-- Sidebar Toggle Button (Mobile) -->
    <button class="sidebar-toggle btn btn-primary" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <?php if (!$auth->isAuthenticated()): ?>
        <!-- Login Page -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-lg">
                        <div class="card-header text-center py-4">
                            <h2 class="mb-0">
                                <i class="fas fa-lock me-2"></i> Admin Login
                            </h2>
                        </div>
                        <div class="card-body p-4">
                            <?php if (isset($loginError)): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <?= $loginError ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="?login">
                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                
                                <div class="mb-4">
                                    <label class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                </div>
                                
                                <button type="submit" name="login" class="btn btn-primary w-100 py-2">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Admin Dashboard -->
        <div class="d-flex">
            <!-- Sidebar -->
            <div class="sidebar p-3" id="sidebar">
                <div class="text-center mb-4">
                    <h3 class="mb-1"><?= htmlspecialchars(SITE_NAME) ?></h3>
                    <small class="text-muted">Admin Dashboard</small>
                </div>
                
                <ul class="nav flex-column mb-4">
                    <li class="nav-item">
                        <a href="?" class="nav-link <?= empty($_GET['page']) ? 'active' : '' ?>">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    
                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">CONTENT</small>
                    </li>
                    
                    <li class="nav-item">
                        <a href="?page=articles" class="nav-link <?= ($_GET['page'] ?? '') === 'articles' ? 'active' : '' ?>">
                            <i class="fas fa-newspaper"></i> Articles
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="?page=podcasts" class="nav-link <?= ($_GET['page'] ?? '') === 'podcasts' ? 'active' : '' ?>">
                            <i class="fas fa-podcast"></i> Podcasts
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="?page=programs" class="nav-link <?= ($_GET['page'] ?? '') === 'programs' ? 'active' : '' ?>">
                            <i class="fas fa-project-diagram"></i> Programs
                        </a>
                    </li>
                    
                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">FINANCE</small>
                    </li>
                    
                    <li class="nav-item">
                        <a href="?page=donations" class="nav-link <?= ($_GET['page'] ?? '') === 'donations' ? 'active' : '' ?>">
                            <i class="fas fa-donate"></i> Donations
                        </a>
                    </li>
                    
                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">ANALYTICS</small>
                    </li>
                    
                    <li class="nav-item">
                        <a href="?page=analytics" class="nav-link <?= ($_GET['page'] ?? '') === 'analytics' ? 'active' : '' ?>">
                            <i class="fas fa-chart-line"></i> Site Analytics
                        </a>
                    </li>
                    
                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">SYSTEM</small>
                    </li>
                    
                    <li class="nav-item">
                        <a href="?page=activities" class="nav-link <?= ($_GET['page'] ?? '') === 'activities' ? 'active' : '' ?>">
                            <i class="fas fa-history"></i> Activity Log
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="?page=submissions" class="nav-link <?= ($_GET['page'] ?? '') === 'submissions' ? 'active' : '' ?>">
                            <i class="fas fa-inbox"></i> Form Submissions
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="?page=site_health" class="nav-link <?= ($_GET['page'] ?? '') === 'site_health' ? 'active' : '' ?>">
                            <i class="fas fa-heartbeat"></i> Site Health
                        </a>
                    </li>
                    
                    <?php if ($_SESSION['admin_role'] === 'super_admin'): ?>
                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">ADMINISTRATION</small>
                    </li>
                    
                    <li class="nav-item">
                        <a href="?page=admins" class="nav-link <?= ($_GET['page'] ?? '') === 'admins' ? 'active' : '' ?>">
                            <i class="fas fa-users-cog"></i> Admin Users
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="?page=site_settings" class="nav-link <?= ($_GET['page'] ?? '') === 'site_settings' ? 'active' : '' ?>">
                            <i class="fas fa-cog"></i> Site Settings
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
                
                <div class="mt-auto pt-3 border-top">
                    <a href="?logout=1" class="nav-link text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="main-content" id="mainContent">
                <!-- Top Navigation -->
                <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <span class="navbar-brand mb-0">
                                <i class="fas fa-cog me-2"></i> Admin Panel
                            </span>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <a href="#" class="text-white dropdown-toggle d-flex align-items-center text-decoration-none" 
                                   id="userDropdown" data-bs-toggle="dropdown">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['admin_username']) ?>&background=random" 
                                         alt="User" class="rounded-circle me-2" width="32" height="32">
                                    <span><?= htmlspecialchars($_SESSION['admin_username']) ?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-user me-2"></i> Profile
                                    </a></li>
                                    <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-cog me-2"></i> Settings
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="?logout=1">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                
                <!-- Page Content -->
                <div class="container-fluid p-4">
                    <?php if (isset($successMessage)): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= $successMessage ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($errorMessage)): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $errorMessage ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php
                    $page = $_GET['page'] ?? '';
                    
                    switch ($page) {
                        case 'articles':
                            ?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="fas fa-newspaper me-2"></i> Articles
                                            </h5>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createArticleModal">
                                                <i class="fas fa-plus me-1"></i> New Article
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Title</th>
                                                            <th>Author</th>
                                                            <th>Status</th>
                                                            <th>Created</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($articleManager->getArticles(ITEMS_PER_PAGE) as $article): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($article['title']) ?></td>
                                                            <td><?= htmlspecialchars($article['author']) ?></td>
                                                            <td>
                                                                <span class="badge badge-<?= 
                                                                    $article['status'] === 'published' ? 'success' : 
                                                                    ($article['status'] === 'draft' ? 'warning' : 'secondary')
                                                                ?>">
                                                                    <?= ucfirst($article['status']) ?>
                                                                </span>
                                                            </td>
                                                            <td><?= date('M j, Y', strtotime($article['created_at'])) ?></td>
                                                            <td>
                                                                <a href="?page=edit_article&id=<?= $article['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Create Article Modal -->
                            <div class="modal fade" id="createArticleModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Create New Article</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <label class="form-label">Title</label>
                                                        <input type="text" name="title" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">URL Slug</label>
                                                        <input type="text" name="slug" class="form-control" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Excerpt</label>
                                                    <textarea name="excerpt" class="form-control" rows="2"></textarea>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Content</label>
                                                    <textarea name="content" class="form-control" rows="8" required></textarea>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="draft">Draft</option>
                                                            <option value="published">Published</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Meta Title</label>
                                                        <input type="text" name="meta_title" class="form-control">
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Meta Description</label>
                                                    <textarea name="meta_description" class="form-control" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" name="create_article" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i> Save Article
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                            
                        case 'podcasts':
                            ?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="fas fa-podcast me-2"></i> Podcasts
                                            </h5>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createPodcastModal">
                                                <i class="fas fa-plus me-1"></i> New Podcast
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Title</th>
                                                            <th>Episode</th>
                                                            <th>Duration</th>
                                                            <th>Status</th>
                                                            <th>Created</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($podcastManager->getPodcasts(ITEMS_PER_PAGE) as $podcast): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($podcast['title']) ?></td>
                                                            <td><?= $podcast['episode_number'] ?? 'N/A' ?></td>
                                                            <td><?= $podcast['duration'] ?? '00:00' ?></td>
                                                            <td>
                                                                <span class="badge badge-<?= 
                                                                    $podcast['status'] === 'published' ? 'success' : 
                                                                    ($podcast['status'] === 'draft' ? 'warning' : 'secondary')
                                                                ?>">
                                                                    <?= ucfirst($podcast['status']) ?>
                                                                </span>
                                                            </td>
                                                            <td><?= date('M j, Y', strtotime($podcast['created_at'])) ?></td>
                                                            <td>
                                                                <a href="?page=edit_podcast&id=<?= $podcast['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Create Podcast Modal -->
                            <div class="modal fade" id="createPodcastModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Create New Podcast</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <label class="form-label">Title</label>
                                                        <input type="text" name="title" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Episode Number</label>
                                                        <input type="number" name="episode_number" class="form-control">
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea name="description" class="form-control" rows="4" required></textarea>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Audio File URL</label>
                                                        <input type="text" name="audio_file" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Duration (HH:MM)</label>
                                                        <input type="text" name="duration" class="form-control" placeholder="00:00">
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="draft">Draft</option>
                                                        <option value="published">Published</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" name="create_podcast" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i> Save Podcast
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                            
                        case 'programs':
                            ?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="fas fa-project-diagram me-2"></i> Programs
                                            </h5>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createProgramModal">
                                                <i class="fas fa-plus me-1"></i> New Program
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Start Date</th>
                                                            <th>Location</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($programManager->getPrograms(ITEMS_PER_PAGE) as $program): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($program['name']) ?></td>
                                                            <td><?= date('M j, Y', strtotime($program['start_date'])) ?></td>
                                                            <td><?= $program['is_virtual'] ? 'Virtual' : htmlspecialchars($program['location']) ?></td>
                                                            <td>
                                                                <span class="badge badge-<?= 
                                                                    $program['status'] === 'active' ? 'success' : 
                                                                    ($program['status'] === 'planning' ? 'warning' : 
                                                                    ($program['status'] === 'completed' ? 'info' : 'danger'))
                                                                ?>">
                                                                    <?= ucfirst($program['status']) ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="?page=edit_program&id=<?= $program['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Create Program Modal -->
                            <div class="modal fade" id="createProgramModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Create New Program</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <label class="form-label">Program Name</label>
                                                        <input type="text" name="name" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="planning">Planning</option>
                                                            <option value="active">Active</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea name="description" class="form-control" rows="4" required></textarea>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Start Date</label>
                                                        <input type="date" name="start_date" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">End Date</label>
                                                        <input type="date" name="end_date" class="form-control">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Max Participants</label>
                                                        <input type="number" name="max_participants" class="form-control">
                                                    </div>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Location</label>
                                                        <input type="text" name="location" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-check mt-4 pt-2">
                                                            <input class="form-check-input" type="checkbox" name="is_virtual" id="is_virtual">
                                                            <label class="form-check-label" for="is_virtual">Virtual Program</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" name="create_program" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i> Save Program
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                            
                        case 'donations':
                            $donationStats = $donationManager->getDonationStats();
                            ?>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <div class="label">Total Donations</div>
                                        <div class="value">$<?= number_format($donationStats['total'], 2) ?></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="stat-card">
                                        <div class="label">Monthly Donations</div>
                                        <canvas id="donationsChart" height="100"></canvas>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="fas fa-donate me-2"></i> Recent Donations
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Donor</th>
                                                            <th>Amount</th>
                                                            <th>Method</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($donationManager->getDonations(ITEMS_PER_PAGE) as $donation): ?>
                                                        <tr>
                                                            <td>
                                                                <?= htmlspecialchars($donation['donor_name']) ?>
                                                                <small class="text-muted d-block"><?= htmlspecialchars($donation['donor_email']) ?></small>
                                                            </td>
                                                            <td>$<?= number_format($donation['amount'], 2) ?></td>
                                                            <td><?= ucfirst($donation['payment_method']) ?></td>
                                                            <td><?= date('M j, Y', strtotime($donation['donation_date'])) ?></td>
                                                            <td>
                                                                <span class="badge badge-<?= 
                                                                    $donation['status'] === 'completed' ? 'success' : 
                                                                    ($donation['status'] === 'pending' ? 'warning' : 'danger')
                                                                ?>">
                                                                    <?= ucfirst($donation['status']) ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                            
                        case 'analytics':
                            $countryStats = $analyticsManager->getCountryStats();
                            $trafficTrends = $analyticsManager->getTrafficTrends();
                            ?>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">Top Countries</div>
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Country</th>
                                                        <th>Page Views</th>
                                                        <th>Unique Visitors</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($countryStats as $country): ?>
                                                    <tr>
                                                        <td>
                                                            <img src="https://flagcdn.com/16x12/<?= strtolower($country['country_code']) ?>.png" 
                                                                 class="country-flag" alt="<?= htmlspecialchars($country['country_name']) ?>">
                                                            <?= htmlspecialchars($country['country_name']) ?>
                                                        </td>
                                                        <td><?= number_format($country['page_views']) ?></td>
                                                        <td><?= number_format($country['unique_visitors']) ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="stat-card">
                                        <div class="label">Traffic Trends (30 days)</div>
                                        <canvas id="trafficChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                            
                        case 'activities':
                            $activities = $activityLogger->getRecentActivities(ITEMS_PER_PAGE);
                            ?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="fas fa-history me-2"></i> Activity Log
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Timestamp</th>
                                                            <th>User</th>
                                                            <th>Action</th>
                                                            <th>Details</th>
                                                            <th>IP</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($activities as $activity): ?>
                                                        <tr>
                                                            <td><?= date('M j, Y H:i', strtotime($activity['created_at'])) ?></td>
                                                            <td><?= htmlspecialchars($activity['user_identifier']) ?></td>
                                                            <td><?= htmlspecialchars($activity['action']) ?></td>
                                                            <td><?= htmlspecialchars($activity['details'] ?? '') ?></td>
                                                            <td><?= htmlspecialchars($activity['ip_address']) ?></td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                            
                        case 'submissions':
                            $submissions = $formSubmissionManager->getSubmissions($_GET['form_type'] ?? null, $_GET['status'] ?? null, ITEMS_PER_PAGE);
                            ?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="fas fa-inbox me-2"></i> Form Submissions
                                            </h5>
                                            <div class="btn-group">
                                                <a href="?page=submissions&status=unread" class="btn btn-sm btn-<?= ($_GET['status'] ?? '') === 'unread' ? 'primary' : 'outline-primary' ?>">
                                                    Unread
                                                </a>
                                                <a href="?page=submissions&status=read" class="btn btn-sm btn-<?= ($_GET['status'] ?? '') === 'read' ? 'primary' : 'outline-primary' ?>">
                                                    Read
                                                </a>
                                                <a href="?page=submissions" class="btn btn-sm btn-<?= !isset($_GET['status']) ? 'primary' : 'outline-primary' ?>">
                                                    All
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Form Type</th>
                                                            <th>Data</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($submissions as $submission): 
                                                            $formData = json_decode($submission['form_data'], true);
                                                        ?>
                                                        <tr>
                                                            <td><?= date('M j, Y H:i', strtotime($submission['created_at'])) ?></td>
                                                            <td><?= htmlspecialchars($submission['form_type']) ?></td>
                                                            <td>
                                                                <?php foreach ($formData as $key => $value): 
                                                                    if (is_array($value)) $value = implode(', ', $value);
                                                                ?>
                                                                <div><strong><?= htmlspecialchars($key) ?>:</strong> <?= htmlspecialchars($value) ?></div>
                                                                <?php endforeach; ?>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-<?= 
                                                                    $submission['status'] === 'unread' ? 'warning' : 
                                                                    ($submission['status'] === 'read' ? 'success' : 'secondary')
                                                                ?>">
                                                                    <?= ucfirst($submission['status']) ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    <?php if ($submission['status'] === 'unread'): ?>
                                                                    <a href="?page=mark_read&id=<?= $submission['id'] ?>" class="btn btn-outline-success" title="Mark as read">
                                                                        <i class="fas fa-check"></i>
                                                                    </a>
                                                                    <?php endif; ?>
                                                                    <a href="?page=view_submission&id=<?= $submission['id'] ?>" class="btn btn-outline-primary" title="View details">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                            
                        case 'site_health':
                            $health = $siteHealthMonitor->checkSystemHealth();
                            ?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="fas fa-heartbeat me-2"></i> Site Health
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Component</th>
                                                            <th>Status</th>
                                                            <th>Details</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($health as $component => $info): ?>
                                                        <tr>
                                                            <td><?= ucfirst(str_replace('_', ' ', $component)) ?></td>
                                                            <td>
                                                                <span class="badge badge-<?= $info['status'] ?>">
                                                                    <?= ucfirst($info['status']) ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="health-status <?= $info['status'] ?>">
                                                                    <i class="fas fa-<?= 
                                                                        $info['status'] === 'ok' ? 'check-circle' : 
                                                                        ($info['status'] === 'warning' ? 'exclamation-triangle' : 'times-circle')
                                                                    ?>"></i>
                                                                    <?= $info['message'] ?>
                                                                </span>
                                                                <?php if (!empty($info['details'])): ?>
                                                                    <div class="mt-2">
                                                                        <?php foreach ($info['details'] as $key => $value): ?>
                                                                            <span class="badge badge-<?= $value === 'ok' ? 'success' : 'danger' ?>">
                                                                                <?= $key ?>: <?= $value ?>
                                                                            </span>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                            
                        case 'admins':
                            if ($_SESSION['admin_role'] !== 'super_admin') {
                                echo '<div class="alert alert-danger">Access denied</div>';
                                break;
                            }
                            ?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="fas fa-users-cog me-2"></i> Admin Users
                                            </h5>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createAdminModal">
                                                <i class="fas fa-plus me-1"></i> New Admin
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Username</th>
                                                            <th>Email</th>
                                                            <th>Role</th>
                                                            <th>Last Login</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $admins = $pdo->query("
                                                            SELECT id, username, email, role, status, last_login 
                                                            FROM admin_users 
                                                            ORDER BY created_at DESC
                                                        ")->fetchAll();
                                                        
                                                        foreach ($admins as $admin): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($admin['username']) ?></td>
                                                            <td><?= htmlspecialchars($admin['email']) ?></td>
                                                            <td><?= ucfirst(str_replace('_', ' ', $admin['role'])) ?></td>
                                                            <td><?= $admin['last_login'] ? date('M j, Y H:i', strtotime($admin['last_login'])) : 'Never' ?></td>
                                                            <td>
                                                                <span class="badge badge-<?= $admin['status'] === 'active' ? 'success' : 'secondary' ?>">
                                                                    <?= ucfirst($admin['status']) ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="?page=edit_admin&id=<?= $admin['id'] ?>" class="btn btn-outline-primary">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <?php if ($admin['id'] != $_SESSION['admin_id']): ?>
                                                                    <a href="?page=toggle_admin&id=<?= $admin['id'] ?>" class="btn btn-outline-<?= $admin['status'] === 'active' ? 'danger' : 'success' ?>">
                                                                        <i class="fas fa-<?= $admin['status'] === 'active' ? 'times' : 'check' ?>"></i>
                                                                    </a>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Create Admin Modal -->
                            <div class="modal fade" id="createAdminModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Create New Admin</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" name="username" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" name="email" class="form-control" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Password</label>
                                                        <input type="password" name="password" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Role</label>
                                                        <select name="role" class="form-select" required>
                                                            <option value="admin">Administrator</option>
                                                            <option value="content_manager">Content Manager</option>
                                                            <option value="event_manager">Event Manager</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" name="create_admin" class="btn btn-primary">
                                                    <i class="fas fa-user-plus me-1"></i> Create Admin
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                            
                        case 'site_settings':
                            if ($_SESSION['admin_role'] !== 'super_admin') {
                                echo '<div class="alert alert-danger">Access denied</div>';
                                break;
                            }
                            
                            $settings = $siteSettingsManager->getAllSettings();
                            $settingsByGroup = [];
                            
                            foreach ($settings as $setting) {
                                $group = $setting['setting_group'] ?? 'general';
                                if (!isset($settingsByGroup[$group])) {
                                    $settingsByGroup[$group] = [];
                                }
                                $settingsByGroup[$group][] = $setting;
                            }
                            ?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="fas fa-cog me-2"></i> Site Settings
                                            </h5>
                                        </div>
                                        <form method="POST">
                                            <div class="card-body">
                                                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                                
                                                <?php foreach ($settingsByGroup as $group => $groupSettings): ?>
                                                <div class="mb-4">
                                                    <h5 class="mb-3 border-bottom pb-2"><?= ucfirst($group) ?></h5>
                                                    
                                                    <?php foreach ($groupSettings as $setting): ?>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label"><?= ucfirst(str_replace('_', ' ', $setting['setting_key'])) ?></label>
                                                            <input type="hidden" name="setting_groups[<?= $setting['setting_key'] ?>]" value="<?= $group ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="settings[<?= $setting['setting_key'] ?>]" 
                                                                   class="form-control" value="<?= htmlspecialchars($setting['setting_value']) ?>">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-check form-switch pt-2">
                                                                <input class="form-check-input" type="checkbox" name="is_public[<?= $setting['setting_key'] ?>]" 
                                                                       id="public_<?= $setting['setting_key'] ?>" <?= $setting['is_public'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="public_<?= $setting['setting_key'] ?>">Public</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <?php endforeach; ?>
                                                
                                                <div class="mb-3">
                                                    <h5 class="mb-3 border-bottom pb-2">Add New Setting</h5>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <input type="text" name="new_setting_key" class="form-control" placeholder="Setting key">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" name="new_setting_group" class="form-control" placeholder="Group">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" name="new_setting_value" class="form-control" placeholder="Value">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-check form-switch pt-2">
                                                                <input class="form-check-input" type="checkbox" name="new_setting_public" id="new_setting_public">
                                                                <label class="form-check-label" for="new_setting_public">Public</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" name="save_settings" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i> Save All Settings
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                            
                        default: // Dashboard
                            $totalArticles = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
                            $totalPodcasts = $pdo->query("SELECT COUNT(*) FROM podcasts")->fetchColumn();
                            $totalPrograms = $pdo->query("SELECT COUNT(*) FROM programs")->fetchColumn();
                            $donationStats = $donationManager->getDonationStats();
                            $countryStats = $analyticsManager->getCountryStats();
                            $recentActivities = $activityLogger->getRecentActivities(5);
                            $unreadSubmissions = $formSubmissionManager->getSubmissions(null, 'unread', 5);
                            ?>
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="value"><?= number_format($totalArticles) ?></div>
                                        <div class="label">Articles</div>
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-arrow-up text-success"></i> 
                                                <?= rand(5, 15) ?> new this week
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="value"><?= number_format($totalPodcasts) ?></div>
                                        <div class="label">Podcasts</div>
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-arrow-up text-success"></i> 
                                                <?= rand(1, 5) ?> new this month
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="value"><?= number_format($totalPrograms) ?></div>
                                        <div class="label">Programs</div>
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <?= rand(1, 3) ?> active programs
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="stat-card">
                                        <div class="value">$<?= number_format($donationStats['total'], 2) ?></div>
                                        <div class="label">Total Donations</div>
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-arrow-up text-success"></i> 
                                                $<?= number_format($donationStats['monthly'][0]['total'] ?? 0, 2) ?> this month
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="fas fa-globe me-2"></i> Top Countries
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Country</th>
                                                            <th>Visitors</th>
                                                            <th>Page Views</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach (array_slice($countryStats, 0, 5) as $country): ?>
                                                        <tr>
                                                            <td>
                                                                <img src="https://flagcdn.com/16x12/<?= strtolower($country['country_code']) ?>.png" 
                                                                     class="country-flag" alt="<?= htmlspecialchars($country['country_name']) ?>">
                                                                <?= htmlspecialchars($country['country_name']) ?>
                                                            </td>
                                                            <td><?= number_format($country['unique_visitors']) ?></td>
                                                            <td><?= number_format($country['page_views']) ?></td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="fas fa-inbox me-2"></i> Unread Submissions
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <?php if (empty($unreadSubmissions)): ?>
                                                <div class="alert alert-info mb-0">No unread submissions</div>
                                            <?php else: ?>
                                                <ul class="list-group">
                                                    <?php foreach ($unreadSubmissions as $submission): 
                                                        $formData = json_decode($submission['form_data'], true);
                                                    ?>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <strong><?= htmlspecialchars($submission['form_type']) ?></strong>
                                                                <div class="text-muted small">
                                                                    <?= date('M j, Y H:i', strtotime($submission['created_at'])) ?>
                                                                </div>
                                                            </div>
                                                            <a href="?page=submissions&id=<?= $submission['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                        <?php if (!empty($formData['name']) || !empty($formData['email'])): ?>
                                                        <div class="mt-2 small">
                                                            <?php if (!empty($formData['name'])): ?>
                                                                <span class="me-2"><i class="fas fa-user me-1"></i> <?= htmlspecialchars($formData['name']) ?></span>
                                                            <?php endif; ?>
                                                            <?php if (!empty($formData['email'])): ?>
                                                                <span><i class="fas fa-envelope me-1"></i> <?= htmlspecialchars($formData['email']) ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php endif; ?>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="fas fa-history me-2"></i> Recent Activity
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php foreach ($recentActivities as $activity): ?>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <strong><?= htmlspecialchars($activity['user_identifier']) ?></strong>
                                                            <div><?= htmlspecialchars($activity['action']) ?></div>
                                                            <?php if (!empty($activity['details'])): ?>
                                                            <small class="text-muted"><?= htmlspecialchars($activity['details']) ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                        <small class="text-muted"><?= date('M j, H:i', strtotime($activity['created_at'])) ?></small>
                                                    </div>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="fas fa-heartbeat me-2"></i> System Health
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <?php 
                                            $health = $siteHealthMonitor->checkSystemHealth();
                                            $hasIssues = false;
                                            
                                            foreach ($health as $component) {
                                                if ($component['status'] !== 'ok') {
                                                    $hasIssues = true;
                                                    break;
                                                }
                                            }
                                            ?>
                                            
                                            <?php if ($hasIssues): ?>
                                                <div class="alert alert-warning">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    Some system components require attention
                                                </div>
                                            <?php else: ?>
                                                <div class="alert alert-success">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    All systems operational
                                                </div>
                                            <?php endif; ?>
                                            
                                            <ul class="list-group">
                                                <?php foreach ($health as $component => $info): ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <i class="fas fa-<?= 
                                                            $info['status'] === 'ok' ? 'check-circle text-success' : 
                                                            ($info['status'] === 'warning' ? 'exclamation-triangle text-warning' : 'times-circle text-danger')
                                                        ?> me-2"></i>
                                                        <?= ucfirst(str_replace('_', ' ', $component)) ?>
                                                    </span>
                                                    <span class="badge bg-<?= 
                                                        $info['status'] === 'ok' ? 'success' : 
                                                        ($info['status'] === 'warning' ? 'warning' : 'danger')
                                                    ?>">
                                                        <?= $info['message'] ?>
                                                    </span>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('mainContent').classList.toggle('active');
        });
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Charts
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($page === 'donations' || $page === ''): ?>
            // Donations chart
            const donationsCtx = document.getElementById('donationsChart');
            if (donationsCtx) {
                const donationsChart = new Chart(donationsCtx, {
                    type: 'bar',
                    data: {
                        labels: <?= json_encode(array_column($donationStats['monthly'], 'month')) ?>,
                        datasets: [{
                            label: 'Donations ($)',
                            data: <?= json_encode(array_column($donationStats['monthly'], 'total')) ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            <?php endif; ?>
            
            <?php if ($page === 'analytics'): ?>
            // Traffic chart
            const trafficCtx = document.getElementById('trafficChart');
            if (trafficCtx) {
                const trafficChart = new Chart(trafficCtx, {
                    type: 'line',
                    data: {
                        labels: <?= json_encode(array_column($trafficTrends, 'visit_date')) ?>,
                        datasets: [
                            {
                                label: 'Page Views',
                                data: <?= json_encode(array_column($trafficTrends, 'page_views')) ?>,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'Unique Visitors',
                                data: <?= json_encode(array_column($trafficTrends, 'unique_visitors')) ?>,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                                tension: 0.3,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            <?php endif; ?>
        });
    </script>
</body>
</html>