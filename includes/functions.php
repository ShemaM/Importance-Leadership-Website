<?php
// includes/functions.php - Basic utility functions

/**
 * Get featured programs for homepage
 * @return array
 */
function getFeaturedPrograms() {
    // Mock data for testing - will be replaced with database calls later
    return [
        [
            'title' => 'Leadership Development',
            'description' => 'Comprehensive leadership training program developing essential skills for effective leadership.',
            'image' => '/assets/images/programs/leadership-development.jpg',
            'slug' => 'leadership-development',
            'duration' => '6 months',
            'participants' => 500
        ],
        [
            'title' => 'Mentorship Program', 
            'description' => 'Connect with experienced mentors who guide you through personal and professional growth.',
            'image' => '/assets/images/programs/mentorship.jpg',
            'slug' => 'mentorship',
            'duration' => 'Ongoing',
            'participants' => 300
        ],
        [
            'title' => 'Advocacy Initiatives',
            'description' => 'Empowers youth to become effective advocates for social justice and policy change.',
            'image' => '/assets/images/programs/advocacy-program.jpg', 
            'slug' => 'advocacy',
            'duration' => '3 months',
            'participants' => 250
        ]
    ];
}

/**
 * Get impact statistics
 * @return array
 */
function getImpactStatistics() {
    return [
        'leaders_trained' => 1500,
        'communities_impacted' => 50,
        'countries' => 3,
        'partnerships' => 100
    ];
}

/**
 * Safely escape output for HTML
 * @param string $string
 * @return string
 */
function esc_html($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Simple logging function for development
 * @param string $message
 * @param string $level
 */
function debug_log($message, $level = 'INFO') {
    if (ENVIRONMENT === 'development') {
        error_log("[{$level}] " . $message);
    }
}
?>