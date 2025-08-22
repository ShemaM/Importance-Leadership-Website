<?php
// 404.php - Custom 404 error page
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/security.php';

// Set 404 status code
http_response_code(404);

// Page configuration
$page_title = "Page Not Found | Importance Leadership";
$meta_description = "The page you're looking for doesn't exist. Find what you need on the Importance Leadership website.";
$meta_keywords = "404, page not found, error";
$canonical_url = "https://www.importanceleadership.com/404";
$body_class = "error-page";

// Additional head content for 404 page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta name="robots" content="noindex, follow">';

// Include header and navigation
include 'components/header.php';
include 'components/nav.php';
?>

<!-- Skip to content link for accessibility -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary-500 text-white px-4 py-2 rounded-lg z-50">
    Skip to main content
</a>

<!-- Main Content -->
<main id="main-content" class="min-h-screen flex items-center justify-center bg-gray-50 pt-20">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto text-center">
            <!-- 404 Error -->
            <div class="mb-8" data-aos="fade-up">
                <h1 class="text-8xl md:text-9xl font-bold text-primary-500 mb-4 font-secondary">
                    404
                </h1>
                <div class="w-24 h-1 bg-accent-500 mx-auto mb-8"></div>
            </div>
            
            <!-- Error Message -->
            <div class="mb-12" data-aos="fade-up" data-aos-delay="100">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6 font-secondary">
                    Oops! Page Not Found
                </h2>
                <p class="text-xl text-gray-600 leading-relaxed mb-8">
                    The page you're looking for doesn't exist or may have been moved. Don't worry, it happens to the best of us.
                </p>
            </div>
            
            <!-- Helpful Actions -->
            <div class="space-y-6" data-aos="fade-up" data-aos-delay="200">
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                    <a href="/" class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        Go Home
                    </a>
                    <a href="/contact" class="border-2 border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300">
                        Contact Us
                    </a>
                </div>
                
                <!-- Quick Links -->
                <div class="bg-white rounded-xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Popular Pages</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <a href="/about" class="flex items-center p-4 rounded-lg hover:bg-gray-50 transition-all duration-300 group">
                            <i class="fas fa-users text-primary-500 mr-4 text-lg group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="text-left">
                                <div class="font-semibold text-gray-800 group-hover:text-primary-500 transition-colors duration-300">Who We Are</div>
                                <div class="text-sm text-gray-600">Learn about our mission</div>
                            </div>
                        </a>
                        <a href="/programs" class="flex items-center p-4 rounded-lg hover:bg-gray-50 transition-all duration-300 group">
                            <i class="fas fa-graduation-cap text-primary-500 mr-4 text-lg group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="text-left">
                                <div class="font-semibold text-gray-800 group-hover:text-primary-500 transition-colors duration-300">Our Programs</div>
                                <div class="text-sm text-gray-600">Explore our initiatives</div>
                            </div>
                        </a>
                        <a href="/impact" class="flex items-center p-4 rounded-lg hover:bg-gray-50 transition-all duration-300 group">
                            <i class="fas fa-chart-line text-primary-500 mr-4 text-lg group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="text-left">
                                <div class="font-semibold text-gray-800 group-hover:text-primary-500 transition-colors duration-300">Our Impact</div>
                                <div class="text-sm text-gray-600">See our results</div>
                            </div>
                        </a>
                        <a href="/join-us" class="flex items-center p-4 rounded-lg hover:bg-gray-50 transition-all duration-300 group">
                            <i class="fas fa-hand-holding-heart text-primary-500 mr-4 text-lg group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="text-left">
                                <div class="font-semibold text-gray-800 group-hover:text-primary-500 transition-colors duration-300">Get Involved</div>
                                <div class="text-sm text-gray-600">Join our community</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'components/footer.php'; ?>