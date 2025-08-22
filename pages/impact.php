<?php
// pages/impact.php - Impact Page with component architecture
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Our Impact | Youth Empowerment & Community Transformation | Importance Leadership";
$meta_description = "Discover the measurable impact of Importance Leadership on youth empowerment, community development, and leadership training programs. See our success stories and transformations.";
$meta_keywords = "impact, youth empowerment, leadership development, community transformation, success stories, statistics";
$canonical_url = "https://www.importanceleadership.com/impact";
$body_class = "impact-page";

// Additional head content for impact page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/backgrounds/impact-hero.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/backgrounds/impact-hero.jpg">
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
@keyframes counterUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
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
.animate-counterUp {
    animation: counterUp 0.8s ease-out forwards;
}
.gradient-overlay {
    background: linear-gradient(135deg, rgba(11, 31, 58, 0.9) 0%, rgba(11, 31, 58, 0.7) 100%);
}
.stat-card {
    transition: all 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-10px);
}
.story-card {
    transition: all 0.3s ease;
}
.story-card:hover {
    transform: translateY(-10px);
}
.story-card img {
    transition: all 0.3s ease;
}
.story-card:hover img {
    transform: scale(1.05);
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
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="/reference-files/image/bg-impact.jpg" 
                 alt="Impact Background" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 gradient-overlay"></div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-left lg:text-left">
                    <span class="inline-block bg-accent-500 text-primary-500 px-4 py-2 rounded-full text-sm font-bold mb-4 animate-fadeInUp">
                        IMPACT
                    </span>
                    <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6 animate-fadeInUp text-white">
                        Our Measurable Impact
                    </h1>
                    <p class="text-xl md:text-2xl mb-6 opacity-95 animate-fadeInUp">
                        Transforming lives through leadership development, mentorship, and community empowerment initiatives that create lasting change.
                    </p>
                    <a href="#our-stats" class="inline-block bg-accent-500 hover:bg-accent-600 text-white font-bold py-3 px-8 rounded-full transition-all transform hover:-translate-y-1 shadow-lg animate-fadeInUp">
                        <i class="fas fa-chart-line mr-2"></i>View Our Results
                    </a>
                </div>
                
                <!-- Image Content -->
                <div class="flex justify-center items-center animate-fadeInUp">
                    <div class="w-full max-w-md">
                        <img src="/reference-files/image/impacted.jpg" 
                             alt="Impact Illustration" 
                             class="w-full h-80 object-cover rounded-2xl shadow-xl">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 left-0 right-0 text-center animate-bounce">
            <a href="#our-stats" class="text-white text-2xl">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="our-stats" class="py-20 bg-primary-500 text-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary text-white mb-4">By The Numbers</h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl max-w-3xl mx-auto">Quantifying our commitment to youth development and community transformation</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="stat-card bg-white bg-opacity-10 p-8 rounded-xl text-center backdrop-blur-sm border border-white border-opacity-20">
                    <div class="text-5xl font-bold text-accent-500 mb-3 stat-number" data-count="2500">0+</div>
                    <h3 class="text-xl font-semibold mb-2">Youth Empowered</h3>
                    <p class="text-white text-opacity-80">Through our leadership programs and initiatives</p>
                    <i class="fas fa-users text-3xl mt-4 text-accent-500"></i>
                </div>
                
                <div class="stat-card bg-white bg-opacity-10 p-8 rounded-xl text-center backdrop-blur-sm border border-white border-opacity-20">
                    <div class="text-5xl font-bold text-accent-500 mb-3 stat-number" data-count="20">0+</div>
                    <h3 class="text-xl font-semibold mb-2">Dedicated Mentors</h3>
                    <p class="text-white text-opacity-80">Guiding the next generation of leaders</p>
                    <i class="fas fa-user-tie text-3xl mt-4 text-accent-500"></i>
                </div>
                
                <div class="stat-card bg-white bg-opacity-10 p-8 rounded-xl text-center backdrop-blur-sm border border-white border-opacity-20">
                    <div class="text-5xl font-bold text-accent-500 mb-3 stat-number" data-count="13">0</div>
                    <h3 class="text-xl font-semibold mb-2">Workshops</h3>
                    <p class="text-white text-opacity-80">Leadership training and skill development</p>
                    <i class="fas fa-chalkboard-teacher text-3xl mt-4 text-accent-500"></i>
                </div>
                
                <div class="stat-card bg-white bg-opacity-10 p-8 rounded-xl text-center backdrop-blur-sm border border-white border-opacity-20">
                    <div class="text-5xl font-bold text-accent-500 mb-3 stat-number" data-count="14">0</div>
                    <h3 class="text-xl font-semibold mb-2">Communities</h3>
                    <p class="text-white text-opacity-80">Positively impacted across the region</p>
                    <i class="fas fa-globe-africa text-3xl mt-4 text-accent-500"></i>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="/join-us" class="bg-accent-500 hover:bg-accent-600 text-white font-bold py-3 px-8 rounded-full transition-all transform hover:-translate-y-1 shadow-lg">
                    <i class="fas fa-hands-helping mr-2"></i>Join Our Mission
                </a>
            </div>
        </div>
    </section>

    <!-- Success Stories Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary text-primary-500 mb-4">Success Stories</h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl max-w-3xl mx-auto text-gray-600">Real impact through our leadership programs and community initiatives</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Story 1: Eastern Congo Crisis -->
                <div class="story-card bg-white rounded-xl shadow-xl overflow-hidden">
                    <div class="relative h-64">
                        <img src="/reference-files/image/easterncongocrisis.jpg" 
                             alt="Eastern Congo Crisis Discussion" 
                             class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-accent-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Discussion</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-primary-500 mb-3">The Eastern Congo Crisis</h3>
                        <p class="text-gray-600 mb-4">Global youth collaborated to propose innovative solutions to the humanitarian crisis.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                            Read Full Story
                        </a>
                    </div>
                </div>
                
                <!-- Story 2: Leadership Conference -->
                <div class="story-card bg-white rounded-xl shadow-xl overflow-hidden">
                    <div class="relative h-64">
                        <img src="/reference-files/image/leadershipDevelopemnt.jpg" 
                             alt="Leadership Conference Workshop" 
                             class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-accent-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Workshop</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-primary-500 mb-3">Leadership Conference</h3>
                        <p class="text-gray-600 mb-4">Inspiring young leaders to take charge and create meaningful impact in their communities.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                            Read Full Story
                        </a>
                    </div>
                </div>
                
                <!-- Story 3: Back to School Drive -->
                <div class="story-card bg-white rounded-xl shadow-xl overflow-hidden">
                    <div class="relative h-64">
                        <img src="/reference-files/image/backToSchool.jpeg" 
                             alt="Back to School Drive Event" 
                             class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-accent-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Community</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-primary-500 mb-3">Back To School Drive</h3>
                        <p class="text-gray-600 mb-4">Providing essential support to refugee orphan school children in Nairobi.</p>
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-6 rounded-full transition transform hover:-translate-y-1">
                            Read Full Story
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-primary-500 text-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary text-white mb-4">Voices of Impact</h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl max-w-3xl mx-auto">What our community members say about our programs</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white bg-opacity-10 p-8 rounded-xl backdrop-blur-sm border border-white border-opacity-20">
                    <div class="relative">
                        <i class="fas fa-quote-left text-3xl text-accent-500 mb-4"></i>
                        <p class="text-white text-opacity-90 mb-6 italic">The leadership workshop transformed my perspective on community service. I've since started my own initiative to mentor younger students in my neighborhood.</p>
                    </div>
                    <div class="flex items-center">
                        <div>
                            <h4 class="font-bold text-white">Sarah K.</h4>
                            <p class="text-white text-opacity-70 text-sm">Youth Program Participant</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white bg-opacity-10 p-8 rounded-xl backdrop-blur-sm border border-white border-opacity-20">
                    <div class="relative">
                        <i class="fas fa-quote-left text-3xl text-accent-500 mb-4"></i>
                        <p class="text-white text-opacity-90 mb-6 italic">As a mentor, I've witnessed incredible growth in the young leaders we work with. The structured programs provide exactly what youth need to thrive.</p>
                    </div>
                    <div class="flex items-center">
                        <div>
                            <h4 class="font-bold text-white">David M.</h4>
                            <p class="text-white text-opacity-70 text-sm">Program Mentor</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white bg-opacity-10 p-8 rounded-xl backdrop-blur-sm border border-white border-opacity-20">
                    <div class="relative">
                        <i class="fas fa-quote-left text-3xl text-accent-500 mb-4"></i>
                        <p class="text-white text-opacity-90 mb-6 italic">Our community has been revitalized through the leadership initiatives. The youth programs have reduced delinquency and increased educational engagement.</p>
                    </div>
                    <div class="flex items-center">
                        <div>
                            <h4 class="font-bold text-white">Grace W.</h4>
                            <p class="text-white text-opacity-70 text-sm">Community Leader</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feedback Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl md:text-4xl font-bold font-secondary text-primary-500 mb-4">Share Your Story</h2>
                        <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                        <p class="text-xl text-gray-600">We'd love to hear about your experience with Importance Leadership</p>
                    </div>
                    
                    <form action="/forms/feedback-handler.php" method="POST" id="impactFeedbackForm" class="space-y-6">
                        <!-- Success Message (Initially Hidden) -->
                        <div id="successMessage" class="hidden bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg text-center">
                            <i class="fas fa-check-circle text-2xl mb-2"></i>
                            <h4 class="font-bold text-lg">Thank You!</h4>
                            <p>Your feedback has been successfully submitted.</p>
                        </div>
                        
                        <!-- Form Fields -->
                        <div id="formFields" class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-gray-700 font-semibold mb-2">Your Name</label>
                                    <input type="text" id="name" name="name" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500" 
                                           placeholder="Enter your name">
                                </div>
                                <div>
                                    <label for="email" class="block text-gray-700 font-semibold mb-2">Your Email</label>
                                    <input type="email" id="email" name="email" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500" 
                                           placeholder="Enter your email">
                                </div>
                            </div>
                            
                            <div>
                                <label for="program" class="block text-gray-700 font-semibold mb-2">Program/Initiative</label>
                                <select id="program" name="program" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500">
                                    <option value="" disabled selected>Select a program</option>
                                    <option value="Youth Empowerment">Youth Empowerment</option>
                                    <option value="Mentorship">Mentorship</option>
                                    <option value="Workshops">Workshops</option>
                                    <option value="Community Support">Community Support</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="feedback" class="block text-gray-700 font-semibold mb-2">Your Experience</label>
                                <textarea id="feedback" name="feedback" rows="5" required 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500" 
                                          placeholder="Share your story with us..."></textarea>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-8 rounded-full transition-all transform hover:-translate-y-1 shadow-lg">
                                    <i class="fas fa-paper-plane mr-2"></i>Share Your Story
                                </button>
                            </div>
                        </div>
                    </form>
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

// Animate stat counters
const animateCounters = () => {
    const counters = document.querySelectorAll('.stat-number');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        const current = parseInt(counter.innerText.replace(/\D/g, '')) || 0;
        const increment = target / 100;
        
        if (current < target) {
            const newValue = Math.ceil(current + increment);
            if (target >= 20) {
                counter.innerText = newValue + '+';
            } else {
                counter.innerText = newValue;
            }
            setTimeout(() => animateCounters(), 30);
        } else {
            if (target >= 20) {
                counter.innerText = target + '+';
            } else {
                counter.innerText = target;
            }
        }
    });
};

// Start counter animation when stats section comes into view
const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateCounters();
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

const statsSection = document.getElementById('our-stats');
if (statsSection) {
    observer.observe(statsSection);
}

// Form submission handler
const feedbackForm = document.getElementById('impactFeedbackForm');
if (feedbackForm) {
    feedbackForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // In a real implementation, this would submit to the backend
        // This is a simulation for demo purposes
        const formFields = document.getElementById('formFields');
        const successMessage = document.getElementById('successMessage');
        
        // Hide form and show success message
        formFields.classList.add('hidden');
        successMessage.classList.remove('hidden');
        
        // Reset form after 5 seconds
        setTimeout(() => {
            formFields.classList.remove('hidden');
            successMessage.classList.add('hidden');
            feedbackForm.reset();
        }, 5000);
    });
}

// Add scroll-triggered animations
const observeElements = document.querySelectorAll('.story-card, .stat-card');
const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animationDelay = Math.random() * 0.3 + 's';
            entry.target.classList.add('animate-fadeInUp');
        }
    });
}, { threshold: 0.1 });

observeElements.forEach(el => scrollObserver.observe(el));
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>