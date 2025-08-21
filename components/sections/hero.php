<?php
// components/sections/hero.php - Hero section with Tailwind
?>
<!-- Hero Section -->
<section class="relative h-screen min-h-[700px] flex items-center justify-center text-white overflow-hidden">
    <!-- Background Slider -->
    <div class="absolute inset-0 z-0">
        <div class="swiper hero-swiper w-full h-full">
            <div class="swiper-wrapper">
                <!-- Leadership Development -->
                <div class="swiper-slide">
                    <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                         style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1471&q=80')"></div>
                </div>
                <!-- Young Leaders -->
                <div class="swiper-slide">
                    <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                         style="background-image: url('https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1470&q=80')"></div>
                </div>
                <!-- Youth Summit -->
                <div class="swiper-slide">
                    <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                         style="background-image: url('https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=1470&q=80')"></div>
                </div>
                <!-- Workshop Session -->
                <div class="swiper-slide">
                    <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                         style="background-image: url('https://images.unsplash.com/photo-1503676382389-4809596d5290?auto=format&fit=crop&w=1470&q=80')"></div>
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
        <div class="max-w-4xl">
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
            
            <!-- Impact Statistics -->
            <div class="flex flex-col sm:flex-row gap-8" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center sm:text-left">
                    <div class="text-4xl md:text-5xl font-bold text-accent-500 mb-2" data-counter="1500">0</div>
                    <div class="text-sm uppercase tracking-wider opacity-90">Young Leaders Developed</div>
                </div>
                <div class="text-center sm:text-left">
                    <div class="text-4xl md:text-5xl font-bold text-accent-500 mb-2" data-counter="50">0</div>
                    <div class="text-sm uppercase tracking-wider opacity-90">Communities Impacted</div>
                </div>
                <div class="text-center sm:text-left">
                    <div class="text-4xl md:text-5xl font-bold text-accent-500 mb-2" data-counter="3">0</div>
                    <div class="text-sm uppercase tracking-wider opacity-90">Countries</div>
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
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;
            
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    counter.textContent = target + (target === 1500 ? '+' : '+');
                    clearInterval(timer);
                } else {
                    counter.textContent = Math.floor(current) + (target === 1500 ? '+' : '+');
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