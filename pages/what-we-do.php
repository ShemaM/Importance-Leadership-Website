<?php
// pages/what-we-do.php - What We Do Page with component architecture
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Our Programs | Youth Empowerment & Leadership Development | Importance Leadership";
$meta_description = "Discover our 5 transformative programs empowering refugee, IDP, and minority youth through advocacy, networking, mental health support, leadership development, and climate action.";
$meta_keywords = "programs, youth empowerment, leadership development, advocacy, networking, mental health, climate change";
$canonical_url = "https://www.importanceleadership.com/what-we-do";
$body_class = "what-we-do-page";

// Additional head content for what-we-do page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/programs-hero.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/programs-hero.jpg">
<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-float {
    animation: float 6s ease-in-out infinite;
}
.animate-fadeIn {
    animation: fadeIn 1s ease-in forwards;
}
.animate-fadeInUp {
    animation: fadeInUp 1s ease-out forwards;
}
.gradient-overlay {
    background: linear-gradient(135deg, rgba(11, 31, 58, 0.9) 0%, rgba(11, 31, 58, 0.7) 100%);
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
<main id="main-content">
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center text-white overflow-hidden">
        <!-- Background Video -->
        <div class="absolute inset-0 overflow-hidden">
            <video autoplay muted loop playsinline class="w-full h-full object-cover">
                <source src="/reference-files/image/program_video.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 gradient-overlay"></div>
        
        <!-- Content -->
        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold font-secondary mb-6 animate-fadeInUp text-white">
                Our Transformative Programs
            </h1>
            <p class="text-xl md:text-2xl mb-8 animate-fadeInUp opacity-95">
                Empowering refugee, IDP, and minority youth through advocacy, leadership, and sustainable development.
            </p>
            <a href="#programs" class="inline-block bg-accent-500 hover:bg-accent-600 text-white font-bold py-3 px-8 rounded-full transition-all transform hover:-translate-y-1 shadow-lg animate-fadeInUp">
                Explore Our Programs
            </a>
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 left-0 right-0 text-center animate-bounce">
            <a href="#programs" class="text-white text-2xl">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="programs" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary text-primary-500 mb-4">Our Five Pillars of Empowerment</h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-lg text-gray-600">At Importance Leadership, our mission is to empower youth particularly refugees, internally displaced persons (IDPs), and minorities through transformative, inclusive, and sustainable programs.</p>
            </div>
            
            <!-- Program 1: Advocacy -->
            <div class="flex flex-col lg:flex-row items-center gap-12 mb-28">
                <div class="lg:w-1/2 order-2 lg:order-1">
                    <div class="bg-white p-8 rounded-xl shadow-xl relative z-10">
                        <div class="flex items-center mb-6">
                            <div class="bg-primary-500 text-white font-bold rounded-full w-12 h-12 flex items-center justify-center mr-4">1</div>
                            <h3 class="text-2xl md:text-3xl font-bold font-secondary text-primary-500">Advocacy Initiatives</h3>
                        </div>
                        <p class="text-gray-600 mb-6">We believe that real change begins with strong, informed voices. Through our advocacy program, we identify and address pressing issues affecting refugees, IDPs, and minority groups, such as discriminatory policies, systemic exclusion, abandonment, and injustice.</p>
                        
                        <h4 class="font-bold text-primary-500 mb-3">Our Approach:</h4>
                        <ul class="space-y-3 mb-8 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Raising awareness through public forums, conferences, and workshops</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Issuing press releases and engaging in strategic litigation</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Organizing capacity-building trainings on rights and civic participation</span>
                            </li>
                        </ul>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                                Learn More
                            </a>
                            <a href="/contact" class="border border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                                Get Involved
                            </a>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2 order-1 lg:order-2 relative">
                    <div class="relative rounded-xl overflow-hidden shadow-xl h-96 lg:h-[500px]">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-transparent opacity-30"></div>
                        <img src="/reference-files/image/Importance_onGround.jpeg" 
                             alt="Group of diverse people at advocacy event" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-accent-500 text-primary-500 p-4 rounded-full shadow-xl">
                        <i class="fas fa-bullhorn text-3xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Program 2: Professional Networking -->
            <div class="flex flex-col lg:flex-row items-center gap-12 mb-28">
                <div class="lg:w-1/2 relative">
                    <div class="relative rounded-xl overflow-hidden shadow-xl h-96 lg:h-[500px]">
                        <div class="absolute inset-0 bg-gradient-to-l from-primary-500 to-transparent opacity-30"></div>
                        <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="Professionals networking at an event" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-accent-500 text-primary-500 p-4 rounded-full shadow-xl">
                        <i class="fas fa-network-wired text-3xl"></i>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <div class="bg-white p-8 rounded-xl shadow-xl relative z-10">
                        <div class="flex items-center mb-6">
                            <div class="bg-primary-500 text-white font-bold rounded-full w-12 h-12 flex items-center justify-center mr-4">2</div>
                            <h3 class="text-2xl md:text-3xl font-bold font-secondary text-primary-500">Professional Networking</h3>
                        </div>
                        <p class="text-gray-600 mb-6">We understand that access to professional networks is critical for career growth and innovation. This program bridges the gap between accomplished professionals and aspiring youth from diverse backgrounds.</p>
                        
                        <h4 class="font-bold text-primary-500 mb-3">Key Activities:</h4>
                        <ul class="space-y-3 mb-8 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Curated workshops and panel discussions</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Career exhibitions and networking events</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Collaborative learning platforms and idea-sharing sessions</span>
                            </li>
                        </ul>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                                Learn More
                            </a>
                            <a href="/join-us" class="border border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                                Join Our Network
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Program 3: Mental Health -->
            <div class="flex flex-col lg:flex-row items-center gap-12 mb-28">
                <div class="lg:w-1/2 order-2 lg:order-1">
                    <div class="bg-white p-8 rounded-xl shadow-xl relative z-10">
                        <div class="flex items-center mb-6">
                            <div class="bg-primary-500 text-white font-bold rounded-full w-12 h-12 flex items-center justify-center mr-4">3</div>
                            <h3 class="text-2xl md:text-3xl font-bold font-secondary text-primary-500">Mental Health Programs</h3>
                        </div>
                        <p class="text-gray-600 mb-6">We recognize that mental well-being is foundational to personal development and societal contribution. Many young people especially women, girls, refugees, and minorities face deep psychological challenges due to displacement, violence, and marginalization.</p>
                        
                        <h4 class="font-bold text-primary-500 mb-3">Our Services:</h4>
                        <ul class="space-y-3 mb-8 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Partnering with mental health professionals, medical practitioners, and psychologists</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Hosting in-person and virtual wellness forums</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Providing safe spaces for open dialogue, healing, and emotional support</span>
                            </li>
                        </ul>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                                Learn More
                            </a>
                            <a href="/contact" class="border border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                                Request Support
                            </a>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2 order-1 lg:order-2 relative">
                    <div class="relative rounded-xl overflow-hidden shadow-xl h-96 lg:h-[500px]">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-transparent opacity-30"></div>
                        <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80" 
                             alt="Counselor speaking with young woman" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-accent-500 text-primary-500 p-4 rounded-full shadow-xl">
                        <i class="fas fa-heart text-3xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Program 4: Leadership Development -->
            <div class="flex flex-col lg:flex-row items-center gap-12 mb-28">
                <div class="lg:w-1/2 relative">
                    <div class="relative rounded-xl overflow-hidden shadow-xl h-96 lg:h-[500px]">
                        <div class="absolute inset-0 bg-gradient-to-l from-primary-500 to-transparent opacity-30"></div>
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="Young leader speaking at a conference" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-accent-500 text-primary-500 p-4 rounded-full shadow-xl">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <div class="bg-white p-8 rounded-xl shadow-xl relative z-10">
                        <div class="flex items-center mb-6">
                            <div class="bg-primary-500 text-white font-bold rounded-full w-12 h-12 flex items-center justify-center mr-4">4</div>
                            <h3 class="text-2xl md:text-3xl font-bold font-secondary text-primary-500">Leadership Development</h3>
                        </div>
                        <p class="text-gray-600 mb-6">We are committed to cultivating visionary and ethical leaders from underrepresented communities. Through this program, we equip youth with the skills, knowledge, and confidence they need to lead change in their societies.</p>
                        
                        <h4 class="font-bold text-primary-500 mb-3">Program Components:</h4>
                        <ul class="space-y-3 mb-8 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Intensive training on leadership, communication, and decision-making</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Leadership conferences and workshops led by expert facilitators</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Ongoing mentorship and opportunities to lead real-life initiatives</span>
                            </li>
                        </ul>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                                Learn More
                            </a>
                            <a href="#" class="border border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                                Apply Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Program 5: Climate Change Awareness -->
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2 order-2 lg:order-1">
                    <div class="bg-white p-8 rounded-xl shadow-xl relative z-10">
                        <div class="flex items-center mb-6">
                            <div class="bg-primary-500 text-white font-bold rounded-full w-12 h-12 flex items-center justify-center mr-4">5</div>
                            <h3 class="text-2xl md:text-3xl font-bold font-secondary text-primary-500">Climate Change Awareness</h3>
                        </div>
                        <p class="text-gray-600 mb-6">Climate change is a global reality that demands local action. This program educates communities especially the youth on the causes, effects, and mitigation of climate change. We aim to build eco-conscious generations who understand their role in environmental stewardship.</p>
                        
                        <h4 class="font-bold text-primary-500 mb-3">Our Initiatives:</h4>
                        <ul class="space-y-3 mb-8 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Community sensitization and grassroots outreach campaigns</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Workshops, conferences, and school programs on climate literacy</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-accent-500 mr-3 mt-1">•</span>
                                <span>Development of action plans and contributions to policy dialogues</span>
                            </li>
                        </ul>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2 order-1 lg:order-2 relative">
                    <div class="relative rounded-xl overflow-hidden shadow-xl h-96 lg:h-[500px]">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-transparent opacity-30"></div>
                        <img src="https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="Youth planting trees in community" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-accent-500 text-primary-500 p-4 rounded-full shadow-xl">
                        <i class="fas fa-leaf text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Section -->
    <section class="py-20 bg-primary-500 text-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary text-white mb-4">Our Impact</h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl max-w-3xl mx-auto">Through our programs, we've transformed thousands of lives and communities.</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white bg-opacity-10 p-8 rounded-xl text-center backdrop-blur-sm border border-white border-opacity-20">
                    <div class="text-5xl font-bold text-accent-500 mb-3">1,200+</div>
                    <h3 class="text-xl font-semibold mb-2">Youth Empowered</h3>
                    <p class="text-white text-opacity-80">Through our leadership programs</p>
                </div>
                
                <div class="bg-white bg-opacity-10 p-8 rounded-xl text-center backdrop-blur-sm border border-white border-opacity-20">
                    <div class="text-5xl font-bold text-accent-500 mb-3">85+</div>
                    <h3 class="text-xl font-semibold mb-2">Advocacy Campaigns</h3>
                    <p class="text-white text-opacity-80">Addressing systemic issues</p>
                </div>
                
                <div class="bg-white bg-opacity-10 p-8 rounded-xl text-center backdrop-blur-sm border border-white border-opacity-20">
                    <div class="text-5xl font-bold text-accent-500 mb-3">500+</div>
                    <h3 class="text-xl font-semibold mb-2">Mental Health Sessions</h3>
                    <p class="text-white text-opacity-80">Providing critical support</p>
                </div>
                
                <div class="bg-white bg-opacity-10 p-8 rounded-xl text-center backdrop-blur-sm border border-white border-opacity-20">
                    <div class="text-5xl font-bold text-accent-500 mb-3">30+</div>
                    <h3 class="text-xl font-semibold mb-2">Communities Reached</h3>
                    <p class="text-white text-opacity-80">With climate action programs</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-12 text-white text-center">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary mb-6">Join Our Movement</h2>
                <p class="text-xl max-w-3xl mx-auto mb-8">Whether you want to volunteer, partner with us, or support our work financially, there are many ways to get involved.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="/donate" class="bg-accent-500 hover:bg-accent-600 text-white font-bold py-3 px-8 rounded-full transition transform hover:-translate-y-1 shadow-lg">
                        Donate Now
                    </a>
                    <a href="/contact" class="bg-transparent hover:bg-white hover:text-primary-500 border-2 border-white font-bold py-3 px-8 rounded-full transition transform hover:-translate-y-1">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Back to Top Button -->
<button id="backToTop" class="fixed bottom-8 right-8 bg-accent-500 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-xl opacity-0 invisible transition-all z-50">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
// Back to top button
const backToTopButton = document.getElementById('backToTop');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        backToTopButton.classList.remove('opacity-0', 'invisible');
        backToTopButton.classList.add('opacity-100', 'visible');
    } else {
        backToTopButton.classList.remove('opacity-100', 'visible');
        backToTopButton.classList.add('opacity-0', 'invisible');
    }
});

backToTopButton.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>