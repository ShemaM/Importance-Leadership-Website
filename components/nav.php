<?php
// components/nav.php - Clean Tailwind navigation component
?>
<!-- Navigation -->
<header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md transition-all duration-300" id="main-header">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            <!-- Logo -->
            <div class="logo-container">
                <a href="/" class="block">
                    <img src="/assets/images/icons/website-logo.png" 
                         alt="Importance Leadership" 
                         class="h-12 md:h-14 transition-all duration-300">
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-8">
                <!-- Home -->
                <a href="/" class="flex items-center text-primary-500 font-semibold px-4 py-2 rounded-lg hover:bg-primary-50 transition-all duration-300">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                
                <!-- Who We Are Dropdown -->
                <div class="relative group">
                    <button class="flex items-center text-primary-500 font-semibold px-4 py-2 rounded-lg hover:bg-primary-50 transition-all duration-300">
                        <i class="fas fa-users mr-2"></i>Who We Are
                        <i class="fas fa-chevron-down ml-2 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute top-full left-0 mt-2 w-48 bg-white shadow-lg rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <a href="/about" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-500 transition-all duration-300 rounded-t-lg">
                            <i class="fas fa-bullseye mr-3"></i>About Us
                        </a>
                        <a href="/team" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-500 transition-all duration-300 rounded-b-lg">
                            <i class="fas fa-user-friends mr-3"></i>Our Team
                        </a>
                    </div>
                </div>
                
                <!-- Where We Work Dropdown -->
                <div class="relative group">
                    <button class="flex items-center text-primary-500 font-semibold px-4 py-2 rounded-lg hover:bg-primary-50 transition-all duration-300">
                        <i class="fas fa-globe mr-2"></i>Where We Work
                        <i class="fas fa-chevron-down ml-2 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute top-full left-0 mt-2 w-48 bg-white shadow-lg rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <a href="/kenya" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-500 transition-all duration-300 rounded-t-lg">
                            <i class="fas fa-map-marker-alt mr-3"></i>Kenya
                        </a>
                        <a href="/usa" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-500 transition-all duration-300">
                            <i class="fas fa-flag-usa mr-3"></i>USA
                        </a>
                        <a href="/canada" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-500 transition-all duration-300 rounded-b-lg">
                            <i class="fas fa-leaf mr-3"></i>Canada
                        </a>
                    </div>
                </div>
                
                <!-- Programs Dropdown -->
                <div class="relative group">
                    <button class="flex items-center text-primary-500 font-semibold px-4 py-2 rounded-lg hover:bg-primary-50 transition-all duration-300">
                        <i class="fas fa-graduation-cap mr-2"></i>Programs
                        <i class="fas fa-chevron-down ml-2 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute top-full left-0 mt-2 w-56 bg-white shadow-lg rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <a href="/programs/leadership-development" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-500 transition-all duration-300 rounded-t-lg">
                            <i class="fas fa-crown mr-3"></i>Leadership Development
                        </a>
                        <a href="/programs/mentorship" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-500 transition-all duration-300">
                            <i class="fas fa-hands-helping mr-3"></i>Mentorship Program
                        </a>
                        <a href="/programs/advocacy" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-500 transition-all duration-300">
                            <i class="fas fa-bullhorn mr-3"></i>Advocacy Initiatives
                        </a>
                        <a href="/programs/mental-health" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-500 transition-all duration-300">
                            <i class="fas fa-heart mr-3"></i>Mental Health
                        </a>
                        <a href="/programs/networking" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-500 transition-all duration-300 rounded-b-lg">
                            <i class="fas fa-network-wired mr-3"></i>Professional Networking
                        </a>
                    </div>
                </div>
                
                <!-- Impact -->
                <a href="/impact" class="flex items-center text-primary-500 font-semibold px-4 py-2 rounded-lg hover:bg-primary-50 transition-all duration-300">
                    <i class="fas fa-chart-line mr-2"></i>Impact
                </a>
                
                <!-- Contact -->
                <a href="/contact" class="flex items-center text-primary-500 font-semibold px-4 py-2 rounded-lg hover:bg-primary-50 transition-all duration-300">
                    <i class="fas fa-envelope mr-2"></i>Contact
                </a>
            </nav>
            
            <!-- CTA Button (Desktop) -->
            <div class="hidden lg:flex items-center space-x-4">
                <a href="/join-us" class="bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    Join Us
                </a>
                <a href="/donate" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    Donate
                </a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="lg:hidden p-2 text-primary-500 hover:bg-primary-50 rounded-lg transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="lg:hidden fixed top-0 right-0 h-full w-80 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50">
        <div class="flex items-center justify-between p-6 border-b">
            <img src="/assets/images/icons/website-logo.png" alt="Importance Leadership" class="h-10">
            <button id="close-mobile-menu" class="p-2 text-gray-500 hover:text-primary-500 transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <nav class="p-6 space-y-4 overflow-y-auto h-full pb-24">
            <a href="/" class="flex items-center text-primary-500 font-semibold p-3 rounded-lg hover:bg-primary-50 transition-all duration-300">
                <i class="fas fa-home mr-3"></i>Home
            </a>
            
            <!-- Mobile Dropdown: Who We Are -->
            <div class="mobile-dropdown">
                <button class="mobile-dropdown-toggle flex items-center justify-between w-full text-primary-500 font-semibold p-3 rounded-lg hover:bg-primary-50 transition-all duration-300">
                    <span class="flex items-center"><i class="fas fa-users mr-3"></i>Who We Are</span>
                    <i class="fas fa-chevron-down transition-transform duration-300"></i>
                </button>
                <div class="mobile-dropdown-menu hidden mt-2 ml-6 space-y-2">
                    <a href="/about" class="flex items-center text-gray-700 p-3 rounded-lg hover:bg-primary-50 transition-all duration-300">
                        <i class="fas fa-bullseye mr-3"></i>About Us
                    </a>
                    <a href="/team" class="flex items-center text-gray-700 p-3 rounded-lg hover:bg-primary-50 transition-all duration-300">
                        <i class="fas fa-user-friends mr-3"></i>Our Team
                    </a>
                </div>
            </div>
            
            <!-- Add more mobile menu items... -->
            
            <!-- Mobile CTA Buttons -->
            <div class="pt-6 space-y-3 border-t">
                <a href="/join-us" class="block bg-accent-500 hover:bg-accent-600 text-white text-center px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                    Join Us
                </a>
                <a href="/donate" class="block bg-primary-500 hover:bg-primary-600 text-white text-center px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                    Donate
                </a>
            </div>
        </nav>
    </div>
    
    <!-- Mobile Menu Backdrop -->
    <div id="mobile-menu-backdrop" class="lg:hidden fixed inset-0 bg-black opacity-0 invisible transition-all duration-300 z-40"></div>
</header>

<script>
// Mobile menu functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMobileMenu = document.getElementById('close-mobile-menu');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
    const dropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
    
    // Open mobile menu
    mobileMenuButton.addEventListener('click', function() {
        mobileMenu.classList.remove('translate-x-full');
        mobileMenuBackdrop.classList.remove('opacity-0', 'invisible');
        document.body.classList.add('overflow-hidden');
    });
    
    // Close mobile menu
    function closeMobileMenuFunc() {
        mobileMenu.classList.add('translate-x-full');
        mobileMenuBackdrop.classList.add('opacity-0', 'invisible');
        document.body.classList.remove('overflow-hidden');
    }
    
    closeMobileMenu.addEventListener('click', closeMobileMenuFunc);
    mobileMenuBackdrop.addEventListener('click', closeMobileMenuFunc);
    
    // Mobile dropdown functionality
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const menu = this.nextElementSibling;
            const icon = this.querySelector('.fa-chevron-down');
            
            menu.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });
    
    // Header scroll effect
    window.addEventListener('scroll', function() {
        const header = document.getElementById('main-header');
        if (window.scrollY > 50) {
            header.classList.add('shadow-lg');
            header.classList.add('bg-white/95');
            header.classList.add('backdrop-blur-sm');
        } else {
            header.classList.remove('shadow-lg');
            header.classList.remove('bg-white/95');
            header.classList.remove('backdrop-blur-sm');
        }
    });
});
</script>