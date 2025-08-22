<?php
// pages/canada.php - Canada Branch Maintenance Page with component architecture
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Canada Branch - Under Maintenance | Importance Leadership";
$meta_description = "Our Canada operations remain fully active. We're enhancing our digital experience to serve you better with a new and improved platform coming soon.";
$meta_keywords = "Canada Branch, Under Maintenance, Importance Leadership, Platform Upgrade";
$canonical_url = "https://www.importanceleadership.com/canada";
$body_class = "canada-maintenance-page";

// Additional head content for Canada page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/canada-flag.svg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/canada-flag.svg">
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}
@keyframes progress {
    0% { width: 70%; }
    50% { width: 85%; }
    100% { width: 70%; }
}
.maintenance-float {
    animation: float 4s ease-in-out infinite;
}
.progress-animate {
    animation: progress 2.5s ease-in-out infinite;
}
</style>';

// Include header and navigation
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/nav.php';
?>

<!-- Skip to content link for accessibility -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary-500 text-white px-4 py-2 rounded-lg z-50">
    Skip to main content
</a>

<!-- Main Content -->
<main id="main-content" class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-20 px-4 relative overflow-hidden">
    <!-- Background Decorative Elements -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-600/5 rounded-full -translate-x-24 -translate-y-24"></div>
    <div class="absolute bottom-0 right-0 w-48 h-48 bg-red-600/5 rounded-full translate-x-12 translate-y-12"></div>
    
    <!-- Maintenance Container -->
    <div class="maintenance-float relative z-10 bg-white rounded-2xl shadow-xl max-w-2xl w-full p-8 md:p-12 text-center border border-gray-100">
        <!-- Top Border Gradient (Canada Colors) -->
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-600 to-red-600 rounded-t-2xl"></div>
        
        <!-- Logo and Company Name -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-6">
            <img src="https://upload.wikimedia.org/wikipedia/commons/c/cf/Flag_of_Canada.svg" 
                 alt="Canada Flag" 
                 class="h-12 w-auto drop-shadow-sm">
            <div class="border-l-2 border-gray-200 pl-4 hidden sm:block">
                <h3 class="text-xl font-semibold text-blue-600">Importance Leadership</h3>
            </div>
            <div class="sm:hidden">
                <h3 class="text-xl font-semibold text-blue-600">Importance Leadership</h3>
            </div>
        </div>
        
        <!-- Status Badge -->
        <div class="inline-block bg-gradient-to-r from-blue-600 to-red-600 text-white px-6 py-2 rounded-full font-semibold text-sm mb-6 shadow-lg">
            CANADA BRANCH
        </div>
        
        <!-- Main Heading -->
        <h1 class="text-3xl md:text-4xl font-bold text-blue-600 mb-2 tracking-tight">
            This Page is Under Maintenance
        </h1>
        
        <!-- Progress Container -->
        <div class="w-full bg-gray-200 rounded-full h-2 mb-8 overflow-hidden">
            <div class="progress-animate h-full bg-gradient-to-r from-blue-600 to-red-600 rounded-full"></div>
        </div>
        
        <!-- Description -->
        <p class="text-lg text-gray-600 mb-6 leading-relaxed">
            We're currently enhancing our digital experience to serve you better. Our Canada operations remain fully active during this upgrade.
        </p>
        
        <!-- Coming Soon Section -->
        <h2 class="text-2xl font-semibold text-red-600 mb-4">
            New & Improved Platform Coming Soon
        </h2>
        
        <p class="text-gray-600 mb-8 leading-relaxed">
            Thank you for your patience. We're working hard to deliver a faster, more intuitive website with enhanced features.
        </p>
        
        <!-- Contact Information -->
        <div class="text-gray-500 mb-6">
            <p class="mb-2">Need immediate assistance?</p>
            <a href="/contact" class="text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200 hover:underline">
                Get in Touch
            </a>
        </div>
        
        <!-- Return Link -->
        <a href="/" class="inline-block bg-gradient-to-r from-accent-500 to-yellow-500 text-white font-bold px-6 py-3 rounded-lg hover:from-accent-600 hover:to-yellow-600 transition-all duration-200 transform hover:scale-105 shadow-lg">
            Return to Main Page
        </a>
    </div>
</main>

<?php include __DIR__ . '/../components/footer.php'; ?>