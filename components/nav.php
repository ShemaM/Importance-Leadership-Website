<?php
// components/nav.php

// Get current page for active navigation highlighting
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$request_uri = $_SERVER['REQUEST_URI'];

// Function to check if current page is active
function isActivePage($page_path) {
    global $request_uri;
    return strpos($request_uri, $page_path) === 0 ? 'active' : '';
}
?>

<header class="site-header" role="banner">
    <div class="container">
        <nav class="navbar" role="navigation" aria-label="Main Navigation">
            <!-- Logo -->
            <div class="navbar-brand">
                <a href="/" class="logo-link" aria-label="Importance Leadership - Home">
                    <img src="<?= getAssetUrl('images/logo.png') ?>" alt="Importance Leadership Organization" class="logo-img" width="200" height="60">
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" type="button" aria-expanded="false" aria-controls="navbar-menu" aria-label="Toggle navigation menu">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="navbar-menu" id="navbar-menu">
                <ul class="navbar-nav" role="menubar">
                    
                    <!-- Home -->
                    <li class="nav-item" role="none">
                        <a href="/" class="nav-link <?= isActivePage('/') === 'active' && $request_uri === '/' ? 'active' : '' ?>" role="menuitem">
                            Home
                        </a>
                    </li>

                    <!-- About -->
                    <li class="nav-item dropdown" role="none">
                        <a href="/about" class="nav-link dropdown-toggle <?= isActivePage('/about') ?>" 
                           role="menuitem" aria-haspopup="true" aria-expanded="false">
                            About
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-label="About submenu">
                            <li role="none">
                                <a href="/about" class="dropdown-link" role="menuitem">Our Story</a>
                            </li>
                            <li role="none">
                                <a href="/team" class="dropdown-link" role="menuitem">Our Team</a>
                            </li>
                            <li role="none">
                                <a href="/mission" class="dropdown-link" role="menuitem">Mission & Vision</a>
                            </li>
                            <li role="none">
                                <a href="/impact" class="dropdown-link" role="menuitem">Our Impact</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Programs -->
                    <li class="nav-item dropdown" role="none">
                        <a href="/programs" class="nav-link dropdown-toggle <?= isActivePage('/programs') ?>" 
                           role="menuitem" aria-haspopup="true" aria-expanded="false">
                            Programs
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-label="Programs submenu">
                            <li role="none">
                                <a href="/programs/leadership-development" class="dropdown-link" role="menuitem">Leadership Development</a>
                            </li>
                            <li role="none">
                                <a href="/programs/mentorship" class="dropdown-link" role="menuitem">Mentorship Program</a>
                            </li>
                            <li role="none">
                                <a href="/programs/community-impact" class="dropdown-link" role="menuitem">Community Impact</a>
                            </li>
                            <li role="none">
                                <a href="/programs/workshops" class="dropdown-link" role="menuitem">Workshops & Training</a>
                            </li>
                            <li role="none">
                                <a href="/programs/networking" class="dropdown-link" role="menuitem">Networking Events</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Events -->
                    <li class="nav-item" role="none">
                        <a href="/events" class="nav-link <?= isActivePage('/events') ?>" role="menuitem">
                            Events
                        </a>
                    </li>

                    <!-- Resources -->
                    <li class="nav-item dropdown" role="none">
                        <a href="/resources" class="nav-link dropdown-toggle <?= isActivePage('/resources') ?>" 
                           role="menuitem" aria-haspopup="true" aria-expanded="false">
                            Resources
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-label="Resources submenu">
                            <li role="none">
                                <a href="/blog" class="dropdown-link" role="menuitem">Blog</a>
                            </li>
                            <li role="none">
                                <a href="/resources/downloads" class="dropdown-link" role="menuitem">Downloads</a>
                            </li>
                            <li role="none">
                                <a href="/resources/articles" class="dropdown-link" role="menuitem">Articles</a>
                            </li>
                            <li role="none">
                                <a href="/resources/videos" class="dropdown-link" role="menuitem">Videos</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Get Involved -->
                    <li class="nav-item dropdown" role="none">
                        <a href="/get-involved" class="nav-link dropdown-toggle <?= isActivePage('/get-involved') ?>" 
                           role="menuitem" aria-haspopup="true" aria-expanded="false">
                            Get Involved
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-label="Get Involved submenu">
                            <li role="none">
                                <a href="/join-us" class="dropdown-link" role="menuitem">Join Our Programs</a>
                            </li>
                            <li role="none">
                                <a href="/volunteer" class="dropdown-link" role="menuitem">Volunteer</a>
                            </li>
                            <li role="none">
                                <a href="/partnerships" class="dropdown-link" role="menuitem">Partnerships</a>
                            </li>
                            <li role="none">
                                <a href="/mentor" class="dropdown-link" role="menuitem">Become a Mentor</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Contact -->
                    <li class="nav-item" role="none">
                        <a href="/contact" class="nav-link <?= isActivePage('/contact') ?>" role="menuitem">
                            Contact
                        </a>
                    </li>

                </ul>

                <!-- Action Buttons -->
                <div class="navbar-actions">
                    <a href="/donate" class="btn btn-primary btn-donate" role="button">
                        <svg class="btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                        Donate
                    </a>

                    <?php if (isLoggedIn()): ?>
                        <!-- User is logged in -->
                        <div class="user-menu dropdown">
                            <button type="button" class="user-menu-toggle dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                                <img src="<?= getAssetUrl('images/default-avatar.png') ?>" alt="User Avatar" class="user-avatar" width="32" height="32">
                                <span class="user-name"><?= htmlspecialchars(getCurrentUser()['name'] ?? 'User') ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" role="menu">
                                <li role="none">
                                    <a href="/dashboard" class="dropdown-link" role="menuitem">Dashboard</a>
                                </li>
                                <li role="none">
                                    <a href="/profile" class="dropdown-link" role="menuitem">Profile</a>
                                </li>
                                <li role="none">
                                    <hr class="dropdown-divider">
                                </li>
                                <li role="none">
                                    <a href="/logout" class="dropdown-link" role="menuitem">Logout</a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- User is not logged in -->
                        <a href="/login" class="btn btn-outline btn-login" role="button">
                            Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" aria-hidden="true"></div>

<script>
// Mobile menu functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.navbar-menu');
    const mobileOverlay = document.querySelector('.mobile-menu-overlay');
    const body = document.body;

    function toggleMobileMenu() {
        const isOpen = mobileToggle.getAttribute('aria-expanded') === 'true';
        
        mobileToggle.setAttribute('aria-expanded', !isOpen);
        mobileMenu.classList.toggle('active');
        mobileOverlay.classList.toggle('active');
        body.classList.toggle('mobile-menu-open');
    }

    function closeMobileMenu() {
        mobileToggle.setAttribute('aria-expanded', 'false');
        mobileMenu.classList.remove('active');
        mobileOverlay.classList.remove('active');
        body.classList.remove('mobile-menu-open');
    }

    // Toggle mobile menu
    mobileToggle.addEventListener('click', toggleMobileMenu);
    
    // Close mobile menu when overlay is clicked
    mobileOverlay.addEventListener('click', closeMobileMenu);
    
    // Close mobile menu when escape key is pressed
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
            closeMobileMenu();
        }
    });

    // Handle dropdown menus
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth > 768) {
                // Desktop behavior - prevent default and toggle dropdown
                e.preventDefault();
                const isOpen = this.getAttribute('aria-expanded') === 'true';
                
                // Close all other dropdowns
                dropdownToggles.forEach(otherToggle => {
                    if (otherToggle !== this) {
                        otherToggle.setAttribute('aria-expanded', 'false');
                        otherToggle.parentElement.classList.remove('active');
                    }
                });
                
                // Toggle current dropdown
                this.setAttribute('aria-expanded', !isOpen);
                this.parentElement.classList.toggle('active');
            }
            // On mobile, let the default link behavior work
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            dropdownToggles.forEach(toggle => {
                toggle.setAttribute('aria-expanded', 'false');
                toggle.parentElement.classList.remove('active');
            });
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeMobileMenu();
        }
    });
});
</script>