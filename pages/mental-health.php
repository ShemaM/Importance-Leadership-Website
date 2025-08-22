<?php
// pages/mental-health.php - Mental Health Programs Page
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Mental Health Programs | Importance Leadership | Youth Well-being";
$meta_description = "Importance Leadership's Mental Health Programs provide support and resources for vulnerable youth, including refugees and minorities, through professional partnerships and safe spaces for healing.";
$meta_keywords = "mental health, youth wellness, refugees, minorities, emotional support, safe spaces, resilience, professional partnerships";
$canonical_url = "https://www.importanceleadership.com/programs/mental-health";
$body_class = "mental-health-page";

// Additional head content
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/programs/mental-health.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/programs/mental-health.jpg">';

// Include header and navigation
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/nav.php';
?>

<!-- Skip to content link for accessibility -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary-500 text-white px-4 py-2 rounded-lg z-50">
    Skip to main content
</a>

<!-- Main Content -->
<main id="main-content">
    <!-- Hero Section -->
    <section class="relative h-screen min-h-[600px] flex items-center justify-center text-white overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                 style="background-image: url('/assets/images/programs/mental-health.jpg')"></div>
        </div>
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/80 to-primary-700/90 z-10"></div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-20 py-8">
            <div class="max-w-4xl mx-auto text-center">
                <span class="inline-block bg-purple-500/20 px-6 py-3 rounded-full text-purple-300 font-semibold mb-6 text-xl" data-aos="fade-up" data-aos-delay="100">
                    Pillar 3: Mental Health Programs
                </span>
                
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6" data-aos="fade-up" data-aos-delay="200">
                    Nurturing <span class="text-purple-300">Mental Well-being</span> for Youth
                </h1>
                
                <p class="text-xl md:text-2xl mb-8 opacity-95 max-w-4xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="300">
                    Supporting emotional health and resilience for vulnerable young people, especially women, girls, refugees, and minorities.
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="400">
                    <a href="#program" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        Learn About Our Program
                    </a>
                    <a href="#resources" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-heart mr-2"></i> Wellness Resources
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Scroll Down Arrow -->
        <div class="absolute bottom-10 left-0 right-0 text-center animate-bounce">
            <a href="#program" class="text-white text-2xl" aria-label="Scroll down">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Program Section -->
    <section id="program" class="py-20 bg-gradient-to-br from-primary-500 to-primary-700 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary mb-6">
                    Mental Health Support Program
                </h2>
                <div class="w-20 h-1 bg-purple-400 mx-auto mb-6"></div>
                <p class="text-xl opacity-95 leading-relaxed max-w-4xl mx-auto">
                    We recognize that mental well-being is foundational to personal development and societal contribution. Our program addresses psychological challenges faced by vulnerable youth.
                </p>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-8 md:p-12 max-w-5xl mx-auto text-gray-900" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-3xl font-bold font-secondary text-primary-500 mb-6">Our Mission</h3>
                <p class="text-xl text-gray-600 mb-8">
                    Many young people, especially women, girls, refugees, and minorities face deep psychological challenges due to displacement, violence, and marginalization. We aim to promote resilience, self-worth, and emotional intelligence among these vulnerable groups.
                </p>
                
                <div class="grid lg:grid-cols-2 gap-8 mt-10">
                    <div data-aos="fade-up" data-aos-delay="300">
                        <h4 class="text-2xl font-semibold font-secondary text-primary-500 mb-4 flex items-center">
                            <i class="fas fa-brain text-purple-600 mr-3"></i> The Challenge
                        </h4>
                        <p class="text-gray-600 text-lg">
                            Marginalized youth often lack access to mental health resources and safe spaces to process trauma, leading to cycles of emotional distress and decreased life opportunities.
                        </p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="400">
                        <h4 class="text-2xl font-semibold font-secondary text-primary-500 mb-4 flex items-center">
                            <i class="fas fa-hands-helping text-purple-600 mr-3"></i> Our Approach
                        </h4>
                        <p class="text-gray-600 text-lg">
                            We combine professional mental health support with peer networks and community-based healing approaches tailored to cultural contexts.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Workshop Section -->
    <section id="workshop" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Our Program Components
                </h2>
                <div class="w-20 h-1 bg-purple-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Comprehensive mental health support through multiple channels
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Professional Partnerships -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-8">
                        <div class="bg-purple-100 text-purple-600 rounded-lg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-user-md text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-center text-primary-500 mb-4">Professional Partnerships</h3>
                        <p class="text-gray-600 text-center text-lg">
                            Partnering with mental health professionals, medical practitioners, and psychologists to provide expert care and guidance.
                        </p>
                    </div>
                </div>
                
                <!-- Wellness Forums -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-8">
                        <div class="bg-purple-100 text-purple-600 rounded-lg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-center text-primary-500 mb-4">Wellness Forums</h3>
                        <p class="text-gray-600 text-center text-lg">
                            Hosting in-person and virtual wellness forums to educate and connect youth with mental health resources.
                        </p>
                    </div>
                </div>
                
                <!-- Safe Spaces -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-8">
                        <div class="bg-purple-100 text-purple-600 rounded-lg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-heart text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-center text-primary-500 mb-4">Safe Spaces</h3>
                        <p class="text-gray-600 text-center text-lg">
                            Providing safe spaces for open dialogue, healing, and emotional support among peers and mentors.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Impact Section -->
            <div class="mt-16 bg-gradient-to-r from-purple-50 to-primary-50 rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                <div class="p-8 md:p-12">
                    <h3 class="text-3xl font-bold font-secondary text-primary-500 mb-8 text-center">Program Impact</h3>
                    
                    <div class="grid lg:grid-cols-2 gap-12">
                        <div>
                            <h4 class="text-2xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                                <i class="fas fa-chart-line text-purple-600 mr-3"></i> Measurable Outcomes
                            </h4>
                            <ul class="text-gray-600 space-y-4">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-purple-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Increased emotional resilience among participants</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-purple-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Improved self-reported mental well-being</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-purple-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Greater awareness of mental health resources</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="text-2xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                                <i class="fas fa-heartbeat text-purple-600 mr-3"></i> Long-term Benefits
                            </h4>
                            <ul class="text-gray-600 space-y-4">
                                <li class="flex items-start">
                                    <i class="fas fa-arrow-right text-purple-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Breaking cycles of trauma and distress</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-arrow-right text-purple-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Building emotional intelligence for life challenges</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-arrow-right text-purple-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Creating peer support networks that endure</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-12 text-center">
                        <a href="/contact" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                            <i class="fas fa-envelope mr-2"></i> Get Involved
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Resources Section -->
    <section id="resources" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Mental Health Resources
                </h2>
                <div class="w-20 h-1 bg-purple-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Access our mental health materials and wellness tools
                </p>
            </div>

            <!-- Resource Cards -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Resource 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-8">
                        <div class="bg-purple-100 text-purple-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-file-pdf text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Self-Care Guide</h3>
                        <p class="text-gray-600 mb-6">Practical daily practices for maintaining mental wellness.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center">
                            Download Guide <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Resource 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-8">
                        <div class="bg-purple-100 text-purple-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-headphones text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Meditation Series</h3>
                        <p class="text-gray-600 mb-6">Guided audio sessions for stress relief and mindfulness.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center">
                            Listen Now <i class="fas fa-play-circle ml-2"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Resource 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-8">
                        <div class="bg-purple-100 text-purple-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-book text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Crisis Resources</h3>
                        <p class="text-gray-600 mb-6">Emergency contacts and support services directory.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center">
                            View Resources <i class="fas fa-external-link-alt ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/footer.php'; ?>