<?php
// pages/climate-change.php - Climate Change Awareness Program Page
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Climate Change Awareness | Importance Leadership | Empowering Youth";
$meta_description = "Importance Leadership's Climate Change Awareness program educates and empowers youth to become environmental stewards through community outreach, workshops, and policy dialogues.";
$meta_keywords = "climate change, environmental awareness, sustainability, youth empowerment, eco-conscious, climate action, environmental stewardship";
$canonical_url = "https://www.importanceleadership.com/programs/climate-change";
$body_class = "climate-change-page";

// Additional head content
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/programs/climate-change.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/programs/climate-change.jpg">';

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
                 style="background-image: url('/assets/images/programs/climate-change.jpg')"></div>
        </div>
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/80 to-primary-700/90 z-10"></div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-20 py-8">
            <div class="max-w-4xl mx-auto text-center">
                <span class="inline-block bg-green-500/20 px-6 py-3 rounded-full text-green-300 font-semibold mb-6 text-xl" data-aos="fade-up" data-aos-delay="100">
                    Pillar 5: Climate Change Awareness
                </span>
                
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6" data-aos="fade-up" data-aos-delay="200">
                    Building <span class="text-green-300">Eco-Conscious</span> Generations
                </h1>
                
                <p class="text-xl md:text-2xl mb-8 opacity-95 max-w-4xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="300">
                    Empowering youth to understand their role in environmental stewardship and climate action.
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="400">
                    <a href="#program" class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        Learn About Our Program
                    </a>
                    <a href="#resources" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-file-powerpoint mr-2"></i> Resources
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
    <section id="program" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Climate Change Awareness Program
                </h2>
                <div class="w-20 h-1 bg-green-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 leading-relaxed max-w-4xl mx-auto">
                    Climate change is a global reality that demands local action. This program educates communities, especially youth, on the causes, effects, and mitigation of climate change.
                </p>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-8 md:p-12 max-w-5xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-3xl font-bold font-secondary text-primary-500 mb-6">Our Mission</h3>
                <p class="text-xl text-gray-600 mb-8">
                    We aim to build eco-conscious generations who understand their role in environmental stewardship. By encouraging behavior change and environmental responsibility, we contribute to building resilient and sustainable communities.
                </p>
                
                <div class="grid lg:grid-cols-2 gap-8 mt-10">
                    <div data-aos="fade-up" data-aos-delay="300">
                        <h4 class="text-2xl font-semibold font-secondary text-primary-500 mb-4 flex items-center">
                            <i class="fas fa-exclamation-triangle text-green-600 mr-3"></i> The Challenge
                        </h4>
                        <p class="text-gray-600 text-lg">
                            Many communities lack awareness about climate change impacts and mitigation strategies, particularly vulnerable populations like refugees and minorities.
                        </p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="400">
                        <h4 class="text-2xl font-semibold font-secondary text-primary-500 mb-4 flex items-center">
                            <i class="fas fa-bullseye text-green-600 mr-3"></i> Our Approach
                        </h4>
                        <p class="text-gray-600 text-lg">
                            We combine education, community engagement, and policy advocacy to create lasting environmental change through youth empowerment.
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
                    Climate Change & Mitigation Workshop
                </h2>
                <div class="w-20 h-1 bg-green-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600">
                    July 12, 2025 | Nairobi, Kenya
                </p>
            </div>

            <div class="bg-gradient-to-r from-gray-50 to-green-50 rounded-2xl shadow-lg overflow-hidden mb-12" data-aos="fade-up" data-aos-delay="200">
                <div class="grid lg:grid-cols-2">
                    <div class="p-8 md:p-12">
                        <h3 class="text-3xl font-bold font-secondary text-primary-500 mb-6">Workshop Highlights</h3>
                        <p class="text-gray-600 mb-8 text-lg">
                            This transformative event brought together trainees and climate experts for intensive learning about climate causes, effects, and mitigation strategies, with special focus on youth empowerment.
                        </p>
                        
                        <div class="space-y-8">
                            <div>
                                <h4 class="text-xl font-bold text-primary-500 mb-4 flex items-center">
                                    <i class="fas fa-chalkboard-teacher text-green-600 mr-3"></i> Expert Facilitators
                                </h4>
                                <ul class="text-gray-600 space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-user-tie text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                                        <span>Nsengiyumva Francois - CEO, Rwanda Eco Conservation Alliance</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-user-tie text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                                        <span>Cosmas Msoka - Climate Change Activist & Digital Analyst</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div>
                                <h4 class="text-xl font-bold text-primary-500 mb-4 flex items-center">
                                    <i class="fas fa-lightbulb text-green-600 mr-3"></i> Key Learnings
                                </h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <span class="bg-white px-4 py-3 rounded-lg text-center border-l-4 border-red-500 flex items-center justify-center">
                                        <i class="fas fa-fire text-red-500 mr-2"></i> Causes
                                    </span>
                                    <span class="bg-white px-4 py-3 rounded-lg text-center border-l-4 border-yellow-500 flex items-center justify-center">
                                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i> Impacts
                                    </span>
                                    <span class="bg-white px-4 py-3 rounded-lg text-center border-l-4 border-blue-500 flex items-center justify-center">
                                        <i class="fas fa-landmark text-blue-500 mr-2"></i> Policies
                                    </span>
                                    <span class="bg-white px-4 py-3 rounded-lg text-center border-l-4 border-green-500 flex items-center justify-center">
                                        <i class="fas fa-users text-green-500 mr-2"></i> Youth Roles
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8 md:p-12 bg-white">
                        <h4 class="text-2xl font-bold font-secondary text-primary-500 mb-6">Youth Action Plan</h4>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-green-50 p-6 rounded-xl text-center hover:shadow-lg transition-shadow duration-300">
                                <div class="bg-green-100 text-green-600 rounded-full w-16 h-16 flex items-center justify-center mb-4 mx-auto">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                                <p class="font-semibold text-primary-500">Community Clubs</p>
                            </div>
                            <div class="bg-green-50 p-6 rounded-xl text-center hover:shadow-lg transition-shadow duration-300">
                                <div class="bg-green-100 text-green-600 rounded-full w-16 h-16 flex items-center justify-center mb-4 mx-auto">
                                    <i class="fas fa-tree text-2xl"></i>
                                </div>
                                <p class="font-semibold text-primary-500">Tree Planting</p>
                            </div>
                            <div class="bg-green-50 p-6 rounded-xl text-center hover:shadow-lg transition-shadow duration-300">
                                <div class="bg-green-100 text-green-600 rounded-full w-16 h-16 flex items-center justify-center mb-4 mx-auto">
                                    <i class="fas fa-recycle text-2xl"></i>
                                </div>
                                <p class="font-semibold text-primary-500">Waste Recycling</p>
                            </div>
                            <div class="bg-green-50 p-6 rounded-xl text-center hover:shadow-lg transition-shadow duration-300">
                                <div class="bg-green-100 text-green-600 rounded-full w-16 h-16 flex items-center justify-center mb-4 mx-auto">
                                    <i class="fas fa-bullhorn text-2xl"></i>
                                </div>
                                <p class="font-semibold text-primary-500">Awareness Campaigns</p>
                            </div>
                        </div>
                        
                        <div class="mt-8 text-center">
                            <a href="https://docs.google.com/presentation/d/1y7muVYtUrOhKvOrM7U9eNJqnUDgdaOrEVuPdQHZk00k/edit?usp=sharing" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                                <i class="fas fa-file-powerpoint mr-2"></i> View Workshop Presentation
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workshop Report -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                <div class="p-8 md:p-12 border-b border-gray-200">
                    <h3 class="text-3xl font-bold font-secondary text-primary-500 mb-4">Workshop Report</h3>
                    <p class="text-gray-600 text-lg">Detailed documentation of our Climate Change & Mitigation Workshop outcomes</p>
                </div>
                
                <div class="p-8 md:p-12">
                    <h4 class="text-2xl font-bold text-primary-500 mb-6">Key Outcomes:</h4>
                    <ul class="text-gray-600 space-y-3 mb-8">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                            <span class="text-lg">Comprehensive understanding of climate change causes (both human and natural)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                            <span class="text-lg">Analysis of climate impacts across multiple sectors including agriculture, health, and economy</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                            <span class="text-lg">Identification of gaps in current climate policies and improvement strategies</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                            <span class="text-lg">Development of specific youth action plans for climate mitigation</span>
                        </li>
                    </ul>
                    
                    <h4 class="text-2xl font-bold text-primary-500 mb-6">Youth Empowerment:</h4>
                    <p class="text-gray-600 mb-8 text-lg">
                        The workshop culminated in a powerful call to action, inspiring participants to become agents of change through community engagement, technological innovation, and policy advocacy.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/reference-files/Resources/Climate Change Workshop .docx" class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center" download>
                            <i class="fas fa-download mr-2"></i> Download Full Report
                        </a>
                        <a href="/contact" class="bg-white hover:bg-gray-50 text-primary-500 border-2 border-primary-500 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 inline-flex items-center justify-center">
                            <i class="fas fa-envelope mr-2"></i> Request More Info
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
                    Educational Resources
                </h2>
                <div class="w-20 h-1 bg-green-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Access our comprehensive climate change materials and presentations
                </p>
            </div>

            <!-- PowerPoint Presentation Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-12 max-w-5xl mx-auto hover:shadow-2xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="grid lg:grid-cols-2">
                    <div class="p-8 md:p-12 flex flex-col">
                        <div class="flex items-center mb-6">
                            <div class="bg-green-600 text-white rounded-lg w-16 h-16 flex items-center justify-center mr-4">
                                <i class="fas fa-file-powerpoint text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold font-secondary text-primary-500">Climate Change Comprehensive Guide</h3>
                        </div>
                        <p class="text-gray-600 mb-8 flex-grow text-lg">
                            Our detailed PowerPoint presentation covers all aspects of climate change - from scientific foundations to mitigation strategies and policy frameworks. This is the complete reference used in our workshops.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="https://docs.google.com/presentation/d/1y7muVYtUrOhKvOrM7U9eNJqnUDgdaOrEVuPdQHZk00k/edit?usp=sharing" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center justify-center">
                                <i class="fas fa-eye mr-2"></i> View Presentation (Google Slides)
                            </a>
                            <a href="/reference-files/Resources/Climate Change Presentation.ppt" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center justify-center" download>
                                <i class="fas fa-download mr-2"></i> Download Slides
                            </a>
                        </div>
                    </div>
                    <div class="hidden lg:block bg-gray-100 relative overflow-hidden">
                        <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                             style="background-image: url('/reference-files/image/environmentalHealth.jpg')"></div>
                        <div class="absolute inset-0 bg-gradient-to-l from-white/70 to-white/0"></div>
                        <div class="absolute bottom-4 right-4">
                            <div class="bg-white/90 backdrop-blur-sm rounded-lg p-4 shadow-lg">
                                <p class="text-sm font-semibold text-green-800">Interactive Presentation</p>
                                <p class="text-xs text-green-600">50+ slides of comprehensive content</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Resources Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Resource 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-8">
                        <div class="bg-green-100 text-green-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-file-pdf text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Workshop Report</h3>
                        <p class="text-gray-600 mb-6">Detailed documentation of our Climate Change & Mitigation Workshop outcomes.</p>
                        <a href="/reference-files/Resources/Climate Change Workshop .docx" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center" download>
                            Download PDF <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Resource 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
                    <div class="p-8">
                        <div class="bg-green-100 text-green-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-video text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Webinar Recordings</h3>
                        <p class="text-gray-600 mb-6">Collection of our past climate policy discussions with experts.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center">
                            Watch Now <i class="fas fa-play-circle ml-2"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Resource 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="500">
                    <div class="p-8">
                        <div class="bg-green-100 text-green-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-book text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Action Guides</h3>
                        <p class="text-gray-600 mb-6">Practical steps for youth to implement climate solutions.</p>
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