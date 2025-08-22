<?php
// components/sections/hero.php - Hero section with Tailwind
?>
<!-- Hero Section -->
<section class="relative h-screen min-h-[700px] flex items-center justify-center text-white overflow-hidden">
    <!-- Background Slider -->
    <div class="absolute inset-0 z-0">
        <div class="swiper hero-swiper w-full h-full">
            <div class="swiper-wrapper">
                <!-- Hero Background -->
                <div class="swiper-slide">
                    <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                         style="background-image: url('assets/images/backgrounds/hero-bg.jpg')"></div>
                </div>
                <!-- Homepage Background -->
                <div class="swiper-slide">
                    <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                         style="background-image: url('assets/images/backgrounds/homepage-bg.jpg')"></div>
                </div>
                <!-- Leadership Training -->
                <div class="swiper-slide">
                    <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                         style="background-image: url('assets/images/backgrounds/leadership-training-session.jpg')"></div>
                </div>
                <!-- Community Engagement -->
                <div class="swiper-slide">
                    <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                         style="background-image: url('assets/images/backgrounds/community-engagement.jpg')"></div>
                </div>
                <!-- Women Leadership -->
                <div class="swiper-slide">
                    <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                         style="background-image: url('assets/images/backgrounds/women-leadership-group.jpg')"></div>
                </div>
                <!-- Impact Hero -->
                <div class="swiper-slide">
                    <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                         style="background-image: url('assets/images/backgrounds/impact-hero.jpg')"></div>
                </div>
            </div>
            <!-- Slider pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-500/80 to-primary-700/90 z-10"></div>
    
    <!-- Content -->
    <div class="container mx-auto px-4 relative z-20 py-8">
        <div class="max-w-4xl text-center sm:text-left">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold font-secondary leading-tight mb-6" data-aos="fade-up" data-aos-delay="100">
                <span class="text-accent-500 font-bold">Importance Leadership</span>
                <br>
                <span class="italic">Empowering Leaders,</span>
                <br>
                <span>Inspiring Excellence</span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 opacity-95 max-w-2xl leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                We develop young leaders through transformative mentorship and community programs that create sustainable impact.
            </p>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mb-12" data-aos="fade-up" data-aos-delay="300">
                <a href="/about" class="bg-accent-500 hover:bg-accent-600 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 text-center">
                    Discover Our Mission
                </a>
                <a href="/impact" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 text-center">
                    Learn About Our Impact
                </a>
            </div>
            
            <!-- Impact Statistics (Hidden on mobile) -->
            <div class="hidden sm:flex flex-col sm:flex-row gap-8" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center sm:text-left">
                    <div class="text-4xl md:text-5xl font-bold text-accent-500 mb-2" data-counter="2500">0</div>
                    <div class="text-sm uppercase tracking-wider opacity-90">Youth Empowered</div>
                </div>
                <div class="text-center sm:text-left">
                    <div class="text-4xl md:text-5xl font-bold text-accent-500 mb-2" data-counter="20">0</div>
                    <div class="text-sm uppercase tracking-wider opacity-90">Dedicated Mentors</div>
                </div>
                <div class="text-center sm:text-left">
                    <div class="text-4xl md:text-5xl font-bold text-accent-500 mb-2" data-counter="14">0</div>
                    <div class="text-sm uppercase tracking-wider opacity-90">Communities</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Down Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20" data-aos="fade-up" data-aos-delay="500">
        <div class="w-6 h-10 border-2 border-white rounded-full flex justify-center">
            <div class="w-1 h-3 bg-white rounded-full animate-bounce mt-2"></div>
        </div>
    </div>
</section>

<!-- Swiper JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<script>
// Initialize Hero Swiper
document.addEventListener('DOMContentLoaded', function() {
    // Hero background swiper
    const heroSwiper = new Swiper('.hero-swiper', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        speed: 1000,
    });
    
    // Counter animation
    function animateCounters() {
        const counters = document.querySelectorAll('[data-counter]');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-counter'));
            // Dynamic duration based on target value for natural counting speed
            const baseDuration = Math.min(2000, Math.max(800, target * 0.8));
            const increment = Math.max(1, Math.ceil(target / (baseDuration / 16)));
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    const shouldHavePlus = target === 2500 || target === 20;
                    counter.textContent = target + (shouldHavePlus ? '+' : '');
                    clearInterval(timer);
                } else {
                    const shouldHavePlus = target === 2500 || target === 20;
                    counter.textContent = current + (shouldHavePlus ? '+' : '');
                }
            }, 16);
        });
    }
    
    // Intersection Observer for counter animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                entry.target.classList.add('counted');
                animateCounters();
            }
        });
    }, { threshold: 0.5 });
    
    document.querySelectorAll('[data-counter]').forEach(counter => {
        observer.observe(counter.parentElement);
    });
});
</script>