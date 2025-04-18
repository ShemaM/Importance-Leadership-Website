
document.addEventListener("DOMContentLoaded", function() {
    // Footer HTML template
    
const footerHTML = `
<footer class="bg-dark text-white pt-6 pb-4 position-relative">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <img src="image/website-logo.png" alt="Importance Leadership Logo" class="mb-3" width="180">
                    <p class="mb-4">Empowering communities through leadership, innovation, and impact.</p>
                    <div class="d-flex gap-3 mb-4">
                        <a href="#" class="text-white fs-5"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white fs-5"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white fs-5"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="fw-bold mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.html" class="text-white text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="who-we-are.html" class="text-white text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="what-we-do.html" class="text-white text-decoration-none">Programs</a></li>
                        <li class="mb-2"><a href="impact.html" class="text-white text-decoration-none">Impact</a></li>
                        <li class="mb-2"><a href="donate.html" class="text-white text-decoration-none">Donate</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="fw-bold mb-4">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> 123 Leadership Ave, City, Country</li>
                        <li class="mb-2"><i class="fas fa-phone me-2 text-primary"></i> +1 (234) 567-8900</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> info@importanceleadership.org</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="fw-bold mb-4">Newsletter</h5>
                    <p>Subscribe to our newsletter for updates and news.</p>
                    <form class="mb-3" method="POST" action="subscribe.php">
                        <div class="input-group">
                            <input 
                type="email" 
                class="form-control" 
                name="email" 
                placeholder="Your Email" 
                aria-label="Your Email"
                required
            >
                <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                                  <!-- CSRF protection (recommended) -->
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
               
                    </form>
                    <div class="subscription-message mt-2" style="display: none;"></div>
             </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-center">
                    <p class="mb-0">&copy; 2025 Importance Leadership. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-white text-decoration-none">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    `;
    // Inject footer if not already present
    if (!document.querySelector("footer")) {
        document.body.insertAdjacentHTML("beforeend", footerHTML);
        setCurrentYear();
        setupNewsletterForm();
        addSocialMediaHover();
    }

    // Helper function to generate social media icons
    function generateSocialIcons() {
        const socials = [
            { 
                url: "https://www.instagram.com/importance_leadership_", 
                aria: "Instagram",
                fill: "#E4405F",
                path: "M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm7.69 1.5h-7.88A4.25 4.25 0 0 0 3.5 7.75v7.88a4.25 4.25 0 0 0 4.25 4.25h7.88a4.25 4.25 0 0 0 4.25-4.25v-7.88a4.25 4.25 0 0 0-4.25-4.25Zm-4.44 4.5a4.44 4.44 0 1 1 0 8.88 4.44 4.44 0 0 1 0-8.88Zm0 1.5a2.94 2.94 0 1 0 0 5.88 2.94 2.94 0 0 0 0-5.88ZM17.25 5a1 1 0 1 1 0 2 1 1 0 0 1 0-2Z"
            },
            {
                url: "https://www.facebook.com/share/12J1CX4vLQ8/?mibextid=wwXIfr",
                aria: "Facebook",
                fill: "#1877F2",
                path: "M22 12a10 10 0 1 0-11.56 9.87v-6.99h-2.34v-2.88h2.34V9.42c0-2.32 1.38-3.6 3.49-3.6 1 0 2.07.18 2.07.18v2.28h-1.17c-1.15 0-1.5.71-1.5 1.44v1.73h2.55l-.41 2.88h-2.14v6.99A10 10 0 0 0 22 12Z"
            },
            {
                url: "https://www.linkedin.com/company/importance-leadership/posts",
                aria: "LinkedIn",
                fill: "#0A66C2",
                path: "M4.98 3.5a2.48 2.48 0 1 1 0 4.96 2.48 2.48 0 0 1 0-4.96ZM2 8.88h5.93V21H2V8.88Zm7.08 0h5.67v1.64c.82-1.22 2.29-2.07 3.92-2.07 2.8 0 4.33 1.83 4.33 5.63V21h-5.93v-6.23c0-1.49-.53-2.53-1.87-2.53-1.02 0-1.62.69-1.89 1.36-.1.25-.13.6-.13.94V21h-5.93V8.88Z"
            },
            {
                url: "https://www.youtube.com/@importanceleadership",
                aria: "YouTube",
                fill: "#FF0000",
                path: "M22 7.57c0-1.37-1.1-2.49-2.45-2.49C16.69 5 12 5 12 5s-4.69 0-7.55.08C3.1 5.08 2 6.2 2 7.57v8.86c0 1.37 1.1 2.49 2.45 2.49C7.31 19 12 19 12 19s4.69 0 7.55-.08c1.35 0 2.45-1.12 2.45-2.49V7.57Zm-12.18 7.29V8.92l5.87 2.97-5.87 2.97Z"
            }
        ];

        return socials.map(social => `
            <a href="${social.url}" target="_blank" rel="noopener noreferrer" aria-label="${social.aria}">
                <svg viewBox="0 0 24 24" fill="${social.fill}" width="24" height="24">
                    <path d="${social.path}"/>
                </svg>
            </a>
        `).join('');
    }

    // Set current year in copyright
    function setCurrentYear() {
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    }

    // Setup newsletter form validation and submission
    function setupNewsletterForm() {
        const form = document.getElementById('newsletter-form');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            submitNewsletter(form);
        });
    }

    // Handle newsletter submission
    function submitNewsletter(form) {
        const responseEl = document.getElementById('response-message');
        responseEl.textContent = 'Submitting...';
        responseEl.style.color = 'inherit';

        const formData = new FormData(form);

        fetch('https://importanceleadership-database.com/subscribe', {
            method: 'POST',
            body: JSON.stringify({
            email: formData.get('email'),
            database: 'importanceleadership',
            username: 'root',
            password: 'secret'
            }),
            headers: {
            'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
            throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            responseEl.textContent = 'Thank you for subscribing!';
            responseEl.style.color = 'green';
            form.reset();
            form.classList.remove('was-validated');
        })
        .catch(error => {
            responseEl.textContent = 'An error occurred. Please try again.';
            responseEl.style.color = 'red';
            console.error('There was a problem with the fetch operation:', error);
        });
    }

    // Add hover effects to social media icons
    function addSocialMediaHover() {
        document.querySelectorAll('.social-media a').forEach(link => {
            link.addEventListener('mouseenter', () => {
                link.style.opacity = '0.8';
                link.querySelector('svg').style.transform = 'scale(1.1)';
            });
            link.addEventListener('mouseleave', () => {
                link.style.opacity = '1';
                link.querySelector('svg').style.transform = 'scale(1)';
            });
        });
    }
});