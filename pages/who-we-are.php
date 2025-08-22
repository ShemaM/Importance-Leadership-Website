<?php
// pages/who-we-are.php - Who We Are page with component architecture
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Who We Are | Importance Leadership";
$meta_description = "Discover our mission, vision, and the team behind Importance Leadership.";
$meta_keywords = "Leadership, Impact, Community, Mentorship, Youth Empowerment";
$canonical_url = "https://www.importanceleadership.com/who-we-are";
$body_class = "who-we-are-page";

// Additional head content for who we are page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/icons/logo.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/icons/logo.jpg">';

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
            <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                 style="background-image: url('/assets/images/backgrounds/hero-bg.jpg')"></div>
        </div>
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/80 to-primary-700/90 z-10"></div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-20 py-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6" data-aos="fade-up" data-aos-delay="100">
                    <span class="text-white">Meet the Heart of</span>
                    <br>
                    <span class="text-accent-500 font-bold">Importance Leadership</span>
                </h1>
                
                <p class="text-xl md:text-2xl mb-8 opacity-95 max-w-4xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                    We are a dynamic movement of changemakers, mentors, and advocates committed to unlocking the leadership potential in every young person. Our mission is to inspire, empower, and equip youth to create lasting impact in their communities and beyond.
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="300">
                    <a href="#about" class="bg-accent-500 hover:bg-accent-600 text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        Background History
                    </a>
                    <a href="/team" class="border-2 border-white text-white hover:bg-white hover:text-primary-500 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300">
                        Meet the Team
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Background History Section -->
    <section id="about" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Background History
                </h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto"></div>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Founder Card -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative overflow-hidden">
                        <img src="/assets/images/team/fiston.png" 
                             alt="Fiston Ndayishimiye"
                             class="w-full h-96 object-cover object-center">
                    </div>
                    
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-primary-500 mb-2 font-secondary">
                            Fiston Ndayishimiye
                        </h3>
                        <span class="text-accent-500 font-semibold text-lg block mb-4">
                            Founder & Visionary Leader
                        </span>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            "Empowering young people to become ethical, inclusive, and purpose-driven leaders."
                        </p>
                        <a href="/team#fisto" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            Learn More
                        </a>
                    </div>
                </div>
                
                <!-- About Text -->
                <div class="space-y-6" data-aos="fade-up" data-aos-delay="200">
                    <p class="text-xl font-semibold text-primary-500 leading-relaxed">
                        Importance Leadership is a non-profit youth-led organization dedicated to empowering youth through advocacy and education.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        We advocate for equality, equity, and justice for youth, particularly refugees, minorities, and the underprivileged. Our programs provide mentorship, mental health training, climate change awareness, and leadership development to help young people actively participate in shaping policies and solutions that impact their lives.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Founded by Fiston Ndayishimiye, whose journey from the Democratic Republic of Congo to becoming a visionary leader exemplifies resilience and determination. His experiences with war, ethnic conflict, and systemic oppression fuel his mission to create change.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Inspired by leaders like Patrice Lumumba, Martin Luther King Jr., and Malcolm X, Fiston believes in the power of youth to transform society. "I don't believe in democracy, but I believe in the young generation," he says. "The future will change; the future must change."
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Since its founding, Importance Leadership has impacted thousands of young people, helping them develop the skills and confidence to become leaders in their communities.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Mission & Vision Section -->
    <section class="py-20 bg-primary-500 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary mb-6">
                    Our Mission & Vision
                </h2>
                <div class="w-20 h-1 bg-accent-500 mx-auto"></div>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Mission Card -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border-l-4 border-accent-500 hover:transform hover:-translate-y-2 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-accent-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-primary-500 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold font-secondary mb-4">Our Mission</h3>
                    <p class="text-xl font-semibold mb-4 opacity-100">
                        Mobilize, Inspire, and Empower youth to become transformative leaders.
                    </p>
                    <p class="opacity-90 leading-relaxed">
                        Through education, advocacy, and mentorship, we foster an inclusive world where every young person can unlock their full potential. Our programs focus on leadership training, life skills development, environmental awareness, and community engagement.
                    </p>
                </div>
                
                <!-- Vision Card -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border-l-4 border-accent-500 hover:transform hover:-translate-y-2 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-accent-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-primary-500 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold font-secondary mb-4">Our Vision</h3>
                    <p class="text-xl font-semibold mb-4 opacity-100">
                        An inclusive world where every youth is empowered to lead and create impact.
                    </p>
                    <p class="opacity-90 leading-relaxed">
                        We envision communities transformed by ethical, purpose-driven young leaders who champion equality and justice. Our vision is rooted in the belief that empowered youth can solve the world's greatest challenges when given the right tools and opportunities.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action Section -->
    <section class="py-20 bg-gradient-to-r from-accent-500 to-accent-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-4xl mx-auto" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary mb-6">
                    Ready to Join Our Movement?
                </h2>
                <p class="text-xl mb-8 opacity-95 leading-relaxed">
                    Become part of our mission to empower the next generation of leaders.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/join-us" class="bg-white text-accent-500 hover:bg-gray-100 px-8 py-4 rounded-lg font-bold text-lg transition-all duration-300 transform hover:scale-105">
                        Get Involved
                    </a>
                    <a href="/donate" class="border-2 border-white text-white hover:bg-white hover:text-accent-500 px-8 py-4 rounded-lg font-bold text-lg transition-all duration-300">
                        Donate Now
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../components/footer.php'; ?>