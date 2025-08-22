<?php
// index.php - Main homepage with component architecture
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/security.php';

// Page configuration
$page_title = "Importance Leadership | Developing Ethical Leaders for Global Impact";
$meta_description = "Empowering young leaders in Kenya through mentorship, education, and advocacy for ethical leadership and community impact.";
$meta_keywords = "youth leadership, leadership development, mentorship programs, community impact, African leadership, social change";
$canonical_url = "https://www.importanceleadership.com";
$body_class = "homepage";

// Load dynamic content data
$impact_stats = [
    'leaders_trained' => 1500,
    'communities_impacted' => 50,
    'countries' => 3
];

$featured_programs = [
    [
        'title' => 'Leadership Development',
        'description' => 'A transformative 12-week program focused on building core leadership competencies through workshops, projects, and mentorship.',
        'image' => '/assets/images/programs/leadership-development.jpg',
        'slug' => 'leadership-development',
        'duration' => '12 weeks'
    ],
    [
        'title' => 'Professional Networking', 
        'description' => 'Expand your professional and social circles through curated networking events and access to a vibrant community of leaders.',
        'image' => '/assets/images/programs/mentorship.jpg',
        'slug' => 'networking',
        'duration' => 'Ongoing'
    ],
    [
        'title' => 'Advocacy Initiatives',
        'description' => 'Empowers youth to become effective advocates for social justice, equity, and policy change in their communities.',
        'image' => '/assets/images/programs/advocacy-program.jpg', 
        'slug' => 'advocacy',
        'duration' => 'Quarterly'
    ],
    [
        'title' => 'Mental Health Program',
        'description' => 'Supporting youth wellbeing through mental health education, peer support, and access to professional resources.',
        'image' => '/assets/images/programs/mental-health.jpg',
        'slug' => 'mental-health',
        'duration' => 'Ongoing'
    ],
    [
        'title' => 'Climate Change Awareness',
        'description' => 'Empowering youth to understand, address, and advocate for solutions to climate change through education and projects.',
        'image' => '/assets/images/programs/climate-change.jpg',
        'slug' => 'climate-change',
        'duration' => 'Seasonal'
    ]
];

// Additional head content for homepage
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/og-image.jpg">
<meta property="og:url" content="' . $canonical_url . '">
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Importance Leadership Organization",
    "url": "' . $canonical_url . '",
    "logo": "' . $canonical_url . '/assets/images/icons/logo.png",
    "description": "' . $meta_description . '",
    "foundingDate": "2020",
    "address": {
        "@type": "PostalAddress",
        "addressLocality": "Concord",
        "addressRegion": "New Hampshire", 
        "postalCode": "03301",
        "addressCountry": "US"
    },
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+1-603-715-0801",
        "contactType": "customer service"
    },
    "sameAs": [
        "https://www.facebook.com/share/15LKEyn6fy/?mibextid=wwXIfr",
        "https://www.instagram.com/importance_leadership_?igsh=bGZ1bHB1dm1vdHY2&utm_source=qr",
        "https://www.linkedin.com/company/105744530/admin/dashboard/",
        "https://youtube.com/@importanceleadership?si=mzd00nPXob5XBBBl"
    ]
}
</script>';

// Include header and navigation
include 'components/header.php';
include 'components/nav.php';
?>

<!-- Skip to content link for accessibility -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary-500 text-white px-4 py-2 rounded-lg z-50">
    Skip to main content
</a>

<!-- Main Content -->
<main id="main-content">
    <!-- Hero Section -->
    <?php include 'components/sections/hero.php'; ?>
    
    <!-- Programs Section -->
    <section class="py-20 bg-gray-50" id="programs">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Transformative Leadership Initiatives
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Our innovative programs equip young Africans with the skills, mindset, and networks needed to become transformative leaders in their communities and beyond.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($featured_programs as $index => $program): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="relative overflow-hidden">
                            <img src="<?= htmlspecialchars($program['image']) ?>" 
                                 alt="<?= htmlspecialchars($program['title']) ?>"
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-6">
                                <a href="/programs/<?= htmlspecialchars($program['slug']) ?>" 
                                   class="bg-white text-primary-500 px-4 py-2 rounded-lg font-semibold hover:bg-primary-500 hover:text-white transition-all duration-300">
                                    Learn More
                                </a>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-primary-500 mb-3 font-secondary">
                                <?= htmlspecialchars($program['title']) ?>
                            </h3>
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                <?= htmlspecialchars($program['description']) ?>
                            </p>
                            
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-clock text-accent-500"></i>
                                    <?= htmlspecialchars($program['duration']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Impact Section -->
    <section class="py-20 bg-primary-500 text-white" id="impact">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary mb-6">
                    Our Measurable Impact
                </h2>
                <p class="text-xl opacity-95 max-w-3xl mx-auto leading-relaxed">
                    Quantifying our commitment to youth development and community transformation.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div class="impact-stat" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-5xl md:text-6xl font-bold text-accent-500 mb-4" data-counter="2500">0</div>
                    <h3 class="text-xl font-semibold mb-2">Youth Empowered</h3>
                    <p class="opacity-90">Through our leadership programs and initiatives</p>
                </div>
                <div class="impact-stat" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-5xl md:text-6xl font-bold text-accent-500 mb-4" data-counter="20">0</div>
                    <h3 class="text-xl font-semibold mb-2">Dedicated Mentors</h3>
                    <p class="opacity-90">Guiding the next generation of leaders</p>
                </div>
                <div class="impact-stat" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-5xl md:text-6xl font-bold text-accent-500 mb-4" data-counter="13">0</div>
                    <h3 class="text-xl font-semibold mb-2">Workshops</h3>
                    <p class="opacity-90">Leadership training and skill development</p>
                </div>
                <div class="impact-stat" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-5xl md:text-6xl font-bold text-accent-500 mb-4" data-counter="14">0</div>
                    <h3 class="text-xl font-semibold mb-2">Communities</h3>
                    <p class="opacity-90">Positively impacted across the region</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Partners Section -->
    <section class="py-20 bg-white" id="partners">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Our Valued Partners
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Together with mission-aligned organizations, we're creating transformative youth leadership opportunities. Join our network to amplify your impact.
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
                        <img src="/assets/images/partners/Save the children.png" 
                             alt="Save the Children"
                             class="w-full h-16 object-contain filter grayscale hover:grayscale-0 transition-all duration-300">
                    </a>
                </div>
                <div class="partner-logo" data-aos="fade-up" data-aos-delay="300">
                    <a href="https://www.wya.net" target="_blank" rel="noopener noreferrer" class="block p-4 rounded-lg hover:shadow-lg transition-all duration-300">
                        <img src="/assets/images/partners/World Youth Alliance.png" 
                             alt="World Youth Alliance"
                             class="w-full h-16 object-contain filter grayscale hover:grayscale-0 transition-all duration-300">
                    </a>
                </div>
                <div class="partner-logo" data-aos="fade-up" data-aos-delay="400">
                    <a href="https://plan-international.org" target="_blank" rel="noopener noreferrer" class="block p-4 rounded-lg hover:shadow-lg transition-all duration-300">
                        <img src="/assets/images/partners/Plan International.png" 
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
            
            <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="700">
                <p class="text-lg text-gray-600 mb-6">Ready to join our partner network?</p>
                <a href="/partnerships" class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    Explore Partnership Opportunities
                </a>
            </div>
        </div>
    </section>
    
    <!-- Call to Action Section -->
    <section class="py-20 bg-gradient-to-r from-accent-500 to-accent-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-4xl mx-auto" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary mb-6">
                    Ready to Be Part of the Change?
                </h2>
                <p class="text-xl mb-8 opacity-95 leading-relaxed">
                    Whether you're a young leader looking to grow, a professional willing to mentor, or an organization wanting to partner, there are many ways to get involved in our mission.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/join-us" class="bg-white text-accent-500 hover:bg-gray-100 px-8 py-4 rounded-lg font-bold text-lg transition-all duration-300 transform hover:scale-105">
                        Sign Up Now
                    </a>
                    <a href="/donate" class="border-2 border-white text-white hover:bg-white hover:text-accent-500 px-8 py-4 rounded-lg font-bold text-lg transition-all duration-300">
                        Donate
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// Impact Section Counter Animation
document.addEventListener('DOMContentLoaded', function() {
    function animateImpactCounters() {
        const counters = document.querySelectorAll('.impact-stat [data-counter]');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-counter'));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;
            
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    // Only add + for 2500 and 20, not for 13 and 14
                    const shouldHavePlus = target === 2500 || target === 20;
                    counter.textContent = target + (shouldHavePlus ? '+' : '');
                    clearInterval(timer);
                } else {
                    const shouldHavePlus = target === 2500 || target === 20;
                    counter.textContent = Math.floor(current) + (shouldHavePlus ? '+' : '');
                }
            }, 16);
        });
    }
    
    // Intersection Observer for impact counter animation
    const impactObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('impact-counted')) {
                entry.target.classList.add('impact-counted');
                animateImpactCounters();
            }
        });
    }, { threshold: 0.5 });
    
    const impactSection = document.querySelector('#impact');
    if (impactSection) {
        impactObserver.observe(impactSection);
    }
});
</script>

<?php include 'components/footer.php'; ?>