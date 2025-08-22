<?php
// pages/contact.php - Contact Page with component architecture
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Contact Us | Connect With Our Team | Importance Leadership";
$meta_description = "Get in touch with Importance Leadership. Contact us via WhatsApp, email, or phone for inquiries about our youth empowerment programs across Kenya, USA, and Canada.";
$meta_keywords = "contact us, importance leadership, youth empowerment contact, leadership programs, Kenya contact, USA contact, Canada contact, WhatsApp support";
$canonical_url = "https://www.importanceleadership.com/contact";
$body_class = "contact-page";

// Additional head content for contact page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/contact-hero.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/contact-hero.jpg">
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}
@keyframes slideInLeft {
    0% { opacity: 0; transform: translateX(-30px); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes slideInRight {
    0% { opacity: 0; transform: translateX(30px); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}
.animate-float {
    animation: float 3s ease-in-out infinite;
}
.animate-fadeIn {
    animation: fadeIn 1s ease-in forwards;
}
.animate-fadeInUp {
    animation: fadeInUp 1s ease-out forwards;
}
.animate-slideInLeft {
    animation: slideInLeft 0.8s ease-out forwards;
}
.animate-slideInRight {
    animation: slideInRight 0.8s ease-out forwards;
}
.animate-pulse-custom {
    animation: pulse 2s ease-in-out infinite;
}
.gradient-overlay {
    background: linear-gradient(135deg, rgba(11, 31, 58, 0.95) 0%, rgba(11, 31, 58, 0.85) 100%);
}
.contact-card {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    backdrop-filter: blur(10px);
}
.contact-card:hover {
    transform: translateY(-10px) scale(1.02);
}
.whatsapp-card {
    transition: all 0.3s ease;
}
.whatsapp-card:hover {
    transform: translateY(-8px) scale(1.02);
}
.contact-form {
    transition: all 0.3s ease;
}
.contact-form:hover {
    transform: translateY(-5px);
}
.form-input {
    transition: all 0.3s ease;
}
.form-input:focus {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(11, 31, 58, 0.15);
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
    <section class="relative min-h-[70vh] flex items-center justify-center text-white overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" 
                 alt="Team collaboration and communication" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 gradient-overlay"></div>
        </div>
        
        
        <!-- Content -->
        <div class="container mx-auto px-6 relative z-10 text-center">
            <div class="max-w-4xl mx-auto">
                <span class="inline-block bg-accent-500 text-primary-500 px-4 py-2 rounded-full text-sm font-bold mb-6 animate-fadeInUp">
                    GET IN TOUCH
                </span>
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6 animate-fadeInUp">
                    Connect With Our Team
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-95 animate-fadeInUp max-w-3xl mx-auto">
                    We're here to answer your questions and discuss how we can work together to create positive change in our communities.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fadeInUp">
                    <a href="#whatsapp" class="inline-flex items-center bg-white text-primary-500 hover:bg-gray-100 font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:-translate-y-1 shadow-xl">
                        <i class="fas fa-paper-plane mr-3 text-xl"></i>
                        Send a Message
                    </a>
                    <a href="#contact-form" class="inline-flex items-center border-2 border-white text-white hover:bg-white hover:text-primary-500 font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:-translate-y-1">
                        <i class="fas fa-envelope mr-3 text-xl"></i>
                        Contact Form
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- WhatsApp Support Section -->
    <section class="py-20 bg-gray-50" id="whatsapp">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary text-primary-500 mb-4">WhatsApp Support</h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Message us directly on WhatsApp for quick assistance and instant communication
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <!-- Kenya WhatsApp -->
                <div class="whatsapp-card bg-white rounded-2xl shadow-xl p-8 text-center border-t-4 border-green-500">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fab fa-whatsapp text-green-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Kenya Support</h3>
                    <p class="text-gray-600 mb-6">Available for our Kenya Branch programs and initiatives</p>
                    <a href="https://wa.me/254791263998" target="_blank" 
                       class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-full transition-all transform hover:-translate-y-1 shadow-lg">
                        <i class="fab fa-whatsapp mr-2"></i>
                        +254 791 263998
                    </a>
                </div>
                
                <!-- USA WhatsApp -->
                <div class="whatsapp-card bg-white rounded-2xl shadow-xl p-8 text-center border-t-4 border-blue-500">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fab fa-whatsapp text-blue-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">USA Support</h3>
                    <p class="text-gray-600 mb-6">Dedicated line for our USA Branch operations</p>
                    <a href="https://wa.me/16037150801" target="_blank" 
                       class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-full transition-all transform hover:-translate-y-1 shadow-lg">
                        <i class="fab fa-whatsapp mr-2"></i>
                        +1 (603) 715-0801
                    </a>
                </div>
                
                <!-- Canada WhatsApp -->
                <div class="whatsapp-card bg-white rounded-2xl shadow-xl p-8 text-center border-t-4 border-red-500">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fab fa-whatsapp text-red-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Canada Support</h3>
                    <p class="text-gray-600 mb-6">Specialized assistance for the Canada Branch</p>
                    <a href="https://wa.me/14319988892" target="_blank" 
                       class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-full transition-all transform hover:-translate-y-1 shadow-lg">
                        <i class="fab fa-whatsapp mr-2"></i>
                        +1 (431) 998-8892
                    </a>
                </div>
            </div>

            <!-- Email Contact Card -->
            <div class="max-w-md mx-auto">
                <div class="contact-card bg-white rounded-2xl shadow-xl p-8 text-center border-t-4 border-accent-500">
                    <div class="w-20 h-20 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-envelope text-accent-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Email Us</h3>
                    <p class="text-gray-600 mb-6">For general inquiries and partnership opportunities</p>
                    <a href="mailto:importanceleadership2020@gmail.com" 
                       class="inline-flex items-center bg-accent-500 hover:bg-accent-600 text-white font-bold py-3 px-6 rounded-full transition-all transform hover:-translate-y-1 shadow-lg">
                        <i class="fas fa-envelope mr-2"></i>
                        Send Email
                    </a>
                    <p class="text-sm text-gray-500 mt-4">importanceleadership2020@gmail.com</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-20 bg-white" id="contact-form">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary text-primary-500 mb-4">Send Us a Message</h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Have a detailed inquiry? Fill out our contact form and we'll get back to you within 24 hours.
                </p>
            </div>

            <div class="max-w-2xl mx-auto">
                <div class="contact-form bg-gradient-to-br from-primary-500 to-blue-600 rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Form Header -->
                    <div class="bg-primary-500 text-white p-6 text-center">
                        <h3 class="text-2xl font-bold font-secondary mb-2">Contact Form</h3>
                        <p class="opacity-90">We'd love to hear from you</p>
                    </div>
                    
                    <!-- Form Body -->
                    <div class="bg-white p-8">
                        <form id="contactForm" action="/forms/contact-handler.php" method="POST" class="space-y-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name *</label>
                                <input type="text" id="name" name="name" required
                                       class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent-500" 
                                       placeholder="Your full name">
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-gray-700 font-semibold mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" required
                                       class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent-500" 
                                       placeholder="your@email.com">
                            </div>
                            
                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-gray-700 font-semibold mb-2">Subject *</label>
                                <select id="subject" name="subject" required
                                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent-500">
                                    <option value="">Select a subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="programs">Program Information</option>
                                    <option value="partnership">Partnership Opportunity</option>
                                    <option value="volunteer">Volunteer Application</option>
                                    <option value="donation">Donation Inquiry</option>
                                    <option value="media">Media Request</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-gray-700 font-semibold mb-2">Message *</label>
                                <textarea id="message" name="message" rows="5" required
                                          class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent-500" 
                                          placeholder="Tell us about your inquiry..."></textarea>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-accent-500 to-yellow-500 hover:from-yellow-500 hover:to-accent-500 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all transform hover:-translate-y-1 shadow-xl">
                                <span id="submitText">Send Message</span>
                                <i id="submitSpinner" class="fas fa-spinner fa-spin ml-2 hidden"></i>
                                <i class="fas fa-paper-plane ml-2"></i>
                            </button>
                        </form>
                        
                        <!-- Success Message -->
                        <div id="successMessage" class="hidden mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                            <h4 class="font-bold">Message Sent Successfully!</h4>
                            <p>Thank you for contacting us. We'll get back to you within 24 hours.</p>
                        </div>
                        
                        <!-- Error Message -->
                        <div id="errorMessage" class="hidden mt-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <h4 class="font-bold">Error</h4>
                            <p id="errorText">There was an error sending your message. Please try again.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Contact Information -->
    <section class="py-20 bg-gradient-to-br from-primary-500 via-primary-600 to-blue-600 text-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary mb-4">Visit Our Offices</h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl max-w-3xl mx-auto opacity-95">
                    Find us across three continents with dedicated teams ready to serve you
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Kenya Office -->
                <div class="bg-white bg-opacity-10 rounded-2xl p-8 text-center border border-white border-opacity-20 backdrop-filter backdrop-blur-lg">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary mb-4">Kenya Office</h3>
                    <p class="mb-4 opacity-90">
                        Nairobi, Kenya<br>
                        East Africa Hub
                    </p>
                    <p class="text-sm opacity-75">
                        Serving our largest community of young leaders
                    </p>
                </div>
                
                <!-- USA Office -->
                <div class="bg-white bg-opacity-10 rounded-2xl p-8 text-center border border-white border-opacity-20 backdrop-filter backdrop-blur-lg">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary mb-4">USA Office</h3>
                    <p class="mb-4 opacity-90">
                        03301 Concord<br>
                        New Hampshire, USA
                    </p>
                    <p class="text-sm opacity-75">
                        North American operations headquarters
                    </p>
                </div>
                
                <!-- Canada Office -->
                <div class="bg-white bg-opacity-10 rounded-2xl p-8 text-center border border-white border-opacity-20 backdrop-filter backdrop-blur-lg">
                    <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary mb-4">Canada Office</h3>
                    <p class="mb-4 opacity-90">
                        Winnipeg, Manitoba<br>
                        Canada
                    </p>
                    <p class="text-sm opacity-75">
                        Canadian programs and partnerships
                    </p>
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

// Contact form submission
document.getElementById('contactForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    
    // Show loading state
    submitBtn.disabled = true;
    submitText.textContent = 'Sending...';
    submitSpinner.classList.remove('hidden');
    successMessage.classList.add('hidden');
    errorMessage.classList.add('hidden');
    
    try {
        const formData = new FormData(this);
        
        // Simulate form submission (replace with actual endpoint)
        await new Promise(resolve => setTimeout(resolve, 2000));
        
        // Show success message
        successMessage.classList.remove('hidden');
        this.reset();
        
        // Scroll to success message
        successMessage.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
        
    } catch (error) {
        // Show error message
        errorText.textContent = 'There was an error sending your message. Please try again or contact us directly via WhatsApp.';
        errorMessage.classList.remove('hidden');
        
        // Scroll to error message
        errorMessage.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    } finally {
        // Reset button state
        submitBtn.disabled = false;
        submitText.textContent = 'Send Message';
        submitSpinner.classList.add('hidden');
    }
});

// Add scroll-triggered animations
const observeElements = document.querySelectorAll('.whatsapp-card, .contact-card, .contact-form');
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