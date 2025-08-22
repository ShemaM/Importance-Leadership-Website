<?php
// pages/leadership-development.php - Leadership Development Program Page
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Leadership Development Program | Importance Leadership - Empowering African Leaders";
$meta_description = "12-week transformative leadership development program for emerging African leaders. Build core competencies through workshops, mentorship, and real-world projects.";
$meta_keywords = "leadership development, African leaders, leadership training, mentorship program, leadership skills, Africa leadership";
$canonical_url = "https://www.importanceleadership.com/programs/leadership-development";
$body_class = "leadership-development-page";

// Additional head content
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/programs/leadership-development.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/programs/leadership-development.jpg">';

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
                 style="background-image: url('/reference-files/image/leadershipDevelopemnt.jpg')"></div>
        </div>
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/85 to-primary-700/90 z-10"></div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-20 py-8">
            <div class="max-w-4xl mx-auto text-center">
                <span class="inline-block bg-accent-500/20 px-6 py-3 rounded-full text-accent-300 font-semibold mb-6 text-xl" data-aos="fade-up" data-aos-delay="100">
                    12-Week Program
                </span>
                
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6" data-aos="fade-up" data-aos-delay="200">
                    Leadership Development Program
                </h1>
                
                <p class="text-xl md:text-2xl mb-8 opacity-95 max-w-4xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="300">
                    Transformative leadership training for emerging African leaders to develop core competencies through workshops, real-world projects, and mentorship.
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="400">
                    <a href="#apply" class="bg-accent-500 hover:bg-accent-600 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        Apply Now
                    </a>
                    <a href="#curriculum" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300">
                        Program Details
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Scroll Down Arrow -->
        <div class="absolute bottom-10 left-0 right-0 text-center animate-bounce">
            <a href="#stats" class="text-white text-2xl" aria-label="Scroll down">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Program Stats -->
    <section id="stats" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-5xl md:text-6xl font-bold text-primary-500 mb-4" data-count="500">0</div>
                    <h3 class="text-xl font-semibold font-secondary text-gray-900 mb-2">Graduates</h3>
                    <p class="text-gray-600">Empowered leaders across Africa</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-5xl md:text-6xl font-bold text-primary-500 mb-4" data-count="85">0</div>
                    <h3 class="text-xl font-semibold font-secondary text-gray-900 mb-2">Success Rate</h3>
                    <p class="text-gray-600">Career advancement post-program</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-5xl md:text-6xl font-bold text-primary-500 mb-4" data-count="32">0</div>
                    <h3 class="text-xl font-semibold font-secondary text-gray-900 mb-2">Countries</h3>
                    <p class="text-gray-600">Represented in our alumni network</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Features -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Program Highlights
                </h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Develop essential leadership skills for Africa's future
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-primary-100 text-primary-500 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chess-king text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Ethical Leadership</h3>
                    <p class="text-gray-600">Develop strong moral foundations for decision-making in complex African contexts</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-primary-100 text-primary-500 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bullseye text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Strategic Vision</h3>
                    <p class="text-gray-600">Learn to create and execute impactful plans for community development</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-primary-100 text-primary-500 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-project-diagram text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Real Projects</h3>
                    <p class="text-gray-600">Apply skills to actual community challenges with measurable impact</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-primary-100 text-primary-500 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-tie text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Mentorship</h3>
                    <p class="text-gray-600">Personal guidance from experienced African leaders and executives</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Curriculum Section -->
    <section id="curriculum" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right">
                    <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">Program Structure</h2>
                    <p class="text-xl text-gray-600 mb-8">Our intensive 12-week program combines theory with practical application:</p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-accent-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-lg text-gray-600">Weekly interactive workshops with African leadership experts</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-accent-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-lg text-gray-600">Monthly community development projects</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-accent-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-lg text-gray-600">Bi-weekly one-on-one mentorship sessions</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-accent-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-lg text-gray-600">Final capstone presentation to industry leaders</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-accent-500 mt-1 mr-3 flex-shrink-0"></i>
                            <span class="text-lg text-gray-600">Ongoing alumni network and support</span>
                        </li>
                    </ul>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#apply" class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-4 rounded-lg font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            Apply Now
                        </a>
                        <a href="/reference-files/downloads/leadership-program-brochure.pdf" class="bg-white border-2 border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white px-8 py-4 rounded-lg font-bold text-lg transition-all duration-300" download>
                            Download Brochure
                        </a>
                    </div>
                </div>
                <div data-aos="fade-left">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <img src="/reference-files/image/leadership-training-session.jpg" alt="Leadership training session in progress" class="w-full h-64 object-cover">
                        <div class="p-8">
                            <h3 class="text-2xl font-bold font-secondary text-primary-500 mb-6">2024 Program Schedule</h3>
                            <ul class="space-y-3">
                                <li><strong class="text-primary-500">Cohort 1:</strong> January 15 - April 5</li>
                                <li><strong class="text-primary-500">Cohort 2:</strong> May 6 - July 26</li>
                                <li><strong class="text-primary-500">Cohort 3:</strong> September 2 - November 22</li>
                            </ul>
                            <p class="text-sm text-gray-600 mt-4">Applications accepted on rolling basis. Early applications receive priority consideration.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Alumni Success Stories
                </h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Hear from our graduates about their leadership journeys
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-8 text-center" data-aos="fade-up" data-aos-delay="100">
                    <img src="/reference-files/image/alumni-1.jpg" alt="John M., Program Graduate" class="w-20 h-20 rounded-full mx-auto mb-6 object-cover">
                    <div class="mb-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"This program transformed my approach to leadership. Within 6 months of completing the program, I was promoted to a management position at my organization."</p>
                    <h5 class="font-bold text-primary-500 text-lg">John M.</h5>
                    <p class="text-gray-500">Community Development Manager, Kenya</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 text-center" data-aos="fade-up" data-aos-delay="200">
                    <img src="/reference-files/image/alumni-2.jpg" alt="Amina K., Program Graduate" class="w-20 h-20 rounded-full mx-auto mb-6 object-cover">
                    <div class="mb-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"The mentorship I received gave me the confidence to launch my social enterprise. We've now impacted over 5,000 women in rural Nigeria."</p>
                    <h5 class="font-bold text-primary-500 text-lg">Amina K.</h5>
                    <p class="text-gray-500">Social Entrepreneur, Nigeria</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 text-center" data-aos="fade-up" data-aos-delay="300">
                    <img src="/reference-files/image/alumni-3.jpg" alt="David T., Program Graduate" class="w-20 h-20 rounded-full mx-auto mb-6 object-cover">
                    <div class="mb-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"The practical projects were game-changing. I applied what I learned immediately in my community, leading to tangible improvements in local education access."</p>
                    <h5 class="font-bold text-primary-500 text-lg">David T.</h5>
                    <p class="text-gray-500">Education Advocate, South Africa</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Apply Section -->
    <section id="apply" class="py-20 bg-primary-500 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto" data-aos="zoom-in">
                <div class="text-center mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold font-secondary mb-6">Join Our Next Cohort</h2>
                    <p class="text-xl opacity-95">Applications are now open for emerging African leaders</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 md:p-12 text-gray-900">
                    <h3 class="text-3xl font-bold font-secondary text-center mb-8 text-primary-500">Leadership Development Program Application</h3>
                    <form class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="firstName" class="block text-gray-700 font-semibold mb-2">First Name <span class="text-red-500">*</span></label>
                                <input type="text" id="firstName" name="firstName" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="lastName" class="block text-gray-700 font-semibold mb-2">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" id="lastName" name="lastName" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-gray-700 font-semibold mb-2">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone Number <span class="text-red-500">*</span></label>
                                <input type="tel" id="phone" name="phone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="country" class="block text-gray-700 font-semibold mb-2">Country <span class="text-red-500">*</span></label>
                                <select id="country" name="country" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option value="">Select Country</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Rwanda">Rwanda</option>
                                </select>
                            </div>
                            <div>
                                <label for="age" class="block text-gray-700 font-semibold mb-2">Age <span class="text-red-500">*</span></label>
                                <input type="number" id="age" name="age" min="18" max="45" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                        </div>
                        <div>
                            <label for="currentRole" class="block text-gray-700 font-semibold mb-2">Current Role/Organization</label>
                            <input type="text" id="currentRole" name="currentRole" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="leadershipExperience" class="block text-gray-700 font-semibold mb-2">Briefly describe your leadership experience <span class="text-red-500">*</span></label>
                            <textarea id="leadershipExperience" name="leadershipExperience" rows="3" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                        </div>
                        <div>
                            <label for="motivation" class="block text-gray-700 font-semibold mb-2">Why do you want to join this program? (300 words max) <span class="text-red-500">*</span></label>
                            <textarea id="motivation" name="motivation" rows="4" maxlength="2000" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                        </div>
                        <div>
                            <label for="goals" class="block text-gray-700 font-semibold mb-2">What leadership impact do you hope to achieve through this program? (300 words max) <span class="text-red-500">*</span></label>
                            <textarea id="goals" name="goals" rows="4" maxlength="2000" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                        </div>
                        <div class="text-center mt-8">
                            <button type="submit" class="bg-accent-500 hover:bg-accent-600 text-white px-12 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Frequently Asked Questions
                </h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Answers to common questions about our Leadership Development Program
                </p>
            </div>
            
            <div class="max-w-4xl mx-auto space-y-6">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <button class="w-full text-left p-6 font-bold text-lg text-primary-500 hover:bg-gray-50 transition-colors duration-300" onclick="toggleFAQ(1)">
                        <div class="flex justify-between items-center">
                            <span>Who is eligible to apply for the program?</span>
                            <i class="fas fa-chevron-down transform transition-transform duration-300" id="faq-icon-1"></i>
                        </div>
                    </button>
                    <div class="hidden p-6 pt-0 text-gray-600" id="faq-content-1">
                        The program is open to emerging African leaders aged 18-45 who demonstrate leadership potential and commitment to community development. We welcome applicants from all professional backgrounds and educational levels.
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <button class="w-full text-left p-6 font-bold text-lg text-primary-500 hover:bg-gray-50 transition-colors duration-300" onclick="toggleFAQ(2)">
                        <div class="flex justify-between items-center">
                            <span>What is the time commitment required?</span>
                            <i class="fas fa-chevron-down transform transition-transform duration-300" id="faq-icon-2"></i>
                        </div>
                    </button>
                    <div class="hidden p-6 pt-0 text-gray-600" id="faq-content-2">
                        The program requires approximately 8-10 hours per week, including:
                        <ul class="list-disc list-inside mt-3 space-y-1">
                            <li>2-hour weekly workshop (virtual)</li>
                            <li>1-hour bi-weekly mentorship session</li>
                            <li>3-5 hours for project work and assignments</li>
                        </ul>
                        We understand participants have other commitments and design the schedule to be manageable.
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <button class="w-full text-left p-6 font-bold text-lg text-primary-500 hover:bg-gray-50 transition-colors duration-300" onclick="toggleFAQ(3)">
                        <div class="flex justify-between items-center">
                            <span>Is there a cost to participate?</span>
                            <i class="fas fa-chevron-down transform transition-transform duration-300" id="faq-icon-3"></i>
                        </div>
                    </button>
                    <div class="hidden p-6 pt-0 text-gray-600" id="faq-content-3">
                        Thanks to our generous donors, the program is fully funded for selected participants. There is no tuition fee. We only ask for your full commitment to the program and willingness to apply what you learn in your community.
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <button class="w-full text-left p-6 font-bold text-lg text-primary-500 hover:bg-gray-50 transition-colors duration-300" onclick="toggleFAQ(4)">
                        <div class="flex justify-between items-center">
                            <span>What happens after I complete the program?</span>
                            <i class="fas fa-chevron-down transform transition-transform duration-300" id="faq-icon-4"></i>
                        </div>
                    </button>
                    <div class="hidden p-6 pt-0 text-gray-600" id="faq-content-4">
                        Graduates become part of our active alumni network with ongoing benefits:
                        <ul class="list-disc list-inside mt-3 space-y-1">
                            <li>Access to advanced leadership resources</li>
                            <li>Opportunities for continued mentorship</li>
                            <li>Invitations to exclusive events and webinars</li>
                            <li>Potential funding opportunities for community projects</li>
                            <li>Networking with other alumni across Africa</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
function toggleFAQ(id) {
    const content = document.getElementById(`faq-content-${id}`);
    const icon = document.getElementById(`faq-icon-${id}`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Counter animation
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('[data-count]');
    let animationTriggered = false;
    
    function animateCounters() {
        if (animationTriggered) return;
        
        const statsSection = document.getElementById('stats');
        const rect = statsSection.getBoundingClientRect();
        
        if (rect.top < window.innerHeight && rect.bottom >= 0) {
            animationTriggered = true;
            
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 20);
            });
        }
    }
    
    window.addEventListener('scroll', animateCounters);
    animateCounters(); // Check on load
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>