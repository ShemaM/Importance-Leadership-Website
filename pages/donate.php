<?php
// pages/donate.php - Donate Page with component architecture
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Donate | Support Youth Empowerment & Leadership Development | Importance Leadership";
$meta_description = "Support Importance Leadership through secure M-Changa donations. Easy M-Pesa contributions for Kenyans with international options available. Help us empower the next generation.";
$meta_keywords = "donate, M-Changa, M-Pesa, leadership donation, youth empowerment, Kenya mobile money, NGO donation, secure payment";
$canonical_url = "https://www.importanceleadership.com/donate";
$body_class = "donate-page";

// Additional head content for donate page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/reference-files/image/donate-image.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/reference-files/image/donate-image.jpg">
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
@keyframes slideInRight {
    0% { opacity: 0; transform: translateX(30px); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}
@keyframes shine {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
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
.animate-slideInRight {
    animation: slideInRight 0.8s ease-out forwards;
}
.animate-pulse-custom {
    animation: pulse 2s ease-in-out infinite;
}
.gradient-overlay {
    background: linear-gradient(135deg, rgba(11, 31, 58, 0.9) 0%, rgba(56, 189, 248, 0.8) 100%);
}
.donation-card {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    backdrop-filter: blur(10px);
}
.donation-card:hover {
    transform: translateY(-10px) scale(1.02);
}
.step-card {
    transition: all 0.3s ease;
}
.step-card:hover {
    transform: translateY(-8px) scale(1.02);
}
.impact-card {
    transition: all 0.3s ease;
}
.impact-card:hover {
    transform: translateY(-8px) scale(1.02);
}
.payment-method {
    transition: all 0.3s ease;
}
.payment-method:hover {
    transform: translateY(-5px);
}
.btn-donate {
    position: relative;
    overflow: hidden;
}
.btn-donate::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}
.btn-donate:hover::before {
    left: 100%;
    animation: shine 0.5s ease-in-out;
}
.international-card {
    backdrop-filter: blur(12px);
    transition: all 0.3s ease;
}
.international-card:hover {
    background: rgba(255,255,255,0.2);
    transform: translateY(-8px) scale(1.02);
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
            <img src="/reference-files/image/donate-image.jpg" 
                 alt="Youth empowerment programs" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 gradient-overlay"></div>
        </div>
        
        <!-- Curved Bottom -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block h-16 md:h-20">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" 
                      fill="#f9fafb"></path>
            </svg>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-6 relative z-10 text-center">
            <div class="max-w-4xl mx-auto">
                <span class="inline-block bg-accent-500 text-primary-500 px-4 py-2 rounded-full text-sm font-bold mb-6 animate-fadeInUp">
                    MAKE A DIFFERENCE
                </span>
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6 animate-fadeInUp">
                    Empower the Next Generation
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-95 animate-fadeInUp">
                    Your donation fuels leadership development programs that transform lives and communities across Africa.
                </p>
                <div class="flex justify-center animate-fadeInUp">
                    <img src="/reference-files/image/donate-image.jpg" 
                         alt="Impact visualization" 
                         class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-xl animate-float">
                </div>
            </div>
        </div>
    </section>

    <!-- Main Donation Card -->
    <section class="py-0 bg-gray-50 relative -mt-20">
        <div class="container mx-auto px-6">
            <div class="donation-card bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 md:p-12 max-w-4xl mx-auto text-center relative z-10">
                <div class="mb-8">
                    <div class="bg-accent-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-hand-holding-heart text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold font-secondary text-primary-500 mb-4">
                        Make a Secure Donation
                    </h2>
                    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                        Join us in creating lasting change through your generous support. Contribute safely via M-Changa's trusted platform.
                    </p>
                </div>
                
                <div class="mb-8">
                    <a href="https://www.mchanga.africa/fundraiser/116070" target="_blank" 
                       class="btn-donate inline-flex items-center bg-gradient-to-r from-accent-500 to-yellow-500 hover:from-yellow-500 hover:to-accent-500 text-white font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:-translate-y-2 shadow-xl">
                        <i class="fas fa-mobile-alt mr-3 text-xl"></i>
                        Donate via M-Pesa Now
                    </a>
                </div>
                
                <div class="flex flex-wrap justify-center gap-6 text-sm text-gray-500">
                    <span class="flex items-center">
                        <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                        100% Secure
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                        Instant Confirmation
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-receipt text-blue-500 mr-2"></i>
                        Tax Deductible
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary text-primary-500 mb-4">How to Donate in 3 Simple Steps</h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Donating is quick, secure, and makes an immediate impact</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="step-card bg-white rounded-2xl shadow-xl p-8 text-center border-t-4 border-accent-500">
                    <div class="bg-accent-500 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                        1
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Click Donate Button</h3>
                    <p class="text-gray-600">
                        Select the "Donate via M-Pesa" button to be redirected to M-Changa's secure payment page.
                    </p>
                </div>
                
                <!-- Step 2 -->
                <div class="step-card bg-white rounded-2xl shadow-xl p-8 text-center border-t-4 border-yellow-500">
                    <div class="bg-yellow-500 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                        2
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Enter Donation Details</h3>
                    <p class="text-gray-600">
                        Input your donation amount and personal information. All data is encrypted for security.
                    </p>
                </div>
                
                <!-- Step 3 -->
                <div class="step-card bg-white rounded-2xl shadow-xl p-8 text-center border-t-4 border-green-500">
                    <div class="bg-green-500 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                        3
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Complete Payment</h3>
                    <p class="text-gray-600">
                        Use M-Pesa to finalize your donation. You'll receive instant confirmation via SMS.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About M-Changa Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- About M-Changa -->
                <div class="animate-slideInRight">
                    <div class="bg-gray-50 rounded-2xl p-8 shadow-lg">
                        <h3 class="text-2xl font-bold font-secondary text-primary-500 mb-6">About M-Changa</h3>
                        <p class="text-gray-600 mb-6">
                            M-Changa is Kenya's most trusted crowdfunding platform, enabling secure mobile donations through M-Pesa. Used by thousands of organizations, it provides:
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                                <span class="text-gray-700">Bank-level security</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                                <span class="text-gray-700">Instant payment processing</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                                <span class="text-gray-700">Detailed transaction records</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                                <span class="text-gray-700">Tax-compliant receipts</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Alternative Payment Methods -->
                <div class="animate-slideInRight">
                    <div class="bg-gray-50 rounded-2xl p-8 shadow-lg">
                        <h3 class="text-2xl font-bold font-secondary text-primary-500 mb-6">Alternative Payment Methods</h3>
                        
                        <!-- M-Pesa Paybill -->
                        <div class="payment-method bg-blue-50 rounded-xl p-6 mb-4 flex items-center">
                            <div class="bg-blue-500 text-white w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-mobile-alt text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-primary-500 mb-1">M-Pesa Paybill</h4>
                                <p class="text-sm text-gray-600">
                                    Business Number: <strong>891300</strong><br>
                                    Account Number: <strong>116070</strong>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Bank Transfer -->
                        <div class="payment-method bg-green-50 rounded-xl p-6 mb-4 flex items-center">
                            <div class="bg-green-500 text-white w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-university text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-primary-500 mb-1">Bank Transfer</h4>
                                <p class="text-sm text-gray-600">
                                    Equity Bank<br>
                                    Account Name: Importance Leadership<br>
                                    Account Number: 1234567890
                                </p>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-500 mt-6">
                            For large donations or corporate giving, please 
                            <a href="/contact" class="text-primary-500 hover:text-primary-600 font-semibold">contact us directly</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- International Donors Section -->
    <section class="py-20 bg-gradient-to-br from-primary-500 via-primary-600 to-blue-600 text-white overflow-hidden relative">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <!-- Curved Top -->
        <div class="absolute top-0 left-0 w-full overflow-hidden">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block h-16 md:h-20">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" 
                      opacity=".25" fill="#f9fafb"></path>
            </svg>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary text-white mb-4">International Supporters</h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl max-w-3xl mx-auto opacity-95">
                    Our work impacts lives across Africa. If you're outside Kenya, we have secure options for you to contribute to our mission.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Global Donations -->
                <div class="international-card bg-white bg-opacity-10 rounded-2xl p-8 text-center border border-white border-opacity-20">
                    <div class="bg-accent-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-globe-africa text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary mb-4">Global Donations</h3>
                    <p class="mb-6 opacity-90">
                        We accept international bank transfers and cryptocurrency donations. Contact us for account details.
                    </p>
                    <a href="/contact" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 font-bold py-3 px-6 rounded-full transition-all transform hover:-translate-y-1">
                        <i class="fas fa-envelope mr-2"></i>Request Details
                    </a>
                </div>
                
                <!-- Corporate Partnerships -->
                <div class="international-card bg-white bg-opacity-10 rounded-2xl p-8 text-center border border-white border-opacity-20">
                    <div class="bg-yellow-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-handshake text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary mb-4">Corporate Partnerships</h3>
                    <p class="mb-6 opacity-90">
                        Businesses can sponsor specific programs or provide matching employee donations.
                    </p>
                    <a href="/contact" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 font-bold py-3 px-6 rounded-full transition-all transform hover:-translate-y-1">
                        <i class="fas fa-briefcase mr-2"></i>Partner With Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary text-primary-500 mb-4">Your Impact</h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Every donation directly supports our leadership development programs
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Education Impact -->
                <div class="impact-card bg-white rounded-2xl shadow-xl p-8 text-center border-b-4 border-blue-500">
                    <div class="bg-blue-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Education</h3>
                    <p class="text-gray-600 mb-4">
                        $50 provides school supplies for a refugee student for one year
                    </p>
                    <div class="text-2xl font-bold text-blue-500">$50</div>
                </div>
                
                <!-- Workshops Impact -->
                <div class="impact-card bg-white rounded-2xl shadow-xl p-8 text-center border-b-4 border-green-500">
                    <div class="bg-green-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Workshops</h3>
                    <p class="text-gray-600 mb-4">
                        $100 sponsors a youth for our intensive leadership training
                    </p>
                    <div class="text-2xl font-bold text-green-500">$100</div>
                </div>
                
                <!-- Community Impact -->
                <div class="impact-card bg-white rounded-2xl shadow-xl p-8 text-center border-b-4 border-purple-500">
                    <div class="bg-purple-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-hands-helping text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-4">Community</h3>
                    <p class="text-gray-600 mb-4">
                        $250 funds a community service project led by our students
                    </p>
                    <div class="text-2xl font-bold text-purple-500">$250</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-20 bg-gradient-to-r from-primary-500 to-blue-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold font-secondary mb-6">Ready to Make a Difference?</h2>
                <p class="text-xl mb-8 opacity-95">
                    Your contribution today will transform lives and build stronger communities tomorrow.
                </p>
                <a href="https://www.mchanga.africa/fundraiser/116070" target="_blank" 
                   class="inline-flex items-center bg-accent-500 hover:bg-yellow-500 text-white font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:-translate-y-2 shadow-xl animate-pulse-custom">
                    <i class="fas fa-mobile-alt mr-3 text-xl"></i>
                    Donate Now
                </a>
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

// Enhanced donate button animation
const donateButtons = document.querySelectorAll('.btn-donate');
donateButtons.forEach(button => {
    button.addEventListener('mouseenter', function() {
        const icon = this.querySelector('i');
        if (icon) {
            icon.style.transform = 'scale(1.2) rotate(10deg)';
            icon.style.transition = 'transform 0.3s ease';
        }
    });
    
    button.addEventListener('mouseleave', function() {
        const icon = this.querySelector('i');
        if (icon) {
            icon.style.transform = 'scale(1) rotate(0deg)';
        }
    });
});

// Add scroll-triggered animations
const observeElements = document.querySelectorAll('.step-card, .impact-card, .payment-method, .international-card');
const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animationDelay = Math.random() * 0.3 + 's';
            entry.target.classList.add('animate-fadeInUp');
        }
    });
}, { threshold: 0.1 });

observeElements.forEach(el => scrollObserver.observe(el));

// Floating animation for hero image
const heroImage = document.querySelector('.animate-float');
if (heroImage) {
    let floatDirection = 1;
    setInterval(() => {
        floatDirection *= -1;
        heroImage.style.transform = `translateY(${floatDirection * 10}px)`;
    }, 3000);
}
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>