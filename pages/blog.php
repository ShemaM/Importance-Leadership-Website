<?php
// pages/blog.php - Blog Page with component architecture
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Blog | Leadership Insights & Youth Empowerment Stories | Importance Leadership";
$meta_description = "Read the latest insights, stories, and updates from Importance Leadership. Discover leadership tips, youth empowerment success stories, and community impact articles.";
$meta_keywords = "leadership blog, youth empowerment, leadership insights, community impact, mentorship stories, leadership development";
$canonical_url = "https://www.importanceleadership.com/blog";
$body_class = "blog-page";

// Additional head content for blog page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/blog-hero.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/blog-hero.jpg">
<style>
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
@keyframes slideInRight {
    0% { opacity: 0; transform: translateX(30px); }
    100% { opacity: 1; transform: translateX(0); }
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
.blog-card {
    transition: all 0.3s ease;
}
.blog-card:hover {
    transform: translateY(-10px);
}
.blog-card img {
    transition: all 0.3s ease;
}
.blog-card:hover img {
    transform: scale(1.05);
}
.gradient-overlay {
    background: linear-gradient(135deg, rgba(11, 31, 58, 0.9) 0%, rgba(11, 31, 58, 0.7) 100%);
}
.search-input:focus {
    box-shadow: 0 0 0 3px rgba(124, 173, 233, 0.2);
}
.category-tag {
    transition: all 0.3s ease;
}
.category-tag:hover {
    transform: scale(1.05);
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
                    INSIGHTS & STORIES
                </span>
                <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6 animate-fadeInUp">
                    Our Blog
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-95 animate-fadeInUp">
                    Discover leadership insights, youth empowerment stories, and the latest updates from our community impact initiatives.
                </p>
                <div class="flex justify-center animate-fadeInUp">
                    <div class="relative max-w-md w-full">
                        <input type="text" id="blog-search" 
                               class="w-full px-6 py-4 pr-12 rounded-full text-gray-800 search-input focus:outline-none focus:ring-2 focus:ring-accent-500" 
                               placeholder="Search articles...">
                        <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-primary-500 transition-colors">
                            <i class="fas fa-search text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 left-0 right-0 text-center animate-bounce">
            <a href="#blog-content" class="text-white text-2xl">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Blog Content Section -->
    <section id="blog-content" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-4 gap-12">
                <!-- Main Blog Content -->
                <div class="lg:col-span-3">
                    <!-- Category Filters -->
                    <div class="mb-12">
                        <div class="flex flex-wrap gap-3">
                            <button class="category-tag bg-primary-500 text-white px-4 py-2 rounded-full font-semibold transition-all transform hover:scale-105" data-category="all">
                                All Posts
                            </button>
                            <button class="category-tag bg-white text-primary-500 border-2 border-primary-500 px-4 py-2 rounded-full font-semibold transition-all transform hover:scale-105" data-category="leadership">
                                Leadership
                            </button>
                            <button class="category-tag bg-white text-primary-500 border-2 border-primary-500 px-4 py-2 rounded-full font-semibold transition-all transform hover:scale-105" data-category="mentorship">
                                Mentorship
                            </button>
                            <button class="category-tag bg-white text-primary-500 border-2 border-primary-500 px-4 py-2 rounded-full font-semibold transition-all transform hover:scale-105" data-category="community">
                                Community Impact
                            </button>
                            <button class="category-tag bg-white text-primary-500 border-2 border-primary-500 px-4 py-2 rounded-full font-semibold transition-all transform hover:scale-105" data-category="events">
                                Events
                            </button>
                        </div>
                    </div>

                    <!-- Blog Posts -->
                    <div class="space-y-12" id="blog-posts">
                        <!-- Featured Post -->
                        <article class="blog-card bg-white rounded-2xl shadow-xl overflow-hidden" data-category="leadership">
                            <div class="grid md:grid-cols-2">
                                <div class="relative h-64 md:h-auto">
                                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                         alt="Leadership Development" 
                                         class="w-full h-full object-cover">
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-accent-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Featured</span>
                                    </div>
                                </div>
                                <div class="p-8">
                                    <div class="flex items-center text-sm text-gray-500 mb-4">
                                        <span class="bg-primary-100 text-primary-500 px-2 py-1 rounded mr-3">Leadership</span>
                                        <span>December 15, 2024</span>
                                        <span class="mx-2">•</span>
                                        <span>5 min read</span>
                                    </div>
                                    <h2 class="text-2xl md:text-3xl font-bold font-secondary text-primary-500 mb-4">
                                        The Power of Authentic Leadership in Youth Development
                                    </h2>
                                    <p class="text-gray-600 mb-6">
                                        Exploring how authentic leadership principles can transform youth development programs and create lasting impact in communities. Learn from our experiences working with young leaders across different cultures.
                                    </p>
                                    <a href="#" class="inline-flex items-center text-primary-500 font-semibold hover:text-primary-600 transition-colors">
                                        Read Full Article
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </article>

                        <!-- Regular Posts -->
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Post 1 -->
                            <article class="blog-card bg-white rounded-2xl shadow-xl overflow-hidden" data-category="mentorship">
                                <div class="relative h-48">
                                    <img src="https://images.unsplash.com/photo-1529390079861-591de354faf5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                         alt="Mentorship Program" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <span class="bg-green-100 text-green-600 px-2 py-1 rounded mr-3">Mentorship</span>
                                        <span>December 10, 2024</span>
                                    </div>
                                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">
                                        Building Effective Mentorship Programs
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        Key strategies for creating mentorship programs that truly make a difference in young people's lives.
                                    </p>
                                    <a href="#" class="inline-flex items-center text-primary-500 font-semibold hover:text-primary-600 transition-colors">
                                        Read More
                                        <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                    </a>
                                </div>
                            </article>

                            <!-- Post 2 -->
                            <article class="blog-card bg-white rounded-2xl shadow-xl overflow-hidden" data-category="community">
                                <div class="relative h-48">
                                    <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                         alt="Community Impact" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded mr-3">Community</span>
                                        <span>December 8, 2024</span>
                                    </div>
                                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">
                                        Measuring Community Impact: Our Approach
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        How we track and measure the real-world impact of our youth empowerment initiatives.
                                    </p>
                                    <a href="#" class="inline-flex items-center text-primary-500 font-semibold hover:text-primary-600 transition-colors">
                                        Read More
                                        <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                    </a>
                                </div>
                            </article>

                            <!-- Post 3 -->
                            <article class="blog-card bg-white rounded-2xl shadow-xl overflow-hidden" data-category="events">
                                <div class="relative h-48">
                                    <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                         alt="Leadership Conference" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded mr-3">Events</span>
                                        <span>December 5, 2024</span>
                                    </div>
                                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">
                                        2024 Leadership Summit Highlights
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        Key takeaways and inspiring moments from our annual youth leadership summit.
                                    </p>
                                    <a href="#" class="inline-flex items-center text-primary-500 font-semibold hover:text-primary-600 transition-colors">
                                        Read More
                                        <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                    </a>
                                </div>
                            </article>

                            <!-- Post 4 -->
                            <article class="blog-card bg-white rounded-2xl shadow-xl overflow-hidden" data-category="leadership">
                                <div class="relative h-48">
                                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                         alt="Youth Leadership" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <span class="bg-primary-100 text-primary-500 px-2 py-1 rounded mr-3">Leadership</span>
                                        <span>December 1, 2024</span>
                                    </div>
                                    <h3 class="text-xl font-bold font-secondary text-primary-500 mb-3">
                                        Empowering Youth Through Digital Leadership
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        How digital platforms are revolutionizing youth leadership development programs.
                                    </p>
                                    <a href="#" class="inline-flex items-center text-primary-500 font-semibold hover:text-primary-600 transition-colors">
                                        Read More
                                        <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                    </a>
                                </div>
                            </article>
                        </div>

                        <!-- Load More Button -->
                        <div class="text-center mt-12">
                            <button class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-8 rounded-full transition-all transform hover:-translate-y-1 shadow-lg">
                                <i class="fas fa-plus mr-2"></i>Load More Articles
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Newsletter Subscription -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 animate-slideInRight">
                        <div class="text-center mb-6">
                            <div class="bg-accent-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-envelope text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold font-secondary text-primary-500 mb-2">Stay Updated</h3>
                            <p class="text-gray-600">Get the latest insights delivered to your inbox.</p>
                        </div>
                        <form class="space-y-4" id="newsletter-form">
                            <div>
                                <input type="email" name="email" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500" 
                                       placeholder="Enter your email">
                            </div>
                            <button type="submit" 
                                    class="w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-6 rounded-lg transition-all transform hover:-translate-y-1">
                                <i class="fas fa-paper-plane mr-2"></i>Subscribe
                            </button>
                        </form>
                    </div>

                    <!-- Popular Posts -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 animate-slideInRight">
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                            <i class="fas fa-fire text-accent-500 mr-2"></i>Popular Posts
                        </h3>
                        <div class="space-y-4">
                            <article class="flex space-x-4">
                                <img src="https://images.unsplash.com/photo-1517180102446-f3ece451e9d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                     alt="Popular post" 
                                     class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-primary-500 text-sm leading-tight mb-1">
                                        10 Leadership Principles Every Young Leader Should Know
                                    </h4>
                                    <p class="text-xs text-gray-500">November 28, 2024</p>
                                </div>
                            </article>
                            
                            <article class="flex space-x-4">
                                <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                     alt="Popular post" 
                                     class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-primary-500 text-sm leading-tight mb-1">
                                        Building Resilience in Youth Communities
                                    </h4>
                                    <p class="text-xs text-gray-500">November 25, 2024</p>
                                </div>
                            </article>
                            
                            <article class="flex space-x-4">
                                <img src="https://images.unsplash.com/photo-1551818255-e6e10975bc17?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                     alt="Popular post" 
                                     class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-primary-500 text-sm leading-tight mb-1">
                                        The Future of Youth Empowerment Programs
                                    </h4>
                                    <p class="text-xs text-gray-500">November 22, 2024</p>
                                </div>
                            </article>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 animate-slideInRight">
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                            <i class="fas fa-tags text-accent-500 mr-2"></i>Categories
                        </h3>
                        <div class="space-y-3">
                            <a href="#" class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <span class="text-gray-700">Leadership Development</span>
                                <span class="bg-primary-100 text-primary-500 text-xs px-2 py-1 rounded-full">12</span>
                            </a>
                            <a href="#" class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <span class="text-gray-700">Mentorship</span>
                                <span class="bg-primary-100 text-primary-500 text-xs px-2 py-1 rounded-full">8</span>
                            </a>
                            <a href="#" class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <span class="text-gray-700">Community Impact</span>
                                <span class="bg-primary-100 text-primary-500 text-xs px-2 py-1 rounded-full">15</span>
                            </a>
                            <a href="#" class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <span class="text-gray-700">Events & Updates</span>
                                <span class="bg-primary-100 text-primary-500 text-xs px-2 py-1 rounded-full">6</span>
                            </a>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 animate-slideInRight">
                        <h3 class="text-xl font-bold font-secondary text-primary-500 mb-6 flex items-center">
                            <i class="fas fa-share-alt text-accent-500 mr-2"></i>Follow Us
                        </h3>
                        <div class="flex space-x-3">
                            <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="bg-blue-400 hover:bg-blue-500 text-white w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="bg-blue-700 hover:bg-blue-800 text-white w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="bg-pink-500 hover:bg-pink-600 text-white w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                                <i class="fab fa-instagram"></i>
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

// Category filtering
const categoryButtons = document.querySelectorAll('.category-tag');
const blogPosts = document.querySelectorAll('[data-category]');

categoryButtons.forEach(button => {
    button.addEventListener('click', () => {
        const selectedCategory = button.getAttribute('data-category');
        
        // Update button styles
        categoryButtons.forEach(btn => {
            if (btn === button) {
                btn.classList.remove('bg-white', 'text-primary-500', 'border-primary-500');
                btn.classList.add('bg-primary-500', 'text-white');
            } else {
                btn.classList.remove('bg-primary-500', 'text-white');
                btn.classList.add('bg-white', 'text-primary-500', 'border-2', 'border-primary-500');
            }
        });
        
        // Filter posts
        blogPosts.forEach(post => {
            if (selectedCategory === 'all' || post.getAttribute('data-category') === selectedCategory) {
                post.style.display = 'block';
                post.style.opacity = '1';
            } else {
                post.style.opacity = '0';
                setTimeout(() => {
                    post.style.display = 'none';
                }, 300);
            }
        });
    });
});

// Search functionality
const searchInput = document.getElementById('blog-search');
const posts = document.querySelectorAll('.blog-card');

searchInput.addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    
    posts.forEach(post => {
        const title = post.querySelector('h2, h3').textContent.toLowerCase();
        const content = post.querySelector('p').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || content.includes(searchTerm)) {
            post.style.display = 'block';
            post.style.opacity = '1';
        } else {
            post.style.opacity = '0';
            setTimeout(() => {
                post.style.display = 'none';
            }, 300);
        }
    });
});

// Newsletter form submission
const newsletterForm = document.getElementById('newsletter-form');
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
const observeElements = document.querySelectorAll('.blog-card, .animate-slideInRight');
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