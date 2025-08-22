<?php
// pages/kenya.php - Kenya Branch Page with component architecture
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Kenya Branch | Importance Leadership";
$meta_description = "Explore the Kenya branch of Importance Leadership, empowering youth and communities through education, leadership, and social impact initiatives. Join us in shaping the future of Africa's leaders.";
$meta_keywords = "youth leadership Kenya, leadership programs Nairobi, mentorship for youth, ethical leadership, community development, social impact Kenya";
$canonical_url = "https://www.importanceleadership.com/kenya";
$body_class = "kenya-page";

// Additional head content for Kenya page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/kenya-programs.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/kenya-programs.jpg">';

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
    <section class="relative min-h-screen flex items-center justify-center text-white overflow-hidden bg-gradient-to-br from-slate-800 via-slate-900 to-primary-900">
        <!-- Background with Kenya flag overlay -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-800/90 via-slate-900/80 to-primary-900/90"></div>
            <div class="absolute inset-0 opacity-20">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/49/Flag_of_Kenya.svg" 
                     alt="Kenya Flag Background" 
                     class="w-full h-full object-cover">
            </div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-20 py-20">
            <div class="max-w-4xl">
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6" data-aos="fade-up" data-aos-delay="100">
                    Welcome to Importance Leadership Kenya
                </h1>
                
                <p class="text-xl md:text-2xl mb-6 opacity-95" data-aos="fade-up" data-aos-delay="200">
                    Empowering youth, refugees, and communities to unlock their full potential through education, leadership, and opportunity.
                </p>
                
                <p class="text-lg mb-6 opacity-90" data-aos="fade-up" data-aos-delay="300">
                    At our Kenya branch, we champion access to education, foster inclusive leadership, and drive social impact through innovative programs and partnerships. From mentorship and scholarship workshops to national conferences and grassroots initiatives, we are committed to building a future where every young person can thrive—regardless of background or circumstance.
                </p>
                
                <p class="text-lg mb-8 opacity-90" data-aos="fade-up" data-aos-delay="400">
                    Explore our recent events, discover our impact, and join us as we shape the next generation of African leaders.
                </p>
                
                <div class="flex flex-wrap gap-4" data-aos="fade-up" data-aos-delay="500">
                    <a href="#education-access" class="bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        Explore Programs
                    </a>
                    <a href="/contact" class="border-2 border-white text-white hover:bg-white hover:text-slate-900 px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                        Get Involved
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            
            <!-- Education Access Program -->
            <div id="education-access" class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-primary-500 text-white px-8 py-6 relative">
                    <h2 class="text-3xl font-bold font-secondary">Unlocking Potential Through Education</h2>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-accent-500"></div>
                </div>
                
                <div class="p-8">
                    <div class="flex flex-wrap gap-6 mb-6 text-gray-600">
                        <span class="flex items-center">
                            <i class="fas fa-calendar mr-2 text-accent-500"></i> April 24, 2025
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-globe mr-2 text-accent-500"></i> Virtual Event
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-users mr-2 text-accent-500"></i> 50+ attendees
                        </span>
                    </div>
                    
                    <p class="text-lg mb-8">Importance Leadership proudly hosted an inspiring virtual workshop focused on Access to Education and Scholarships—bringing together changemakers, young leaders, and aspiring scholars from underserved and refugee communities.</p>
                    
                    <div class="bg-accent-50 border-l-4 border-accent-500 p-6 mb-8">
                        <h5 class="font-bold text-primary-500 mb-4">Key Outcomes:</h5>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>32 immediate applications</strong> submitted during the workshop</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>8 mentorship matches</strong> with scholarship alumni</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span>Curated opportunity database shared with <strong>500+ youth</strong></span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span>Participants gained strategies for scholarship applications and personal storytelling</span>
                            </li>
                        </ul>
                    </div>
                    
                    <h4 class="text-xl font-bold text-primary-500 mb-4">Featured Opportunities:</h4>
                    <p class="mb-8">Mastercard Foundation, DAFI/Windle Trust, Kepler, SNHU/JRS, Science PO, WUSC</p>
                    
                    <div class="grid md:grid-cols-3 gap-4 mb-8">
                        <div class="h-48 bg-cover bg-center rounded-lg cursor-pointer transition-transform duration-300 hover:scale-105" 
                             style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')"></div>
                        <div class="h-48 bg-cover bg-center rounded-lg cursor-pointer transition-transform duration-300 hover:scale-105" 
                             style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80')"></div>
                        <div class="h-48 bg-cover bg-center rounded-lg cursor-pointer transition-transform duration-300 hover:scale-105" 
                             style="background-image: url('https://images.unsplash.com/photo-1546410531-bb4caa6b424d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80')"></div>
                    </div>
                    
                    <blockquote class="italic relative pl-8 mb-8">
                        <div class="absolute left-0 top-0 text-4xl text-accent-500 font-serif">"</div>
                        <p class="text-gray-600 mb-2">This workshop gave me the confidence to apply for scholarships I never thought I could get. I'm now enrolled at Kepler through the Mastercard Foundation program!</p>
                        <cite class="font-semibold text-primary-500 not-italic">-John M., Nairobi</cite>
                    </blockquote>
                    
                    <a href="https://www.linkedin.com/feed/update/urn:li:activity:7322768414068883456" 
                       class="inline-flex items-center bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105">
                        View LinkedIn Post <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Refugee Integration Conference -->
            <div id="refugee-integration" class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-primary-500 text-white px-8 py-6 relative">
                    <h2 class="text-3xl font-bold font-secondary">Refugee Integration Conference</h2>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-accent-500"></div>
                </div>
                
                <div class="p-8">
                    <div class="flex flex-wrap gap-6 mb-6 text-gray-600">
                        <span class="flex items-center">
                            <i class="fas fa-calendar mr-2 text-accent-500"></i> March 26-27, 2025
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-accent-500"></i> Safari Park Hotel, Nairobi
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-users mr-2 text-accent-500"></i> 200+ participants
                        </span>
                    </div>
                    
                    <p class="text-lg mb-6">In partnership with the Government of Kenya, R-Seat, Oxfam, LERRN, ReDSS, and various Refugee-Led Organizations (RLOs) from Nairobi, Uganda, Kakuma, and Dadaab, we hosted a powerful two-day conference on refugee integration.</p>
                    
                    <h4 class="text-xl font-bold text-primary-500 mb-4">Theme:</h4>
                    <p class="text-lg font-semibold mb-6">"Utilizing Refugee Participation in Kenya's Refugee Integration"</p>
                    
                    <div class="bg-accent-50 border-l-4 border-accent-500 p-6 mb-8">
                        <h5 class="font-bold text-primary-500 mb-4">Key Outcomes:</h5>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>3 pilot projects</strong> initiated in Kasarani, Dadaab, and Nakuru</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>Commitment from R-Seat</strong> to fund 5 refugee startups</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span>Featured in <strong>Nation Africa</strong> media coverage</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span>Deep dive into Kenya's <strong>Shirika Plan</strong> for refugee self-reliance</span>
                            </li>
                        </ul>
                    </div>
                    
                    <blockquote class="italic relative pl-8 mb-8">
                        <div class="absolute left-0 top-0 text-4xl text-accent-500 font-serif">"</div>
                        <p class="text-gray-600 mb-2">For the first time, we felt our voices were truly heard in discussions about our future in Kenya. This conference changed the narrative.</p>
                        <cite class="font-semibold text-primary-500 not-italic">- Ahmed K., Kakuma RLO Representative</cite>
                    </blockquote>
                    
                    <a href="https://www.linkedin.com/feed/update/urn:li:activity:7311328607778308096" 
                       class="inline-flex items-center bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105">
                        LinkedIn Post <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- UN General Assembly Address -->
            <div id="un-address" class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-primary-500 text-white px-8 py-6 relative">
                    <h2 class="text-3xl font-bold font-secondary">UN General Assembly Address</h2>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-accent-500"></div>
                </div>
                
                <div class="p-8">
                    <div class="flex flex-wrap gap-6 mb-6 text-gray-600">
                        <span class="flex items-center">
                            <i class="fas fa-calendar mr-2 text-accent-500"></i> June 2025
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-accent-500"></i> UN Office Nairobi (UNON)
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-users mr-2 text-accent-500"></i> Global Delegates
                        </span>
                    </div>
                    
                    <p class="text-lg mb-8">Bonkey Muhumure, delivered a powerful address at the United Nations General Assembly, advocating for education rights from his unique perspective as a refugee-turned-leader.</p>
                    
                    <div class="bg-accent-50 border-l-4 border-accent-500 p-6 mb-8">
                        <h5 class="font-bold text-primary-500 mb-4">Key Messages:</h5>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>Education as the greatest equalizer</strong> - Empowering youth to rise above limitations</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>Access to quality education is a fundamental right</strong> - No child should be denied learning</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>Investing in education is investing in the future</strong> - Prioritize youth upliftment programs</span>
                            </li>
                        </ul>
                    </div>
                    
                    <blockquote class="italic relative pl-8 mb-8">
                        <div class="absolute left-0 top-0 text-4xl text-accent-500 font-serif">"</div>
                        <p class="text-gray-600 mb-2">Bonkey's journey from walking three days to reach a murum road to standing before global leaders represents millions of young people who deserve access to quality education.</p>
                        <cite class="font-semibold text-primary-500 not-italic">- UNDP Representative</cite>
                    </blockquote>
                    
                    <a href="https://www.linkedin.com/feed/update/urn:li:activity:7307038025505505280" 
                       class="inline-flex items-center bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105">
                        Full Speech <i class="fas fa-play-circle ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- ADR Training -->
            <div id="adr-training" class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-primary-500 text-white px-8 py-6 relative">
                    <h2 class="text-3xl font-bold font-secondary">Alternative Dispute Resolution Training</h2>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-accent-500"></div>
                </div>
                
                <div class="p-8">
                    <div class="flex flex-wrap gap-6 mb-6 text-gray-600">
                        <span class="flex items-center">
                            <i class="fas fa-calendar mr-2 text-accent-500"></i> March 3-5, 2025
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-accent-500"></i> Clarion Hotel, Nairobi
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-users mr-2 text-accent-500"></i> 60 participants
                        </span>
                    </div>
                    
                    <p class="text-lg mb-8">In partnership with Refugee Consortium of Kenya (RCK), we conducted an intensive workshop on Alternative Dispute Resolution for refugees, host communities, and community counselors.</p>
                    
                    <div class="bg-accent-50 border-l-4 border-accent-500 p-6 mb-8">
                        <h5 class="font-bold text-primary-500 mb-4">Training Components:</h5>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>Kenya's Judicial System</strong> - Understanding courts and grassroots mechanisms</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>Alternative Justice Systems (AJS)</strong> - Human rights-based approaches</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>Forms of ADR</strong> - Negotiation, mediation, arbitration, traditional systems</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>Conflict Prevention & Peacebuilding</strong> - Root causes and reconciliation</span>
                            </li>
                        </ul>
                    </div>
                    
                    <blockquote class="italic relative pl-8 mb-8">
                        <div class="absolute left-0 top-0 text-4xl text-accent-500 font-serif">"</div>
                        <p class="text-gray-600 mb-2">The role-playing exercises gave me practical skills I've already used to mediate two land disputes in our community.</p>
                        <cite class="font-semibold text-primary-500 not-italic">- Community Peace Monitor, Kakuma</cite>
                    </blockquote>
                    
                    <a href="https://www.linkedin.com/feed/update/urn:li:activity:7304439267936632833" 
                       class="inline-flex items-center bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105">
                        Learn More <i class="fas fa-download ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Youth Leadership Conference -->
            <div id="leadership-conference" class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-primary-500 text-white px-8 py-6 relative">
                    <h2 class="text-3xl font-bold font-secondary">Youth Leadership Conference</h2>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-accent-500"></div>
                </div>
                
                <div class="p-8">
                    <div class="flex flex-wrap gap-6 mb-6 text-gray-600">
                        <span class="flex items-center">
                            <i class="fas fa-calendar mr-2 text-accent-500"></i> 2025
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-accent-500"></i> Nairobi
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-users mr-2 text-accent-500"></i> 150 emerging leaders
                        </span>
                    </div>
                    
                    <p class="text-lg mb-8">A transformative gathering focused on unleashing the leadership potential within African youth, emphasizing that leadership transcends titles and is about creating value and impact.</p>
                    
                    <div class="bg-accent-50 border-l-4 border-accent-500 p-6 mb-8">
                        <h5 class="font-bold text-primary-500 mb-4">Key Takeaways:</h5>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span>Leadership begins with <strong>self-discovery</strong> and purpose</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span>True leadership embodies <strong>service</strong> and systems that uplift others</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span>African youth must <strong>unite</strong> to address challenges</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span>Critical discussion on <strong>Democracy vs alternative systems</strong></span>
                            </li>
                        </ul>
                    </div>
                    
                    <blockquote class="italic relative pl-8 mb-8">
                        <div class="absolute left-0 top-0 text-4xl text-accent-500 font-serif">"</div>
                        <p class="text-gray-600 mb-2">The energy in the room was electric! For the first time, I saw how my small community project could grow into a movement.</p>
                        <cite class="font-semibold text-primary-500 not-italic">- Youth Participant from Kisumu</cite>
                    </blockquote>
                </div>
            </div>

            <!-- World Refugee Day -->
            <div id="refugee-day" class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-primary-500 text-white px-8 py-6 relative">
                    <h2 class="text-3xl font-bold font-secondary">World Refugee Day 2025</h2>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-accent-500"></div>
                </div>
                
                <div class="p-8">
                    <div class="flex flex-wrap gap-6 mb-6 text-gray-600">
                        <span class="flex items-center">
                            <i class="fas fa-calendar mr-2 text-accent-500"></i> June 20, 2025
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-accent-500"></i> Nairobi, Kenya
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-users mr-2 text-accent-500"></i> 500+ attendees
                        </span>
                    </div>
                    
                    <p class="text-lg mb-8">Our Regional Manager Bonkey Muhumure delivered a powerful keynote address standing in solidarity with refugees, joined by UNHCR, KNCHR, and refugee entrepreneurs.</p>
                    
                    <div class="bg-accent-50 border-l-4 border-accent-500 p-6 mb-8">
                        <h5 class="font-bold text-primary-500 mb-4">Event Highlights:</h5>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>Marketplace</strong> showcasing 30 refugee businesses</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span><strong>#SolidarityPledge</strong> - Corporates committed to hire 100+ refugees</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-2">•</span>
                                <span>Featured on <strong>NTV Kenya</strong> and launched podcast series</span>
                            </li>
                        </ul>
                    </div>
                    
                    <h4 class="text-xl font-bold text-primary-500 mb-4">Key Message:</h4>
                    <p class="text-lg font-semibold mb-8">"Refugees are not a burden; they are survivors, leaders, and contributors to our shared future."</p>
                    
                    <blockquote class="italic relative pl-8 mb-8">
                        <div class="absolute left-0 top-0 text-4xl text-accent-500 font-serif">"</div>
                        <p class="text-gray-600 mb-2">For the first time, I felt my refugee status wasn't a limitation but a story of resilience that could inspire others.</p>
                        <cite class="font-semibold text-primary-500 not-italic">- Refugee Entrepreneur Participant</cite>
                    </blockquote>
                    
                    <a href="https://www.linkedin.com/feed/update/urn:li:activity:7342142820201197568" 
                       class="inline-flex items-center bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105">
                        Read Article <i class="fas fa-microphone ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center py-16">
                <h2 class="text-4xl font-bold font-secondary text-primary-500 mb-6">Join Our Next Chapter</h2>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">Be part of creating more transformative moments across Kenya</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="/contact" class="bg-gradient-to-r from-accent-500 to-yellow-500 hover:from-accent-600 hover:to-yellow-600 text-white px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Partner With Us
                    </a>
                    <a href="/donate" class="bg-gradient-to-r from-primary-500 to-blue-600 hover:from-primary-600 hover:to-blue-700 text-white px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Donate
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 100,
                behavior: 'smooth'
            });
        }
    });
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>