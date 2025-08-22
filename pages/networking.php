<?php
// pages/networking.php - Professional Networking Program Page
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Professional Networking | Importance Leadership | Career Development";
$meta_description = "Importance Leadership's Professional Networking program connects aspiring youth with accomplished professionals through mentorship, workshops, and career opportunities.";
$meta_keywords = "professional networking, career development, mentorship, youth empowerment, job opportunities, industry connections, workshops";
$canonical_url = "https://www.importanceleadership.com/programs/networking";
$body_class = "networking-page";

// Additional head content
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/programs/networking.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/programs/networking.jpg">';

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
                 style="background-image: url('/reference-files/image/networking.jpg')"></div>
        </div>
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/80 to-primary-700/90 z-10"></div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-20 py-8">
            <div class="max-w-4xl mx-auto text-center">
                <span class="inline-block bg-amber-500/20 px-6 py-3 rounded-full text-amber-300 font-semibold mb-6 text-xl" data-aos="fade-up" data-aos-delay="100">
                    Pillar 2: Professional Networking
                </span>
                
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6" data-aos="fade-up" data-aos-delay="200">
                    Bridging <span class="text-amber-300">Opportunity Gaps</span> Through Connection
                </h1>
                
                <p class="text-xl md:text-2xl mb-8 opacity-95 max-w-4xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="300">
                    Connecting aspiring youth with accomplished professionals across diverse industries.
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="400">
                    <a href="#program" class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        Explore Our Program
                    </a>
                    <a href="#resources" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-user-tie mr-2"></i> Mentor Resources
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
                    Professional Networking Program
                </h2>
                <div class="w-20 h-1 bg-amber-400 mx-auto mb-6"></div>
                <p class="text-xl opacity-95 leading-relaxed max-w-4xl mx-auto">
                    We understand that access to professional networks is critical for career growth and innovation. Our program bridges the gap between accomplished professionals and aspiring youth.
                </p>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-8 md:p-12 max-w-5xl mx-auto text-gray-900" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-3xl font-bold font-secondary text-primary-500 mb-6">Our Mission</h3>
                <p class="text-xl text-gray-600 mb-8">
                    By connecting youth with successful individuals across various fields, we foster mentorship, knowledge exchange, and career opportunities that might otherwise be inaccessible to underrepresented groups.
                </p>
                
                <div class="grid lg:grid-cols-2 gap-8 mt-10">
                    <div data-aos="fade-up" data-aos-delay="300">
                        <h4 class="text-2xl font-semibold font-secondary text-primary-500 mb-4 flex items-center">
                            <i class="fas fa-briefcase text-amber-600 mr-3"></i> The Challenge
                        </h4>
                        <p class="text-gray-600 text-lg">
                            Many talented youth from marginalized communities lack access to professional networks that could help launch their careers.
                        </p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="400">
                        <h4 class="text-2xl font-semibold font-secondary text-primary-500 mb-4 flex items-center">
                            <i class="fas fa-network-wired text-amber-600 mr-3"></i> Our Approach
                        </h4>
                        <p class="text-gray-600 text-lg">
                            We create structured opportunities for meaningful professional connections through events, workshops, and mentorship programs.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Components Section -->
    <section id="components" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Our Networking Components
                </h2>
                <div class="w-20 h-1 bg-amber-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Multi-faceted approaches to professional connection and growth
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Workshops -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-8">
                        <div class="bg-amber-100 text-amber-600 rounded-lg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-chalkboard-teacher text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-center text-primary-500 mb-4">Workshops & Panels</h3>
                        <p class="text-gray-600 text-center text-lg">
                            Curated workshops and panel discussions featuring industry leaders sharing insights and career advice.
                        </p>
                    </div>
                </div>
                
                <!-- Career Events -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-8">
                        <div class="bg-amber-100 text-amber-600 rounded-lg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-handshake text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-center text-primary-500 mb-4">Career Exhibitions</h3>
                        <p class="text-gray-600 text-center text-lg">
                            Career exhibitions and networking events connecting youth with potential employers and mentors.
                        </p>
                    </div>
                </div>
                
                <!-- Learning Platforms -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-8">
                        <div class="bg-amber-100 text-amber-600 rounded-lg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-lightbulb text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-center text-primary-500 mb-4">Learning Platforms</h3>
                        <p class="text-gray-600 text-center text-lg">
                            Collaborative learning platforms and idea-sharing sessions for ongoing professional development.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Impact Section -->
            <div class="mt-16 bg-gradient-to-r from-amber-50 to-primary-50 rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                <div class="p-8 md:p-12">
                    <h3 class="text-3xl font-bold font-secondary text-primary-500 mb-8 text-center">Program Impact</h3>
                    
                    <div class="grid lg:grid-cols-2 gap-12">
                        <div>
                            <h4 class="text-2xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                                <i class="fas fa-chart-line text-amber-600 mr-3"></i> Measurable Outcomes
                            </h4>
                            <ul class="text-gray-600 space-y-4">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-amber-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">500+ mentorship connections established</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-amber-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">200+ internship and job opportunities created</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-amber-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">85% of participants report expanded professional networks</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="text-2xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                                <i class="fas fa-user-graduate text-amber-600 mr-3"></i> Participant Benefits
                            </h4>
                            <ul class="text-gray-600 space-y-4">
                                <li class="flex items-start">
                                    <i class="fas fa-arrow-right text-amber-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Direct access to industry professionals</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-arrow-right text-amber-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Practical career guidance and advice</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-arrow-right text-amber-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Exposure to diverse career pathways</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-12 text-center">
                        <a href="/contact" class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                            <i class="fas fa-user-plus mr-2"></i> Join Our Network
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
                    Career Resources
                </h2>
                <div class="w-20 h-1 bg-amber-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Tools and materials to support your professional growth
                </p>
            </div>

            <!-- Resource Cards -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Resource 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-8">
                        <div class="bg-amber-100 text-amber-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-file-pdf text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Networking Guide</h3>
                        <p class="text-gray-600 mb-6">Comprehensive guide to building meaningful professional relationships.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center">
                            Download Guide <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Resource 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-8">
                        <div class="bg-amber-100 text-amber-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-video text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Career Webinars</h3>
                        <p class="text-gray-600 mb-6">Recorded sessions with professionals from various industries.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center">
                            Watch Now <i class="fas fa-play-circle ml-2"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Resource 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-8">
                        <div class="bg-amber-100 text-amber-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-book text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Mentorship Toolkit</h3>
                        <p class="text-gray-600 mb-6">Resources for both mentors and mentees to maximize relationships.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center">
                            View Resources <i class="fas fa-external-link-alt ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Get Involved Section -->
            <div class="mt-16 bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="500">
                <div class="grid lg:grid-cols-2">
                    <div class="p-8 md:p-12">
                        <h3 class="text-3xl font-bold font-secondary text-primary-500 mb-6">Get Involved</h3>
                        <p class="text-gray-600 mb-8 text-lg">
                            Whether you're a professional looking to give back or a young person seeking guidance, we have opportunities for you:
                        </p>
                        <ul class="text-gray-600 space-y-4">
                            <li class="flex items-start">
                                <i class="fas fa-user-tie text-amber-500 mt-1 mr-3 flex-shrink-0"></i>
                                <span class="text-lg">Become a mentor and share your expertise</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-search text-amber-500 mt-1 mr-3 flex-shrink-0"></i>
                                <span class="text-lg">Find a mentor in your field of interest</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-calendar-alt text-amber-500 mt-1 mr-3 flex-shrink-0"></i>
                                <span class="text-lg">Attend our next networking event</span>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-gradient-to-br from-amber-50 to-primary-50 p-8 md:p-12 flex items-center">
                        <div>
                            <h4 class="text-2xl font-bold font-secondary text-primary-500 mb-6">Upcoming Events</h4>
                            <div class="space-y-6">
                                <div class="flex items-start">
                                    <div class="bg-amber-600 text-white rounded-lg w-14 h-14 flex-shrink-0 flex items-center justify-center mr-4">
                                        <span class="font-bold">12</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-primary-500 text-lg">Tech Industry Networking</p>
                                        <p class="text-gray-600">July 12, 2025 | 6:00 PM</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-amber-600 text-white rounded-lg w-14 h-14 flex-shrink-0 flex items-center justify-center mr-4">
                                        <span class="font-bold">20</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-primary-500 text-lg">Resume Workshop</p>
                                        <p class="text-gray-600">July 20, 2025 | 4:00 PM</p>
                                    </div>
                                </div>
                            </div>
                            <a href="/events" class="inline-flex items-center mt-8 text-amber-600 font-bold hover:text-amber-700 text-lg">
                                View Full Calendar <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/footer.php'; ?>