<?php
// pages/team.php - Team page with component architecture
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Team - Importance Leadership";
$meta_description = "Meet the Leaders and Departments Driving Change and Innovation.";
$meta_keywords = "Leadership, Impact, Community, Mentorship, Youth Empowerment";
$canonical_url = "https://www.importanceleadership.com/team";
$body_class = "team-page";

// Team members data
$team_members = [
    [
        'name' => 'Fiston Ndayishimiye',
        'position' => 'CEO & Founder',
        'department' => 'leadership',
        'image' => 'fiston.png',
        'bio' => 'Providing strategic leadership and driving organizational excellence with expertise in youth empowerment and innovation.',
        'modal_id' => 'fistonModal'
    ],
    [
        'name' => 'Bonkey Muhumure',
        'position' => 'HR Manager',
        'department' => 'operations',
        'image' => 'Bonkey.png',
        'bio' => 'Building strong organizational culture through effective talent management and employee development.',
        'modal_id' => 'bonkeyModal'
    ],
    [
        'name' => 'Uwase Joyeuse',
        'position' => 'Secretariat',
        'department' => 'operations',
        'image' => 'uwase.png',
        'bio' => 'Ensuring seamless communication and efficient administrative operations across the organization.',
        'modal_id' => 'uwaseModal'
    ],
    [
        'name' => 'Mike',
        'position' => 'Marketing Director',
        'department' => 'marketing',
        'image' => 'Mick.jpg',
        'bio' => 'Creative strategist building brand awareness and engagement through innovative campaigns.',
        'modal_id' => 'mikeModal'
    ],
    [
        'name' => 'Shema Manasseh',
        'position' => 'Software Engineer',
        'department' => 'technology',
        'image' => 'shema.png',
        'bio' => 'Technology architect ensuring robust digital infrastructure and innovative solutions.',
        'modal_id' => 'shemaModal'
    ],
    [
        'name' => 'Pacific Muhumure',
        'position' => 'Operations Lead',
        'department' => 'operations',
        'image' => 'pacific.jpg',
        'bio' => 'Efficiency expert optimizing processes and ensuring seamless day-to-day operations.',
        'modal_id' => 'pacificModal'
    ],
    [
        'name' => 'Fabiola Baraka',
        'position' => 'Finance Manager',
        'department' => 'finance',
        'image' => 'fabiola.png',
        'bio' => 'Financial steward ensuring fiscal responsibility and sustainable resource allocation.',
        'modal_id' => 'fabiolaModal'
    ],
    [
        'name' => 'Ingabire Grace',
        'position' => 'Research Lead',
        'department' => 'operations',
        'image' => 'Grace.png',
        'bio' => 'Data-driven analyst providing insights that shape organizational strategy and impact.',
        'modal_id' => 'graceModal'
    ]
];

// Additional head content for team page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/team/ourTeam.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/team/ourTeam.jpg">';

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
    <section class="relative h-screen min-h-[500px] flex items-center justify-center text-white overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 z-0">
            <div class="w-full h-full bg-cover bg-center bg-no-repeat" 
                 style="background-image: url('/assets/images/team/ourTeam.jpg')"></div>
        </div>
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/80 to-primary-700/90 z-10"></div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 relative z-20 py-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6" data-aos="fade-up" data-aos-delay="100">
                    Our Leadership Team
                </h1>
                
                <p class="text-xl md:text-2xl mb-8 opacity-95 max-w-4xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                    Meet the passionate individuals who drive our mission forward with dedication and expertise
                </p>
            </div>
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20" data-aos="fade-up" data-aos-delay="300">
            <div class="w-6 h-10 border-2 border-white rounded-full flex justify-center cursor-pointer" onclick="document.getElementById('team').scrollIntoView({behavior: 'smooth'})">
                <div class="w-1 h-3 bg-white rounded-full animate-bounce mt-2"></div>
            </div>
        </div>
    </section>
    
    <!-- Team Section -->
    <section id="team" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-secondary text-primary-500 mb-6">
                    Meet Our Experts
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Our team consists of dedicated professionals who bring diverse skills and experiences to create meaningful impact
                </p>
                <div class="w-20 h-1 bg-accent-500 mx-auto mt-6"></div>
            </div>
            
            <!-- Department Filter Tabs -->
            <div class="flex flex-wrap justify-center gap-4 mb-12" data-aos="fade-up" data-aos-delay="100">
                <button class="filter-btn active px-6 py-3 rounded-full bg-primary-500 text-white font-semibold transition-all duration-300 hover:bg-primary-600" data-filter="all">
                    All Departments
                </button>
                <button class="filter-btn px-6 py-3 rounded-full bg-white text-primary-500 border-2 border-primary-500 font-semibold transition-all duration-300 hover:bg-primary-500 hover:text-white" data-filter="leadership">
                    Leadership
                </button>
                <button class="filter-btn px-6 py-3 rounded-full bg-white text-primary-500 border-2 border-primary-500 font-semibold transition-all duration-300 hover:bg-primary-500 hover:text-white" data-filter="operations">
                    Operations
                </button>
                <button class="filter-btn px-6 py-3 rounded-full bg-white text-primary-500 border-2 border-primary-500 font-semibold transition-all duration-300 hover:bg-primary-500 hover:text-white" data-filter="marketing">
                    Marketing
                </button>
                <button class="filter-btn px-6 py-3 rounded-full bg-white text-primary-500 border-2 border-primary-500 font-semibold transition-all duration-300 hover:bg-primary-500 hover:text-white" data-filter="technology">
                    Technology
                </button>
                <button class="filter-btn px-6 py-3 rounded-full bg-white text-primary-500 border-2 border-primary-500 font-semibold transition-all duration-300 hover:bg-primary-500 hover:text-white" data-filter="finance">
                    Finance
                </button>
            </div>
            
            <!-- Team Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php foreach ($team_members as $index => $member): ?>
                    <div class="team-card bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 cursor-pointer" 
                         data-department="<?= htmlspecialchars($member['department']) ?>" 
                         data-aos="fade-up" 
                         data-aos-delay="<?= ($index % 4) * 100 ?>"
                         onclick="openModal('<?= htmlspecialchars($member['modal_id']) ?>')">
                        
                        <div class="relative overflow-hidden">
                            <img src="/assets/images/team/<?= htmlspecialchars($member['image']) ?>" 
                                 alt="<?= htmlspecialchars($member['name']) ?>"
                                 class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 hover:opacity-100 transition-all duration-300 flex items-end p-6">
                                <div class="text-white">
                                    <p class="font-semibold">Click to learn more</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-primary-500 mb-2 font-secondary">
                                <?= htmlspecialchars($member['name']) ?>
                            </h3>
                            <p class="text-accent-500 font-semibold mb-3">
                                <?= htmlspecialchars($member['position']) ?>
                            </p>
                            <p class="text-gray-600 leading-relaxed">
                                <?= htmlspecialchars($member['bio']) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<!-- Team Member Modals -->
<!-- Fiston Modal -->
<div id="fistonModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-2xl font-bold text-primary-500">Team Member Details</h3>
                <button onclick="closeModal('fistonModal')" class="text-gray-500 hover:text-red-500 text-2xl font-bold">×</button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <img src="/assets/images/team/fiston.png" alt="Fiston Ndayishimiye" class="w-full h-80 object-cover rounded-lg mb-4">
                </div>
                <div>
                    <h4 class="text-2xl font-bold text-primary-500 mb-2">Fiston Ndayishimiye</h4>
                    <p class="text-accent-500 font-semibold mb-4">CEO & Founder</p>
                    <p class="text-gray-600 mb-4">Fiston Ndayishimiye is the visionary founder of Importance Leadership. With a passion for empowering youth, he provides strategic leadership and drives the organization's mission to mobilize, inspire, and empower young individuals to become change-makers.</p>
                    <p class="text-gray-600 mb-6">Under his leadership, Importance Leadership has achieved significant milestones, including financial sustainability, stakeholder engagement, and operational excellence across all departments. Fiston's dedication to innovation and growth continues to inspire the next generation of leaders.</p>
                    
                    <div class="mb-6">
                        <h5 class="font-bold text-gray-800 mb-3">Key Skills</h5>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Strategic Leadership</span>
                                    <span class="text-sm text-gray-500">95%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-primary-500 h-2 rounded-full" style="width: 95%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Youth Empowerment</span>
                                    <span class="text-sm text-gray-500">90%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-primary-500 h-2 rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Organizational Development</span>
                                    <span class="text-sm text-gray-500">85%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-primary-500 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Team filtering functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const teamCards = document.querySelectorAll('.team-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.getAttribute('data-filter');
            
            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-primary-500', 'text-white');
                btn.classList.add('bg-white', 'text-primary-500', 'border-2', 'border-primary-500');
            });
            button.classList.add('active', 'bg-primary-500', 'text-white');
            button.classList.remove('bg-white', 'text-primary-500', 'border-2', 'border-primary-500');
            
            // Filter team cards
            teamCards.forEach(card => {
                const cardDepartment = card.getAttribute('data-department');
                if (filter === 'all' || cardDepartment === filter) {
                    card.style.display = 'block';
                    card.classList.remove('hidden');
                } else {
                    card.style.display = 'none';
                    card.classList.add('hidden');
                }
            });
        });
    });
});

// Modal functionality
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
        const modals = document.querySelectorAll('[id$="Modal"]');
        modals.forEach(modal => {
            modal.classList.add('hidden');
        });
        document.body.style.overflow = 'auto';
    }
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>