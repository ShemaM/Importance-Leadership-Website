<?php
// pages/events.php - Events Page with component architecture
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Events | Leadership Workshops & Youth Conferences | Importance Leadership";
$meta_description = "Join our upcoming leadership conferences, workshops, and community events. Discover opportunities for youth empowerment, skill development, and networking with like-minded leaders.";
$meta_keywords = "events, leadership conference, workshops, youth events, leadership training, community events, networking";
$canonical_url = "https://www.importanceleadership.com/events";
$body_class = "events-page";

// Additional head content for events page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/events-hero.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/events-hero.jpg">
<style>
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
@keyframes slideInLeft {
    0% { opacity: 0; transform: translateX(-30px); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
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
.animate-pulse-custom {
    animation: pulse 2s ease-in-out infinite;
}
.event-card {
    transition: all 0.3s ease;
}
.event-card:hover {
    transform: translateY(-10px);
}
.event-card img {
    transition: all 0.3s ease;
}
.event-card:hover img {
    transform: scale(1.05);
}
.gradient-overlay {
    background: linear-gradient(135deg, rgba(11, 31, 58, 0.9) 0%, rgba(11, 31, 58, 0.7) 100%);
}
.filter-button {
    transition: all 0.3s ease;
}
.filter-button:hover {
    transform: scale(1.05);
}
.filter-button.active {
    transform: scale(1.02);
}
.event-status {
    position: relative;
    overflow: hidden;
}
.event-status::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.5s;
}
.event-status:hover::before {
    left: 100%;
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
    <section class="relative py-32 bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <span class="inline-block bg-accent-500 text-primary-500 px-4 py-2 rounded-full text-sm font-bold mb-6 animate-fadeInUp">
                    CONNECT & LEARN
                </span>
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6 animate-fadeInUp">
                    Upcoming Events
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-95 animate-fadeInUp">
                    Join our leadership conferences, workshops, and community events designed to empower, inspire, and connect young leaders worldwide.
                </p>
                <div class="flex flex-wrap justify-center gap-4 animate-fadeInUp">
                    <a href="#events-list" class="bg-accent-500 hover:bg-accent-600 text-white font-bold py-3 px-8 rounded-full transition-all transform hover:-translate-y-1 shadow-lg">
                        <i class="fas fa-calendar-check mr-2"></i>Browse Events
                    </a>
                    <a href="#newsletter" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 font-bold py-3 px-8 rounded-full transition-all transform hover:-translate-y-1">
                        <i class="fas fa-bell mr-2"></i>Get Notified
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 left-0 right-0 text-center animate-bounce">
            <a href="#events-list" class="text-white text-2xl">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Events Content Section -->
    <section id="events-list" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-4 gap-12">
                <!-- Main Events Content -->
                <div class="lg:col-span-3">
                    <!-- Filter Buttons -->
                    <div class="mb-12">
                        <div class="flex flex-wrap gap-3">
                            <button class="filter-button bg-primary-500 text-white px-6 py-3 rounded-full font-semibold transition-all transform hover:scale-105 active" data-filter="all">
                                All Events
                            </button>
                            <button class="filter-button bg-white text-primary-500 border-2 border-primary-500 px-6 py-3 rounded-full font-semibold transition-all transform hover:scale-105" data-filter="conference">
                                Conferences
                            </button>
                            <button class="filter-button bg-white text-primary-500 border-2 border-primary-500 px-6 py-3 rounded-full font-semibold transition-all transform hover:scale-105" data-filter="workshop">
                                Workshops
                            </button>
                            <button class="filter-button bg-white text-primary-500 border-2 border-primary-500 px-6 py-3 rounded-full font-semibold transition-all transform hover:scale-105" data-filter="webinar">
                                Webinars
                            </button>
                            <button class="filter-button bg-white text-primary-500 border-2 border-primary-500 px-6 py-3 rounded-full font-semibold transition-all transform hover:scale-105" data-filter="networking">
                                Networking
                            </button>
                        </div>
                    </div>

                    <!-- Featured Event -->
                    <div class="mb-16">
                        <div class="relative">
                            <span class="inline-block bg-accent-500 text-white px-3 py-1 rounded-full text-sm font-bold mb-4">
                                Featured Event
                            </span>
                        </div>
                        <article class="event-card bg-white rounded-2xl shadow-xl overflow-hidden" data-category="conference">
                            <div class="grid md:grid-cols-2">
                                <div class="relative h-64 md:h-auto">
                                    <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                         alt="Global Youth Leadership Summit" 
                                         class="w-full h-full object-cover">
                                    <div class="absolute top-4 left-4">
                                        <span class="event-status bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                            Registration Open
                                        </span>
                                    </div>
                                </div>
                                <div class="p-8">
                                    <div class="flex items-center text-sm text-gray-500 mb-4">
                                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full mr-3">Conference</span>
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-2"></i>March 15-17, 2025
                                        </span>
                                    </div>
                                    <h2 class="text-2xl md:text-3xl font-bold font-secondary text-primary-500 mb-4">
                                        Global Youth Leadership Summit 2025
                                    </h2>
                                    <p class="text-gray-600 mb-4">
                                        Join over 500 young leaders from around the world for three days of inspiring keynotes, interactive workshops, and meaningful networking. This flagship event focuses on developing authentic leadership skills for the next generation.
                                    </p>
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            <span>Nairobi, Kenya</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-users mr-2"></i>
                                            <span>500+ Attendees</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-clock mr-2"></i>
                                            <span>3 Days</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-3">
                                        <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-6 rounded-full transition-all transform hover:-translate-y-1">
                                            <i class="fas fa-ticket-alt mr-2"></i>Register Now
                                        </a>
                                        <a href="#" class="border-2 border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white font-bold py-3 px-6 rounded-full transition-all transform hover:-translate-y-1">
                                            <i class="fas fa-info-circle mr-2"></i>Learn More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Event Grid -->
                    <div class="grid md:grid-cols-2 gap-8" id="events-grid">
                        <!-- Workshop Event -->
                        <article class="event-card bg-white rounded-2xl shadow-xl overflow-hidden" data-category="workshop">
                            <div class="relative h-48">
                                <img src="https://images.unsplash.com/photo-1559523161-0fc0d8b38a7a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                     alt="Negotiation Skills Workshop" 
                                     class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4">
                                    <span class="event-status bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        Early Bird
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                    <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full">Workshop</span>
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar mr-2"></i>April 22, 2025
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">
                                    The Art of Negotiation Workshop
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    Master essential negotiation skills through interactive scenarios and expert guidance. Perfect for emerging leaders in any field.
                                </p>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <i class="fas fa-clock mr-2"></i>
                                        <span>9:00 AM - 5:00 PM</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <span>Virtual</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-primary-500 font-bold">
                                        <span class="text-lg">$89</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">$120</span>
                                    </div>
                                    <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-4 rounded-full transition-all transform hover:-translate-y-1">
                                        Register
                                    </a>
                                </div>
                            </div>
                        </article>

                        <!-- Webinar Event -->
                        <article class="event-card bg-white rounded-2xl shadow-xl overflow-hidden" data-category="webinar">
                            <div class="relative h-48">
                                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                     alt="Mental Health Awareness Webinar" 
                                     class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4">
                                    <span class="event-status bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        Free Event
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                    <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full">Webinar</span>
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar mr-2"></i>May 10, 2025
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">
                                    Mental Health in Leadership
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    Explore the vital connection between mental wellness and effective leadership with expert panelists and practical strategies.
                                </p>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <i class="fas fa-clock mr-2"></i>
                                        <span>2:00 PM - 3:30 PM</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <i class="fas fa-globe mr-2"></i>
                                        <span>Online</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-green-600 font-bold text-lg">
                                        Free
                                    </div>
                                    <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-4 rounded-full transition-all transform hover:-translate-y-1">
                                        Join Free
                                    </a>
                                </div>
                            </div>
                        </article>

                        <!-- Networking Event -->
                        <article class="event-card bg-white rounded-2xl shadow-xl overflow-hidden" data-category="networking">
                            <div class="relative h-48">
                                <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                     alt="Young Professionals Networking" 
                                     class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4">
                                    <span class="event-status bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        Limited Spots
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full">Networking</span>
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar mr-2"></i>June 5, 2025
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">
                                    Young Professionals Mixer
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    Connect with fellow young professionals, share experiences, and build meaningful relationships in a relaxed atmosphere.
                                </p>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <i class="fas fa-clock mr-2"></i>
                                        <span>6:00 PM - 9:00 PM</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <span>Downtown Hub</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-primary-500 font-bold text-lg">
                                        $25
                                    </div>
                                    <a href="#" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-4 rounded-full transition-all transform hover:-translate-y-1">
                                        Register
                                    </a>
                                </div>
                            </div>
                        </article>

                        <!-- Conference Event -->
                        <article class="event-card bg-white rounded-2xl shadow-xl overflow-hidden" data-category="conference">
                            <div class="relative h-48">
                                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                     alt="Innovation in Leadership Conference" 
                                     class="w-full h-full object-cover">
                                <div class="absolute top-4 left-4">
                                    <span class="event-status bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        Sold Out
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full">Conference</span>
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar mr-2"></i>July 12-13, 2025
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">
                                    Innovation in Leadership Conference
                                </h3>
                                <p class="text-gray-600 mb-4">
                                    Discover cutting-edge leadership approaches and technologies shaping the future of organizations and communities.
                                </p>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <i class="fas fa-clock mr-2"></i>
                                        <span>2 Days</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <span>Innovation Center</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-gray-500 font-bold text-lg">
                                        Sold Out
                                    </div>
                                    <a href="#" class="bg-gray-400 text-white font-semibold py-2 px-4 rounded-full cursor-not-allowed">
                                        Waitlist
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Load More Button -->
                    <div class="text-center mt-12">
                        <button class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-8 rounded-full transition-all transform hover:-translate-y-1 shadow-lg">
                            <i class="fas fa-plus mr-2"></i>Load More Events
                        </button>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Event Newsletter -->
                    <div id="newsletter" class="bg-white rounded-2xl shadow-xl p-6 animate-slideInLeft">
                        <div class="text-center mb-6">
                            <div class="bg-accent-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-calendar-plus text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold font-secondary text-primary-500 mb-2">Never Miss an Event</h3>
                            <p class="text-gray-600">Get notified about upcoming events and early-bird registration.</p>
                        </div>
                        <form class="space-y-4" id="events-newsletter-form">
                            <div>
                                <input type="email" name="email" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500" 
                                       placeholder="Enter your email">
                            </div>
                            <div>
                                <select name="interests" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500">
                                    <option value="">Select interest</option>
                                    <option value="conferences">Conferences</option>
                                    <option value="workshops">Workshops</option>
                                    <option value="webinars">Webinars</option>
                                    <option value="networking">Networking Events</option>
                                </select>
                            </div>
                            <button type="submit" 
                                    class="w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-6 rounded-lg transition-all transform hover:-translate-y-1">
                                <i class="fas fa-bell mr-2"></i>Get Notifications
                            </button>
                        </form>
                    </div>

                    <!-- Event Categories -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 animate-slideInLeft">
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                            <i class="fas fa-list text-accent-500 mr-2"></i>Event Categories
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <span class="text-gray-700">Leadership Conferences</span>
                                <span class="bg-primary-100 text-primary-500 text-xs px-2 py-1 rounded-full">8</span>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <span class="text-gray-700">Skill Workshops</span>
                                <span class="bg-primary-100 text-primary-500 text-xs px-2 py-1 rounded-full">12</span>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <span class="text-gray-700">Webinars & Sessions</span>
                                <span class="bg-primary-100 text-primary-500 text-xs px-2 py-1 rounded-full">6</span>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <span class="text-gray-700">Networking Events</span>
                                <span class="bg-primary-100 text-primary-500 text-xs px-2 py-1 rounded-full">4</span>
                            </div>
                        </div>
                    </div>

                    <!-- Past Events Highlights -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 animate-slideInLeft">
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                            <i class="fas fa-history text-accent-500 mr-2"></i>Recent Highlights
                        </h3>
                        <div class="space-y-4">
                            <div class="border-l-4 border-accent-500 pl-4">
                                <h4 class="font-semibold text-primary-500 text-sm mb-1">
                                    Youth Leadership Summit 2024
                                </h4>
                                <p class="text-xs text-gray-600 mb-2">November 2024 • 450 Attendees</p>
                                <p class="text-xs text-gray-500">
                                    Our most successful event with speakers from 15 countries.
                                </p>
                            </div>
                            
                            <div class="border-l-4 border-accent-500 pl-4">
                                <h4 class="font-semibold text-primary-500 text-sm mb-1">
                                    Digital Leadership Workshop Series
                                </h4>
                                <p class="text-xs text-gray-600 mb-2">October 2024 • 200+ Participants</p>
                                <p class="text-xs text-gray-500">
                                    4-week intensive program on modern leadership skills.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 animate-slideInLeft">
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                            <i class="fas fa-external-link-alt text-accent-500 mr-2"></i>Quick Links
                        </h3>
                        <div class="space-y-3">
                            <a href="/contact" class="flex items-center text-gray-700 hover:text-primary-500 py-2 px-3 rounded-lg hover:bg-gray-50 transition-all">
                                <i class="fas fa-envelope mr-3 text-accent-500"></i>
                                Contact Event Team
                            </a>
                            <a href="#" class="flex items-center text-gray-700 hover:text-primary-500 py-2 px-3 rounded-lg hover:bg-gray-50 transition-all">
                                <i class="fas fa-calendar-alt mr-3 text-accent-500"></i>
                                Event Calendar
                            </a>
                            <a href="#" class="flex items-center text-gray-700 hover:text-primary-500 py-2 px-3 rounded-lg hover:bg-gray-50 transition-all">
                                <i class="fas fa-microphone mr-3 text-accent-500"></i>
                                Become a Speaker
                            </a>
                            <a href="#" class="flex items-center text-gray-700 hover:text-primary-500 py-2 px-3 rounded-lg hover:bg-gray-50 transition-all">
                                <i class="fas fa-handshake mr-3 text-accent-500"></i>
                                Sponsor an Event
                            </a>
                        </div>
                    </div>
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

// Event filtering
const filterButtons = document.querySelectorAll('.filter-button');
const eventCards = document.querySelectorAll('[data-category]');

filterButtons.forEach(button => {
    button.addEventListener('click', () => {
        const selectedFilter = button.getAttribute('data-filter');
        
        // Update button styles
        filterButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn === button) {
                btn.classList.remove('bg-white', 'text-primary-500', 'border-primary-500');
                btn.classList.add('bg-primary-500', 'text-white', 'active');
            } else {
                btn.classList.remove('bg-primary-500', 'text-white');
                btn.classList.add('bg-white', 'text-primary-500', 'border-2', 'border-primary-500');
            }
        });
        
        // Filter events
        eventCards.forEach(card => {
            const eventCategory = card.getAttribute('data-category');
            if (selectedFilter === 'all' || eventCategory === selectedFilter) {
                card.style.display = 'block';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
    });
});

// Newsletter form submission
const newsletterForm = document.getElementById('events-newsletter-form');
if (newsletterForm) {
    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // In a real implementation, this would submit to the backend
        const button = this.querySelector('button');
        const originalText = button.innerHTML;
        
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Subscribing...';
        button.disabled = true;
        
        setTimeout(() => {
            button.innerHTML = '<i class="fas fa-check mr-2"></i>Subscribed!';
            button.classList.remove('bg-primary-500', 'hover:bg-primary-600');
            button.classList.add('bg-green-500');
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
                button.classList.remove('bg-green-500');
                button.classList.add('bg-primary-500', 'hover:bg-primary-600');
                this.reset();
            }, 3000);
        }, 2000);
    });
}

// Add scroll-triggered animations
const observeElements = document.querySelectorAll('.event-card, .animate-slideInLeft');
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