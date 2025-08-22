<?php
// pages/partnerships.php - Partnerships and Collaboration Opportunities Page
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Partnerships | Importance Leadership | Strategic Collaborations";
$meta_description = "Partner with Importance Leadership to create meaningful impact. Explore collaboration opportunities for corporate, NGO, and community partnerships.";
$meta_keywords = "leadership partnerships, corporate social responsibility, NGO collaboration, youth empowerment, community development";
$canonical_url = "https://www.importanceleadership.com/partnerships";
$body_class = "partnerships-page";

// Additional head content
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/partnerships-og.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/partnerships-og.jpg">';

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
            <div class="w-full h-full bg-gradient-to-br from-primary-500 to-primary-700"></div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-20 py-8">
            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div data-aos="fade-right">
                        <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6">
                            Powering Change Through <span class="text-accent-300">Strategic Partnerships</span>
                        </h1>
                        <p class="text-xl md:text-2xl mb-8 opacity-95 leading-relaxed">
                            Join forces with Importance Leadership to amplify your social impact while achieving your organizational goals.
                        </p>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="#partner-form" class="bg-white text-primary-500 hover:bg-gray-100 px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center">
                                <i class="fas fa-handshake mr-2"></i> Become a Partner
                            </a>
                            <a href="#partnership-types" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 inline-flex items-center justify-center">
                                <i class="fas fa-search mr-2"></i> Explore Options
                            </a>
                        </div>
                    </div>
                    
                    <div class="hidden lg:block" data-aos="fade-left">
                        <div class="relative">
                            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                                <div class="text-center">
                                    <i class="fas fa-handshake text-6xl text-accent-300 mb-6"></i>
                                    <h3 class="text-2xl font-bold mb-4">Ready to Collaborate?</h3>
                                    <p class="text-lg opacity-90">Let's create meaningful change together through strategic partnerships.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Down Arrow -->
        <div class="absolute bottom-10 left-0 right-0 text-center animate-bounce">
            <a href="#partnership-types" class="text-white text-2xl" aria-label="Scroll down">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Partnership Types Section -->
    <section id="partnership-types" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block bg-primary-100 text-primary-500 px-6 py-3 rounded-full font-semibold mb-6 text-lg">
                    Collaboration Models
                </span>
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Explore Partnership Pathways
                </h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    Discover the right partnership model for your organization. We offer dynamic, mutually beneficial collaborations to drive sustainable impact.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Corporate Partnership -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="zoom-in" data-aos-delay="100">
                    <div class="p-8">
                        <div class="bg-primary-100 text-primary-500 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                            <i class="fas fa-building text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-primary-500 mb-4">Corporate Partnerships</h3>
                        <p class="text-gray-600 mb-6">Partner with us to support youth and community development.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-accent-500 mr-3"></i>
                                Employee engagement & volunteering
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-accent-500 mr-3"></i>
                                Brand leadership & recognition
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-accent-500 mr-3"></i>
                                Tailored impact reports
                            </li>
                        </ul>
                        <a href="#partner-form" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold w-full text-center block transition-all duration-300">
                            Partner with Us
                        </a>
                    </div>
                </div>

                <!-- NGO & Foundation -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="zoom-in" data-aos-delay="200">
                    <div class="p-8">
                        <div class="bg-accent-100 text-accent-500 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                            <i class="fas fa-hands-helping text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-primary-500 mb-4">NGO & Foundation Partners</h3>
                        <p class="text-gray-600 mb-6">Join forces to co-create, fund, and scale high-impact programs for youth development.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-accent-500 mr-3"></i>
                                Joint program design & delivery
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-accent-500 mr-3"></i>
                                Grantmaking & resource sharing
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-accent-500 mr-3"></i>
                                Knowledge exchange networks
                            </li>
                        </ul>
                        <a href="#partner-form" class="bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-lg font-semibold w-full text-center block transition-all duration-300">
                            Start a Collaboration
                        </a>
                    </div>
                </div>

                <!-- Community Partners -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="zoom-in" data-aos-delay="300">
                    <div class="p-8">
                        <div class="bg-green-100 text-green-500 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold font-secondary text-primary-500 mb-4">Community Partners</h3>
                        <p class="text-gray-600 mb-6">Empower your local area by working with us to deliver programs at the grassroots level.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-accent-500 mr-3"></i>
                                Venue & event support
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-accent-500 mr-3"></i>
                                Participant outreach
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-check-circle text-accent-500 mr-3"></i>
                                Local expertise & insights
                            </li>
                        </ul>
                        <a href="#partner-form" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold w-full text-center block transition-all duration-300">
                            Get Involved
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-20 bg-primary-500 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="w-full h-full bg-gradient-to-br from-white/10 to-transparent"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block bg-white/20 text-white px-6 py-3 rounded-full font-semibold mb-6 text-lg">
                    Mutual Benefits
                </span>
                <h2 class="text-4xl md:text-5xl font-bold font-secondary mb-6">
                    Why Partner With Us?
                </h2>
                <div class="w-20 h-1 bg-accent-300 mx-auto"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div data-aos="fade-right">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 mb-8 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="bg-accent-500 text-primary-500 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                            <i class="fas fa-bullseye text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Amplified Impact</h3>
                        <p class="text-white/90">Leverage our proven programs and network to multiply the reach and effectiveness of your social investments.</p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="bg-accent-500 text-primary-500 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                            <i class="fas fa-chart-line text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Measurable Outcomes</h3>
                        <p class="text-white/90">Our rigorous monitoring and evaluation framework provides clear metrics on program effectiveness and ROI.</p>
                    </div>
                </div>

                <div data-aos="fade-left">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 mb-8 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="bg-accent-500 text-primary-500 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Talent Pipeline</h3>
                        <p class="text-white/90">Gain access to high-potential youth leaders for internships, employment, and community programs.</p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="bg-accent-500 text-primary-500 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                            <i class="fas fa-certificate text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Thought Leadership</h3>
                        <p class="text-white/90">Position your organization as a leader in youth development through joint research and publications.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Current Partners Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block bg-primary-100 text-primary-500 px-6 py-3 rounded-full font-semibold mb-6 text-lg">
                    Trusted By
                </span>
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Our Valued Partners
                </h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                    We're proud to collaborate with these forward-thinking organizations.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 items-center">
                <div class="partner-logo" data-aos="fade-up" data-aos-delay="100">
                    <a href="https://www.unicef.org" target="_blank" rel="noopener noreferrer" class="block p-4 rounded-lg hover:shadow-lg transition-all duration-300">
                        <img src="/assets/images/partners/UNICEF.png" 
                             alt="UNICEF - United Nations Children's Fund"
                             class="w-full h-16 object-contain filter grayscale hover:grayscale-0 transition-all duration-300">
                    </a>
                </div>
                <div class="partner-logo" data-aos="fade-up" data-aos-delay="200">
                    <a href="https://www.savethechildren.org" target="_blank" rel="noopener noreferrer" class="block p-4 rounded-lg hover:shadow-lg transition-all duration-300">
                        <img src="/assets/images/partners/save-the-children.png" 
                             alt="Save the Children"
                             class="w-full h-16 object-contain filter grayscale hover:grayscale-0 transition-all duration-300">
                    </a>
                </div>
                <div class="partner-logo" data-aos="fade-up" data-aos-delay="300">
                    <a href="https://www.wya.net" target="_blank" rel="noopener noreferrer" class="block p-4 rounded-lg hover:shadow-lg transition-all duration-300">
                        <img src="/assets/images/partners/world-youth-alliance.png" 
                             alt="World Youth Alliance"
                             class="w-full h-16 object-contain filter grayscale hover:grayscale-0 transition-all duration-300">
                    </a>
                </div>
                <div class="partner-logo" data-aos="fade-up" data-aos-delay="400">
                    <a href="https://plan-international.org" target="_blank" rel="noopener noreferrer" class="block p-4 rounded-lg hover:shadow-lg transition-all duration-300">
                        <img src="/assets/images/partners/plan-international.png" 
                             alt="Plan International"
                             class="w-full h-16 object-contain filter grayscale hover:grayscale-0 transition-all duration-300">
                    </a>
                </div>
                <div class="partner-logo" data-aos="fade-up" data-aos-delay="500">
                    <a href="https://www.iyfnet.org" target="_blank" rel="noopener noreferrer" class="block p-4 rounded-lg hover:shadow-lg transition-all duration-300">
                        <img src="/assets/images/partners/iyf.png" 
                             alt="International Youth Foundation"
                             class="w-full h-16 object-contain filter grayscale hover:grayscale-0 transition-all duration-300">
                    </a>
                </div>
                <div class="partner-logo" data-aos="fade-up" data-aos-delay="600">
                    <a href="#" class="block p-4 rounded-lg hover:shadow-lg transition-all duration-300">
                        <img src="/assets/images/partners/GYAN.jpg" 
                             alt="Global Youth Action Network"
                             class="w-full h-16 object-contain filter grayscale hover:grayscale-0 transition-all duration-300">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Partnership Form Section -->
    <section id="partner-form" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <div class="grid lg:grid-cols-2">
                        <div class="hidden lg:block relative">
                            <div class="h-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                                <div class="text-center text-white p-8">
                                    <i class="fas fa-handshake text-6xl mb-6 text-accent-300"></i>
                                    <h3 class="text-2xl font-bold mb-4">Let's Partner Together</h3>
                                    <p class="text-lg opacity-90">Ready to make a meaningful impact? Our partnerships team is here to help.</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-8 md:p-12">
                            <h3 class="text-3xl font-bold font-secondary text-primary-500 mb-4">Start the Partnership Conversation</h3>
                            <p class="text-gray-600 mb-8">Complete this form and our partnerships team will contact you within 48 hours to discuss collaboration opportunities.</p>
                            
                            <form id="partnershipForm" class="space-y-6">
                                <div>
                                    <label for="organization" class="block text-gray-700 font-semibold mb-2">Organization Name <span class="text-red-500">*</span></label>
                                    <input type="text" id="organization" name="organization" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="contact-name" class="block text-gray-700 font-semibold mb-2">Your Name <span class="text-red-500">*</span></label>
                                        <input type="text" id="contact-name" name="contact-name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label for="job-title" class="block text-gray-700 font-semibold mb-2">Job Title <span class="text-red-500">*</span></label>
                                        <input type="text" id="job-title" name="job-title" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    </div>
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="email" class="block text-gray-700 font-semibold mb-2">Email <span class="text-red-500">*</span></label>
                                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                                        <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="partner-type" class="block text-gray-700 font-semibold mb-2">Partnership Interest <span class="text-red-500">*</span></label>
                                    <select id="partner-type" name="partner-type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        <option value="" disabled selected>Select an option</option>
                                        <option value="corporate">Corporate Partnership</option>
                                        <option value="ngo">NGO/Foundation Partnership</option>
                                        <option value="community">Community Partnership</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="message" class="block text-gray-700 font-semibold mb-2">How would you like to collaborate? <span class="text-red-500">*</span></label>
                                    <textarea id="message" name="message" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                                </div>
                                
                                <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white px-8 py-4 rounded-lg font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-paper-plane mr-2"></i> Submit Partnership Inquiry
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-accent-500 to-accent-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-bold font-secondary mb-6">Ready to Make an Impact Together?</h2>
            <p class="text-xl mb-8 max-w-4xl mx-auto opacity-95">
                Let's discuss how we can create meaningful change through strategic collaboration.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:importanceleadership2020@gmail.com" class="bg-white text-accent-500 hover:bg-gray-100 px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center">
                    <i class="fas fa-envelope mr-2"></i> Email Us
                </a>
                <a href="tel:+254792732177" class="border-2 border-white text-white hover:bg-white hover:text-accent-500 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 inline-flex items-center justify-center">
                    <i class="fas fa-phone-alt mr-2"></i> Call Us
                </a>
            </div>
        </div>
    </section>
</main>

<script>
// Form submission handling
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('partnershipForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const submitBtn = form.querySelector('button[type="submit"]');
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
        
        // Simulate form submission (replace with actual AJAX call)
        setTimeout(function() {
            // Show success message
            alert('Thank you for your partnership inquiry! Our team will contact you within 48 hours.');
            form.reset();
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Submit Partnership Inquiry';
        }, 1500);
    });
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>