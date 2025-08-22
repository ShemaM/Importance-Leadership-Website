<?php
// pages/advocacy-initiatives.php - Advocacy Initiatives Program Page
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Advocacy Initiatives | Importance Leadership | Empowering Voices";
$meta_description = "Importance Leadership's Advocacy Initiatives amplify marginalized voices through awareness campaigns, policy engagement, and capacity-building for refugees, IDPs, and minority groups.";
$meta_keywords = "advocacy, refugees, IDPs, minority groups, policy engagement, awareness campaigns, capacity building, social justice";
$canonical_url = "https://www.importanceleadership.com/programs/advocacy-initiatives";
$body_class = "advocacy-initiatives-page";

// Additional head content
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/programs/advocacy-program.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/programs/advocacy-program.jpg">';

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
                 style="background-image: url('/assets/images/programs/advocacy-program.jpg')"></div>
        </div>
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/80 to-primary-700/90 z-10"></div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-20 py-8">
            <div class="max-w-4xl mx-auto text-center">
                <span class="inline-block bg-accent-500/20 px-6 py-3 rounded-full text-accent-300 font-semibold mb-6 text-xl" data-aos="fade-up" data-aos-delay="100">
                    Pillar 1: Advocacy Initiatives
                </span>
                
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6" data-aos="fade-up" data-aos-delay="200">
                    Amplifying <span class="text-accent-300">Marginalized Voices</span> for Change
                </h1>
                
                <p class="text-xl md:text-2xl mb-8 opacity-95 max-w-4xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="300">
                    Championing the rights of refugees, IDPs, and minority groups through strategic advocacy and policy engagement.
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="400">
                    <a href="#program" class="bg-accent-500 hover:bg-accent-600 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        Learn About Our Work
                    </a>
                    <a href="#resources" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-gavel mr-2"></i> Policy Resources
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
                    Advocacy for Justice & Inclusion
                </h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 leading-relaxed max-w-4xl mx-auto">
                    We believe that real change begins with strong, informed voices. Our advocacy identifies and addresses pressing issues affecting marginalized communities.
                </p>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-8 md:p-12 max-w-5xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-3xl font-bold font-secondary text-primary-500 mb-6">Our Mission</h3>
                <p class="text-xl text-gray-600 mb-8">
                    We advocate for the rights and inclusion of refugees, IDPs, and minority groups facing discriminatory policies, systemic exclusion, abandonment, and injustice. Our goal is to ensure these voices are heard, respected, and empowered in decision-making spaces.
                </p>
                
                <div class="grid lg:grid-cols-2 gap-8 mt-10">
                    <div data-aos="fade-up" data-aos-delay="300">
                        <h4 class="text-2xl font-semibold font-secondary text-primary-500 mb-4 flex items-center">
                            <i class="fas fa-exclamation-triangle text-accent-500 mr-3"></i> The Challenge
                        </h4>
                        <p class="text-gray-600 text-lg">
                            Marginalized communities often lack representation in policy discussions and face systemic barriers to justice and equal opportunities.
                        </p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="400">
                        <h4 class="text-2xl font-semibold font-secondary text-primary-500 mb-4 flex items-center">
                            <i class="fas fa-bullhorn text-accent-500 mr-3"></i> Our Approach
                        </h4>
                        <p class="text-gray-600 text-lg">
                            We combine grassroots mobilization with policy advocacy and legal strategies to create systemic change.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Initiatives Section -->
    <section id="initiatives" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Our Advocacy Strategies
                </h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Multi-faceted approaches to drive policy change and public awareness
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Awareness Campaigns -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-8">
                        <div class="bg-accent-100 text-accent-500 rounded-lg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-megaphone text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-center text-primary-500 mb-4">Public Awareness</h3>
                        <p class="text-gray-600 text-center text-lg">
                            Raising awareness through public forums, conferences, workshops, and media campaigns to highlight critical issues.
                        </p>
                    </div>
                </div>
                
                <!-- Policy Engagement -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-8">
                        <div class="bg-accent-100 text-accent-500 rounded-lg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-file-contract text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-center text-primary-500 mb-4">Policy Engagement</h3>
                        <p class="text-gray-600 text-center text-lg">
                            Issuing press releases, policy briefs, and engaging in strategic litigation to influence decision-makers.
                        </p>
                    </div>
                </div>
                
                <!-- Capacity Building -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-8">
                        <div class="bg-accent-100 text-accent-500 rounded-lg w-16 h-16 flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-hands-helping text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-center text-primary-500 mb-4">Capacity Building</h3>
                        <p class="text-gray-600 text-center text-lg">
                            Organizing trainings on rights, civic participation, and advocacy skills to empower community leaders.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Impact Section -->
            <div class="mt-16 bg-gradient-to-r from-accent-50 to-primary-50 rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                <div class="p-8 md:p-12">
                    <h3 class="text-3xl font-bold font-secondary text-primary-500 mb-8 text-center">Advocacy Impact</h3>
                    
                    <div class="grid lg:grid-cols-2 gap-12">
                        <div>
                            <h4 class="text-2xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                                <i class="fas fa-chart-line text-accent-500 mr-3"></i> Recent Achievements
                            </h4>
                            <ul class="text-gray-600 space-y-4">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-accent-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Successfully advocated for policy changes benefiting 5,000+ refugees</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-accent-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Trained 200+ community advocates in rights awareness</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-accent-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Secured media coverage on critical issues in 15+ outlets</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="text-2xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                                <i class="fas fa-bullseye text-accent-500 mr-3"></i> Current Campaigns
                            </h4>
                            <ul class="text-gray-600 space-y-4">
                                <li class="flex items-start">
                                    <i class="fas fa-arrow-right text-accent-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Equal access to education for displaced children</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-arrow-right text-accent-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Anti-discrimination protections for minority groups</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-arrow-right text-accent-500 mt-1 mr-3 flex-shrink-0"></i>
                                    <span class="text-lg">Legal aid services for asylum seekers</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-12 text-center">
                        <a href="/join-us" class="bg-accent-500 hover:bg-accent-600 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                            <i class="fas fa-hands-helping mr-2"></i> Join Our Advocacy
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
                    Advocacy Resources
                </h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Tools and materials to support your advocacy efforts
                </p>
            </div>

            <!-- Resource Cards -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Resource 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-8">
                        <div class="bg-accent-100 text-accent-500 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-file-pdf text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Advocacy Toolkit</h3>
                        <p class="text-gray-600 mb-6">Step-by-step guide to effective community advocacy and policy change.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center">
                            Download Toolkit <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Resource 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-8">
                        <div class="bg-accent-100 text-accent-500 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-film text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Training Webinars</h3>
                        <p class="text-gray-600 mb-6">Recorded sessions on rights awareness and policy engagement strategies.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg inline-flex items-center">
                            Watch Now <i class="fas fa-play-circle ml-2"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Resource 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-8">
                        <div class="bg-accent-100 text-accent-500 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-book text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">Policy Briefs</h3>
                        <p class="text-gray-600 mb-6">Research-based recommendations on key issues affecting marginalized groups.</p>
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