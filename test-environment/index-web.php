<?php
// index-web.php - Web version using test config
$page_title = "Welcome to Importance Leadership | Empowering Future Leaders";
$meta_description = "Importance Leadership Organization empowers young people through leadership development, mentorship programs, and community impact initiatives across Africa and beyond.";
$meta_keywords = "leadership, youth empowerment, Africa, mentorship, community development, importance leadership";
$body_class = "home-page";

// Additional head content for home page
$additional_head = '
    <meta property="og:title" content="Importance Leadership Organization">
    <meta property="og:description" content="Empowering young leaders across Africa through comprehensive leadership development programs">
    <meta property="og:image" content="/images/hero-bg.jpg">
    <meta property="og:url" content="https://www.importanceleadership.com">
    <meta name="twitter:card" content="summary_large_image">
';

// Use test config for web testing
define('ALLOW_ACCESS', true);
include 'includes/config-test.php';
include 'includes/functions.php';
include 'components/header.php';
include 'components/nav.php';
?>

<main class="main-content" id="main-content">
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="container">
                <h1>Empowering Tomorrow's Leaders Today</h1>
                <p>Join the Importance Leadership Organization in transforming communities through leadership development, mentorship, and impactful initiatives across Africa.</p>
                <div class="hero-actions">
                    <a href="/programs" class="btn btn-primary">Explore Programs</a>
                    <a href="/join-us" class="btn btn-secondary">Join Our Mission</a>
                </div>
            </div>
        </div>
        <div class="hero-image">
            <div style="background: linear-gradient(135deg, #3498db, #9b59b6); height: 300px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px;">Hero Image Placeholder</div>
        </div>
    </section>

    <!-- Impact Stats -->
    <section class="impact-stats">
        <div class="container">
            <h2>Our Impact</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Young Leaders Empowered</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">25+</div>
                    <div class="stat-label">Communities Reached</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Programs Delivered</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Countries Active</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Programs -->
    <section class="featured-programs">
        <div class="container">
            <h2>Our Programs</h2>
            <p class="section-intro">Comprehensive leadership development through diverse, impactful programs</p>
            
            <div class="programs-grid">
                <div class="program-card">
                    <div class="program-image">
                        <div style="background: linear-gradient(135deg, #e74c3c, #c0392b); height: 200px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">Leadership Development</div>
                    </div>
                    <div class="program-content">
                        <h3>Leadership Development</h3>
                        <p>Comprehensive training in leadership skills, emotional intelligence, and strategic thinking for emerging leaders.</p>
                        <a href="/programs/leadership-development" class="btn btn-outline">Learn More</a>
                    </div>
                </div>

                <div class="program-card">
                    <div class="program-image">
                        <div style="background: linear-gradient(135deg, #27ae60, #2ecc71); height: 200px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">Mentorship Program</div>
                    </div>
                    <div class="program-content">
                        <h3>Mentorship Program</h3>
                        <p>Connect with experienced leaders and mentors who guide your personal and professional development journey.</p>
                        <a href="/programs/mentorship" class="btn btn-outline">Learn More</a>
                    </div>
                </div>

                <div class="program-card">
                    <div class="program-image">
                        <div style="background: linear-gradient(135deg, #f39c12, #e67e22); height: 200px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">Community Impact</div>
                    </div>
                    <div class="program-content">
                        <h3>Community Impact</h3>
                        <p>Hands-on projects that create positive change in communities while developing practical leadership skills.</p>
                        <a href="/programs/community-impact" class="btn btn-outline">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Make a Difference?</h2>
            <p>Join thousands of young leaders who are transforming their communities and building a better future.</p>
            <div class="cta-actions">
                <a href="/join-us" class="btn btn-primary btn-large">Get Started</a>
                <a href="/donate" class="btn btn-secondary btn-large">Support Our Mission</a>
            </div>
        </div>
    </section>
</main>

<?php include 'components/footer.php'; ?>