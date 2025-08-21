<?php
// components/footer.php - Clean Tailwind footer component
?>
<!-- Footer -->
<footer class="bg-primary-700 text-white relative">
    <!-- Gradient overlay -->
    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-transparent to-primary-700 -translate-y-full"></div>
    
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Organization Info -->
            <div class="lg:col-span-1">
                <a href="/" class="block mb-6">
                    <img src="/assets/images/icons/website-logo.png" 
                         alt="Importance Leadership Logo" 
                         class="w-48 transition-transform duration-300 hover:scale-105">
                </a>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Developing ethical, visionary leaders who drive positive change in Africa and beyond through mentorship, education, and community engagement.
                </p>
                
                <!-- Social Links -->
                <div class="flex space-x-4 mb-6">
                    <a href="https://www.facebook.com/share/15LKEyn6fy/?mibextid=wwXIfr" 
                       class="w-10 h-10 bg-primary-600 hover:bg-accent-500 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110"
                       aria-label="Facebook">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="https://www.instagram.com/importance_leadership_?igsh=bGZ1bHB1dm1vdHY2&utm_source=qr" 
                       class="w-10 h-10 bg-primary-600 hover:bg-accent-500 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110"
                       aria-label="Instagram">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/105744530/admin/dashboard/" 
                       class="w-10 h-10 bg-primary-600 hover:bg-accent-500 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110"
                       aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in text-sm"></i>
                    </a>
                    <a href="https://youtube.com/@importanceleadership?si=mzd00nPXob5XBBBl" 
                       class="w-10 h-10 bg-primary-600 hover:bg-accent-500 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110"
                       aria-label="YouTube">
                        <i class="fab fa-youtube text-sm"></i>
                    </a>
                </div>
            </div>
            
            <!-- Navigation Links -->
            <div>
                <h5 class="text-white font-bold text-lg mb-6 relative pb-3">
                    Navigation
                    <span class="absolute bottom-0 left-0 w-12 h-1 bg-accent-500"></span>
                </h5>
                <ul class="space-y-3">
                    <li>
                        <a href="/" class="text-gray-300 hover:text-white hover:pl-2 transition-all duration-300">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="/about" class="text-gray-300 hover:text-white hover:pl-2 transition-all duration-300">
                            Who We Are
                        </a>
                    </li>
                    <li>
                        <a href="/impact" class="text-gray-300 hover:text-white hover:pl-2 transition-all duration-300">
                            Impact
                        </a>
                    </li>
                    <li>
                        <a href="/contact" class="text-gray-300 hover:text-white hover:pl-2 transition-all duration-300">
                            Contact
                        </a>
                    </li>
                    <li>
                        <a href="/programs" class="text-gray-300 hover:text-white hover:pl-2 transition-all duration-300">
                            What We Do
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Programs Links -->
            <div>
                <h5 class="text-white font-bold text-lg mb-6 relative pb-3">
                    Programs
                    <span class="absolute bottom-0 left-0 w-12 h-1 bg-accent-500"></span>
                </h5>
                <ul class="space-y-3">
                    <li>
                        <a href="/programs/advocacy" class="text-gray-300 hover:text-white hover:pl-2 transition-all duration-300">
                            Advocacy Initiatives
                        </a>
                    </li>
                    <li>
                        <a href="/programs/mental-health" class="text-gray-300 hover:text-white hover:pl-2 transition-all duration-300">
                            Mental Health Programs
                        </a>
                    </li>
                    <li>
                        <a href="/programs/networking" class="text-gray-300 hover:text-white hover:pl-2 transition-all duration-300">
                            Professional Networking
                        </a>
                    </li>
                    <li>
                        <a href="/programs/leadership-development" class="text-gray-300 hover:text-white hover:pl-2 transition-all duration-300">
                            Leadership Development
                        </a>
                    </li>
                    <li>
                        <a href="/programs/climate-change" class="text-gray-300 hover:text-white hover:pl-2 transition-all duration-300">
                            Climate Change Awareness
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Contact Information -->
            <div>
                <h5 class="text-white font-bold text-lg mb-6 relative pb-3">
                    Contact Us
                    <span class="absolute bottom-0 left-0 w-12 h-1 bg-accent-500"></span>
                </h5>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt text-accent-500 mr-3 mt-1 flex-shrink-0"></i>
                        <span class="text-gray-300">03301 Concord, New Hampshire, USA</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone text-accent-500 mr-3 flex-shrink-0"></i>
                        <a href="tel:+16037150801" class="text-gray-300 hover:text-white transition-colors duration-300">
                            +1(603) 715-0801
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope text-accent-500 mr-3 flex-shrink-0"></i>
                        <a href="mailto:importanceleadership2020@gmail.com" class="text-gray-300 hover:text-white transition-colors duration-300">
                            importanceleadership2020@gmail.com
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Newsletter Signup -->
        <div class="border-t border-primary-600 mt-12 pt-8">
            <div class="text-center">
                <h6 class="text-white font-bold text-lg mb-4">Stay Connected</h6>
                <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                    Subscribe to our newsletter for updates on programs, events, and impact stories from the Importance Leadership community.
                </p>
                <form action="/forms/newsletter.php" method="POST" class="flex flex-col sm:flex-row justify-center items-center gap-4 max-w-md mx-auto">
                    <input type="email" name="email" placeholder="Enter your email" required
                           class="flex-1 px-4 py-3 bg-white/10 text-white placeholder-gray-300 rounded-lg border border-primary-600 focus:border-accent-500 focus:outline-none focus:ring-2 focus:ring-accent-500/20 transition-all duration-300">
                    <button type="submit" 
                            class="bg-accent-500 hover:bg-accent-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-primary-600 mt-8 pt-8 text-center">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">
                    &copy; <?= date('Y') ?> Importance Leadership Organization. All rights reserved.
                </p>
                <div class="flex space-x-6">
                    <a href="/privacy-policy" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">
                        Privacy Policy
                    </a>
                    <a href="/terms-of-service" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">
                        Terms of Service
                    </a>
                    <a href="/cookie-policy" class="text-gray-400 hover:text-white transition-colors duration-300 text-sm">
                        Cookie Policy
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="back-to-top" 
        class="fixed bottom-8 right-8 w-12 h-12 bg-accent-500 hover:bg-accent-600 text-white rounded-full shadow-lg opacity-0 invisible transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-accent-500/20 z-50"
        aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
// Back to top button functionality
document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.getElementById('back-to-top');
    
    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.remove('opacity-0', 'invisible');
            backToTopButton.classList.add('opacity-100', 'visible');
        } else {
            backToTopButton.classList.add('opacity-0', 'invisible');
            backToTopButton.classList.remove('opacity-100', 'visible');
        }
    });
    
    // Smooth scroll to top
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script>

<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>

</body>
</html>