<?php
// components/nav.php - Exact one-to-one copy of reference navbar with Tailwind styling
?>
<!-- Navigation - One-to-one copy of reference structure -->
<header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-lg transition-all duration-300 backdrop-blur-sm" id="main-header">
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between py-3">
            <!-- Logo -->
            <div class="logo-container">
                <a href="/" class="block">
                    <img src="/assets/images/website-logo.png" 
                         alt="Importance Leadership" 
                         class="h-10 transition-all duration-300">
                </a>
            </div>
            
            <!-- Stage 1: Full Navigation (xl screens - show all) -->
            <nav class="nav-container hidden xl:flex items-center flex-1 justify-center">
                <div class="main-nav flex flex-nowrap">
                    <!-- Home -->
                    <div class="nav-item mx-0.5">
                        <a href="/" class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-home mr-1.5 text-xs"></i>Home
                        </a>
                    </div>
                    
                    <!-- Who We Are Dropdown -->
                    <div class="nav-item mx-0.5 relative group">
                        <button class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-users mr-1.5 text-xs"></i>Who We Are
                            <i class="fas fa-chevron-down ml-1.5 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white shadow-xl rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 py-2">
                            <a href="/who-we-are" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-bullseye mr-3 w-4 text-center"></i>About Us
                            </a>
                            <a href="/team" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-user-friends mr-3 w-4 text-center"></i>Our Team
                            </a>
                        </div>
                    </div>
                    
                    <!-- Where We Work Dropdown -->
                    <div class="nav-item mx-0.5 relative group">
                        <button class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-globe-africa mr-1.5 text-xs"></i>Where We Work
                            <i class="fas fa-chevron-down ml-1.5 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white shadow-xl rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 py-2">
                            <a href="/usa" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/us.svg" width="18" class="mr-3">USA
                            </a>
                            <a href="/canada" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/ca.svg" width="18" class="mr-3">Canada
                            </a>
                            <a href="/kenya" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/ke.svg" width="18" class="mr-3">Kenya
                            </a>
                        </div>
                    </div>
                    
                    <!-- What We Do Dropdown -->
                    <div class="nav-item mx-0.5 relative group">
                        <button class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-chart-line mr-1.5 text-xs"></i>What We Do
                            <i class="fas fa-chevron-down ml-1.5 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white shadow-xl rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 py-2">
                            <a href="/what-we-do" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-chart-line mr-3 w-4 text-center"></i>What We Do
                            </a>
                            <a href="/programs/advocacy-initiatives" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-balance-scale mr-3 w-4 text-center"></i>Advocacy Initiatives
                            </a>
                            <a href="/programs/networking" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-network-wired mr-3 w-4 text-center"></i>Professional Networking
                            </a>
                            <a href="/programs/mental-health" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-heart mr-3 w-4 text-center"></i>Mental Health Programs
                            </a>
                            <a href="/programs/leadership-development" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-chalkboard-teacher mr-3 w-4 text-center"></i>Leadership Development
                            </a>
                            <a href="/programs/climate-change" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-leaf mr-3 w-4 text-center"></i>Climate Change Awareness
                            </a>
                        </div>
                    </div>
                    
                    <!-- Impact -->
                    <div class="nav-item mx-0.5">
                        <a href="/impact" class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-chart-line mr-1.5 text-xs"></i>Impact
                        </a>
                    </div>
                    
                    <!-- Blog -->
                    <div class="nav-item mx-0.5">
                        <a href="/blog" class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-blog mr-1.5 text-xs"></i>Blog
                        </a>
                    </div>
                    
                    <!-- Events -->
                    <div class="nav-item mx-0.5">
                        <a href="/events" class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-calendar-alt mr-1.5 text-xs"></i>Events
                        </a>
                    </div>
                </div>
            </nav>
            
            <!-- Stage 2: Home + Core Dropdowns (lg screens - remove Impact/Blog/Events) -->
            <nav class="nav-container hidden lg:flex xl:hidden items-center flex-1 justify-center">
                <div class="main-nav flex flex-nowrap">
                    <!-- Home -->
                    <div class="nav-item mx-0.5">
                        <a href="/" class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-home mr-1.5 text-xs"></i>Home
                        </a>
                    </div>
                    
                    <!-- Who We Are Dropdown -->
                    <div class="nav-item mx-0.5 relative group">
                        <button class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-users mr-1.5 text-xs"></i>Who We Are
                            <i class="fas fa-chevron-down ml-1.5 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white shadow-xl rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 py-2">
                            <a href="/who-we-are" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-bullseye mr-3 w-4 text-center"></i>About Us
                            </a>
                            <a href="/team" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-user-friends mr-3 w-4 text-center"></i>Our Team
                            </a>
                        </div>
                    </div>
                    
                    <!-- Where We Work Dropdown -->
                    <div class="nav-item mx-0.5 relative group">
                        <button class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-globe-africa mr-1.5 text-xs"></i>Where We Work
                            <i class="fas fa-chevron-down ml-1.5 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white shadow-xl rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 py-2">
                            <a href="/usa" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/us.svg" width="18" class="mr-3">USA
                            </a>
                            <a href="/canada" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/ca.svg" width="18" class="mr-3">Canada
                            </a>
                            <a href="/kenya" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/ke.svg" width="18" class="mr-3">Kenya
                            </a>
                        </div>
                    </div>
                    
                    <!-- What We Do Dropdown -->
                    <div class="nav-item mx-0.5 relative group">
                        <button class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-chart-line mr-1.5 text-xs"></i>What We Do
                            <i class="fas fa-chevron-down ml-1.5 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white shadow-xl rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 py-2">
                            <a href="/what-we-do" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-chart-line mr-3 w-4 text-center"></i>What We Do
                            </a>
                            <a href="/programs/advocacy-initiatives" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-balance-scale mr-3 w-4 text-center"></i>Advocacy Initiatives
                            </a>
                            <a href="/programs/networking" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-network-wired mr-3 w-4 text-center"></i>Professional Networking
                            </a>
                            <a href="/programs/mental-health" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-heart mr-3 w-4 text-center"></i>Mental Health Programs
                            </a>
                            <a href="/programs/leadership-development" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-chalkboard-teacher mr-3 w-4 text-center"></i>Leadership Development
                            </a>
                            <a href="/programs/climate-change" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-leaf mr-3 w-4 text-center"></i>Climate Change Awareness
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Stage 3: Only Core Dropdowns (md screens - remove Home/Donate) -->
            <nav class="nav-container hidden md:flex lg:hidden items-center flex-1 justify-center">
                <div class="main-nav flex flex-nowrap">
                    <!-- Who We Are Dropdown -->
                    <div class="nav-item mx-0.5 relative group">
                        <button class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-users mr-1.5 text-xs"></i>Who We Are
                            <i class="fas fa-chevron-down ml-1.5 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white shadow-xl rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 py-2">
                            <a href="/who-we-are" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-bullseye mr-3 w-4 text-center"></i>About Us
                            </a>
                            <a href="/team" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-user-friends mr-3 w-4 text-center"></i>Our Team
                            </a>
                        </div>
                    </div>
                    
                    <!-- Where We Work Dropdown -->
                    <div class="nav-item mx-0.5 relative group">
                        <button class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-globe-africa mr-1.5 text-xs"></i>Where We Work
                            <i class="fas fa-chevron-down ml-1.5 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white shadow-xl rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 py-2">
                            <a href="/usa" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/us.svg" width="18" class="mr-3">USA
                            </a>
                            <a href="/canada" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/ca.svg" width="18" class="mr-3">Canada
                            </a>
                            <a href="/kenya" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/ke.svg" width="18" class="mr-3">Kenya
                            </a>
                        </div>
                    </div>
                    
                    <!-- What We Do Dropdown -->
                    <div class="nav-item mx-0.5 relative group">
                        <button class="nav-link flex items-center text-primary-500 font-medium text-sm px-2 py-2 rounded-lg hover:bg-blue-50 hover:text-primary-600 transition-all duration-300 whitespace-nowrap">
                            <i class="fas fa-chart-line mr-1.5 text-xs"></i>What We Do
                            <i class="fas fa-chevron-down ml-1.5 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white shadow-xl rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 py-2">
                            <a href="/what-we-do" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-chart-line mr-3 w-4 text-center"></i>What We Do
                            </a>
                            <a href="/programs/advocacy-initiatives" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-balance-scale mr-3 w-4 text-center"></i>Advocacy Initiatives
                            </a>
                            <a href="/programs/networking" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-network-wired mr-3 w-4 text-center"></i>Professional Networking
                            </a>
                            <a href="/programs/mental-health" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-heart mr-3 w-4 text-center"></i>Mental Health Programs
                            </a>
                            <a href="/programs/leadership-development" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-chalkboard-teacher mr-3 w-4 text-center"></i>Leadership Development
                            </a>
                            <a href="/programs/climate-change" class="dropdown-item flex items-center px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary-500 hover:pl-6 transition-all duration-300">
                                <i class="fas fa-leaf mr-3 w-4 text-center"></i>Climate Change Awareness
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Donate Button (Stage 1: xl screens) -->
            <div class="hidden xl:flex">
                <a href="/donate" class="action-button bg-gradient-to-r from-secondary-500 to-secondary-600 text-white px-4 py-2 rounded-full font-medium text-sm transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-lg flex items-center">
                    <i class="fas fa-heartbeat mr-1.5 text-xs"></i>Donate
                </a>
            </div>
            
            <!-- Donate Button (Stage 2: lg screens) -->
            <div class="hidden lg:flex xl:hidden">
                <a href="/donate" class="action-button bg-gradient-to-r from-secondary-500 to-secondary-600 text-white px-4 py-2 rounded-full font-medium text-sm transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-lg flex items-center">
                    <i class="fas fa-heartbeat mr-1.5 text-xs"></i>Donate
                </a>
            </div>
            
            <!-- Hamburger Button (Stage 2: lg screens - for Impact/Blog/Events) -->
            <button id="stage2-menu-button" class="hidden lg:flex xl:hidden p-2 text-gray-700 hover:text-primary-500 transition-colors duration-300 ml-2">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <!-- Hamburger Button (Stage 3: md screens - for Home/Impact/Blog/Events/Donate) -->
            <button id="stage3-menu-button" class="hidden md:flex lg:hidden p-2 text-gray-700 hover:text-primary-500 transition-colors duration-300 ml-2">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <!-- Mobile Menu Button (Stage 4: small screens) -->
            <button id="mobile-menu-button" class="mobile-menu-button md:hidden p-2 text-gray-700 hover:text-primary-500 transition-colors duration-300">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div id="mobile-menu" class="mobile-menu-container md:hidden fixed top-0 right-0 bottom-0 w-80 bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300">
    <div class="mobile-menu-header p-5 border-b border-gray-200 flex justify-between items-center">
        <div class="flex items-center">
            <img src="assets/images/website-logo.png" alt="Logo" class="h-8 mr-3">
            <h5 class="text-lg font-semibold mb-0">Importance Leadership</h5>
        </div>
        <button id="close-mobile-menu" class="mobile-close-button p-2 text-gray-500 hover:text-primary-500 transition-colors duration-300">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    
    <div class="mobile-menu-body p-5 h-full overflow-y-auto pb-24">
        <!-- Home -->
        <div class="mobile-nav-item mb-3">
            <a href="/" class="mobile-nav-link flex items-center text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <i class="fas fa-home mr-3"></i>Home
            </a>
        </div>
        
        <!-- Who We Are -->
        <div class="mobile-nav-item mb-3">
            <button class="mobile-nav-toggle w-full flex items-center justify-between text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <span class="flex items-center"><i class="fas fa-users mr-3"></i>Who We Are</span>
                <i class="fas fa-angle-down transition-transform duration-300"></i>
            </button>
            <div class="mobile-dropdown-menu hidden mt-2 ml-4">
                <a href="/who-we-are" class="mobile-nav-link flex items-center text-gray-600 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                    <i class="fas fa-bullseye mr-3"></i>About Us
                </a>
                <a href="/team" class="mobile-nav-link flex items-center text-gray-600 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                    <i class="fas fa-user-friends mr-3"></i>Our Team
                </a>
            </div>
        </div>
        
        <!-- Where We Work -->
        <div class="mobile-nav-item mb-3">
            <button class="mobile-nav-toggle w-full flex items-center justify-between text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <span class="flex items-center"><i class="fas fa-globe-africa mr-3"></i>Where We Work</span>
                <i class="fas fa-angle-down transition-transform duration-300"></i>
            </button>
            <div class="mobile-dropdown-menu hidden mt-2 ml-4">
                <a href="/usa" class="mobile-nav-link flex items-center text-gray-600 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                    <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/us.svg" width="18" class="mr-3">USA
                </a>
                <a href="/canada" class="mobile-nav-link flex items-center text-gray-600 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                    <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/ca.svg" width="18" class="mr-3">Canada
                </a>
                <a href="/kenya" class="mobile-nav-link flex items-center text-gray-600 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                    <img src="https://cdn.jsdelivr.net/npm/flag-icons/flags/4x3/ke.svg" width="18" class="mr-3">Kenya
                </a>
            </div>
        </div>
        
        <!-- What We Do -->
        <div class="mobile-nav-item mb-3">
            <button class="mobile-nav-toggle w-full flex items-center justify-between text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <span class="flex items-center"><i class="fas fa-lightbulb mr-3"></i>What We Do</span>
                <i class="fas fa-angle-down transition-transform duration-300"></i>
            </button>
            <div class="mobile-dropdown-menu hidden mt-2 ml-4">
                <a href="/what-we-do" class="mobile-nav-link flex items-center text-gray-600 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                    <i class="fas fa-chart-line mr-3"></i>What We Do
                </a>
                <a href="/programs/advocacy-initiatives" class="mobile-nav-link flex items-center text-gray-600 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                    <i class="fas fa-balance-scale mr-3"></i>Advocacy Initiatives
                </a>
                <a href="/programs/networking" class="mobile-nav-link flex items-center text-gray-600 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                    <i class="fas fa-network-wired mr-3"></i>Professional Networking
                </a>
                <a href="/programs/mental-health" class="mobile-nav-link flex items-center text-gray-600 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                    <i class="fas fa-heart mr-3"></i>Mental Health Programs
                </a>
                <a href="/programs/leadership-development" class="mobile-nav-link flex items-center text-gray-600 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                    <i class="fas fa-chalkboard-teacher mr-3"></i>Leadership Development
                </a>
                <a href="/programs/climate-change" class="mobile-nav-link flex items-center text-gray-600 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                    <i class="fas fa-leaf mr-3"></i>Climate Change Awareness
                </a>
            </div>
        </div>
        
        <!-- Impact -->
        <div class="mobile-nav-item mb-3">
            <a href="/impact" class="mobile-nav-link flex items-center text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <i class="fas fa-chart-line mr-3"></i>Impact
            </a>
        </div>
        
        <!-- Blog -->
        <div class="mobile-nav-item mb-3">
            <a href="/blog" class="mobile-nav-link flex items-center text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <i class="fas fa-blog mr-3"></i>Blog
            </a>
        </div>
        
        <!-- Events -->
        <div class="mobile-nav-item mb-3">
            <a href="/events" class="mobile-nav-link flex items-center text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <i class="fas fa-calendar-alt mr-3"></i>Events
            </a>
        </div>
        
        <!-- Donate Button -->
        <div class="mobile-nav-item mt-6">
            <a href="/donate" class="action-button bg-gradient-to-r from-secondary-500 to-secondary-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 hover:shadow-lg flex items-center justify-center w-full">
                <i class="fas fa-heartbeat mr-2"></i>Donate
            </a>
        </div>
    </div>
</div>

<!-- Stage 2 Menu (lg screens - Impact/Blog/Events only) -->
<div id="stage2-menu" class="stage2-menu-container hidden lg:block xl:hidden fixed top-0 right-0 bottom-0 w-80 bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300">
    <div class="mobile-menu-header p-5 border-b border-gray-200 flex justify-between items-center">
        <div class="flex items-center">
            <img src="assets/images/website-logo.png" alt="Logo" class="h-8 mr-3">
            <h5 class="text-lg font-semibold mb-0">More Items</h5>
        </div>
        <button id="close-stage2-menu" class="p-2 text-gray-500 hover:text-primary-500 transition-colors duration-300">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    
    <div class="mobile-menu-body p-5 h-full overflow-y-auto pb-24">
        <!-- Impact -->
        <div class="mobile-nav-item mb-3">
            <a href="/impact" class="mobile-nav-link flex items-center text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <i class="fas fa-chart-line mr-3"></i>Impact
            </a>
        </div>
        
        <!-- Blog -->
        <div class="mobile-nav-item mb-3">
            <a href="/blog" class="mobile-nav-link flex items-center text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <i class="fas fa-blog mr-3"></i>Blog
            </a>
        </div>
        
        <!-- Events -->
        <div class="mobile-nav-item mb-3">
            <a href="/events" class="mobile-nav-link flex items-center text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <i class="fas fa-calendar-alt mr-3"></i>Events
            </a>
        </div>
    </div>
</div>

<!-- Stage 3 Menu (lg screens - Home/Impact/Blog/Events/Donate) -->
<div id="stage3-menu" class="stage3-menu-container hidden md:block lg:hidden fixed top-0 right-0 bottom-0 w-80 bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300">
    <div class="mobile-menu-header p-5 border-b border-gray-200 flex justify-between items-center">
        <div class="flex items-center">
            <img src="assets/images/website-logo.png" alt="Logo" class="h-8 mr-3">
            <h5 class="text-lg font-semibold mb-0">More Items</h5>
        </div>
        <button id="close-stage3-menu" class="p-2 text-gray-500 hover:text-primary-500 transition-colors duration-300">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    
    <div class="mobile-menu-body p-5 h-full overflow-y-auto pb-24">
        <!-- Home -->
        <div class="mobile-nav-item mb-3">
            <a href="/" class="mobile-nav-link flex items-center text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <i class="fas fa-home mr-3"></i>Home
            </a>
        </div>
        
        <!-- Impact -->
        <div class="mobile-nav-item mb-3">
            <a href="/impact" class="mobile-nav-link flex items-center text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <i class="fas fa-chart-line mr-3"></i>Impact
            </a>
        </div>
        
        <!-- Blog -->
        <div class="mobile-nav-item mb-3">
            <a href="/blog" class="mobile-nav-link flex items-center text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <i class="fas fa-blog mr-3"></i>Blog
            </a>
        </div>
        
        <!-- Events -->
        <div class="mobile-nav-item mb-3">
            <a href="/events" class="mobile-nav-link flex items-center text-gray-700 hover:text-primary-500 py-3 px-3 rounded-lg hover:bg-blue-50 transition-all duration-300">
                <i class="fas fa-calendar-alt mr-3"></i>Events
            </a>
        </div>
        
        <!-- Donate Button -->
        <div class="mobile-nav-item mt-6">
            <a href="/donate" class="action-button bg-gradient-to-r from-secondary-500 to-secondary-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 hover:shadow-lg flex items-center justify-center w-full">
                <i class="fas fa-heartbeat mr-2"></i>Donate
            </a>
        </div>
    </div>
</div>

<script>
// Mobile Menu Toggle - Exact copy of reference functionality  
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const closeMobileMenu = document.getElementById('close-mobile-menu');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileNavToggles = document.querySelectorAll('.mobile-nav-toggle');
    
    // Stage 2 menu elements
    const stage2MenuButton = document.getElementById('stage2-menu-button');
    const closeStage2Menu = document.getElementById('close-stage2-menu');
    const stage2Menu = document.getElementById('stage2-menu');
    
    // Stage 3 menu elements
    const stage3MenuButton = document.getElementById('stage3-menu-button');
    const closeStage3Menu = document.getElementById('close-stage3-menu');
    const stage3Menu = document.getElementById('stage3-menu');
    
    // Open mobile menu
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.remove('translate-x-full');
            mobileMenu.classList.add('translate-x-0');
            document.body.style.overflow = 'hidden';
        });
        
        // Close mobile menu
        closeMobileMenu.addEventListener('click', function() {
            mobileMenu.classList.add('translate-x-full');
            mobileMenu.classList.remove('translate-x-0');
            document.body.style.overflow = '';
        });
    }
    
    // Stage 2 menu functionality
    if (stage2MenuButton && stage2Menu) {
        stage2MenuButton.addEventListener('click', function() {
            stage2Menu.classList.remove('translate-x-full');
            stage2Menu.classList.add('translate-x-0');
            document.body.style.overflow = 'hidden';
        });
        
        closeStage2Menu.addEventListener('click', function() {
            stage2Menu.classList.add('translate-x-full');
            stage2Menu.classList.remove('translate-x-0');
            document.body.style.overflow = '';
        });
        
        // Close when clicking links
        stage2Menu.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', function() {
                stage2Menu.classList.add('translate-x-full');
                stage2Menu.classList.remove('translate-x-0');
                document.body.style.overflow = '';
            });
        });
    }
    
    // Stage 3 menu functionality
    if (stage3MenuButton && stage3Menu) {
        stage3MenuButton.addEventListener('click', function() {
            stage3Menu.classList.remove('translate-x-full');
            stage3Menu.classList.add('translate-x-0');
            document.body.style.overflow = 'hidden';
        });
        
        closeStage3Menu.addEventListener('click', function() {
            stage3Menu.classList.add('translate-x-full');
            stage3Menu.classList.remove('translate-x-0');
            document.body.style.overflow = '';
        });
        
        // Close when clicking links
        stage3Menu.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', function() {
                stage3Menu.classList.add('translate-x-full');
                stage3Menu.classList.remove('translate-x-0');
                document.body.style.overflow = '';
            });
        });
    }
    
    // Mobile dropdown toggles
    mobileNavToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const menu = this.nextElementSibling;
            const icon = this.querySelector('.fa-angle-down');
            
            if (menu) {
                menu.classList.toggle('hidden');
                if (icon) {
                    icon.classList.toggle('rotate-180');
                }
            }
        });
    });
    
    // Close mobile menu when clicking links (except dropdown toggles)
    document.querySelectorAll('.mobile-nav-link').forEach(link => {
        link.addEventListener('click', function() {
            if (!this.classList.contains('mobile-nav-toggle')) {
                mobileMenu.classList.add('translate-x-full');
                mobileMenu.classList.remove('translate-x-0');
                document.body.style.overflow = '';
            }
        });
    });
    
    // Header scroll effect
    window.addEventListener('scroll', function() {
        const header = document.getElementById('main-header');
        if (window.scrollY > 50) {
            header.classList.add('bg-white/95');
        } else {
            header.classList.remove('bg-white/95');
        }
    });
});
</script>