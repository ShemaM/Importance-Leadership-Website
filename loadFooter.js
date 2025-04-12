
document.addEventListener("DOMContentLoaded", function() {
    // Footer HTML template
    const footerHTML = `
   <footer class="footer text-white pt-5 pb-4" style = "background: linear-gradient(135deg, #2d8893, #0c1b7b);">
    <div class="container">
        <div class="row align-items-start">
            <!-- Logo & Quick Links -->
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="index.html">
                    <img src="image/website-logo.png" alt="Importance Leadership" class="footer-logo mb-3" style="width: 120px;">
                </a>
                <ul class="list-unstyled mt-3">
                    <li><a href="who-we-are.html" class="text-white-50 d-block py-1">Who We Are</a></li>
                    <li><a href="what-we-do.html" class="text-white-50 d-block py-1">What We Do</a></li>
                    <li><a href="impact.html" class="text-white-50 d-block py-1">Impact</a></li>
                    <li><a href="donate.html" class="text-white-50 d-block py-1">Donate</a></li>
                    <li><a href="contact-us.html" class="text-white-50 d-block py-1">Contact Us</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="fw-bold mb-3">Get in Touch</h5>
                <p class="text-white-50">We'd love to hear from you.</p>
                <p class="text-white-50 mb-2"><i class="fas fa-phone-alt me-2"></i><a href="tel:+16037150801" class="text-white">+1 (603) 715-0801</a></p>
                <p class="text-white-50"><i class="fas fa-envelope me-2"></i><a href="mailto:info@importanceleadership.com" class="text-white">info@importanceleadership.com</a></p>

                <div class="social-media mt-4">
                    <a href="https://www.instagram.com/importance_leadership_" class="btn btn-outline-light btn-sm rounded-circle me-2" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/share/12J1CX4vLQ8/?mibextid=wwXIfr" class="btn btn-outline-light btn-sm rounded-circle me-2" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.linkedin.com/company/importance-leadership/posts" class="btn btn-outline-light btn-sm rounded-circle me-2" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.youtube.com/@importanceleadership" class="btn btn-outline-light btn-sm rounded-circle" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-4 col-md-12">
                <h5 class="fw-bold mb-3">Subscribe to Our Newsletter</h5>
                <p class="text-white-50">Stay updated with our latest news and updates.</p>
                <form id="newsletter-form" action="subscribe.php" method="post" class="needs-validation" novalidate>
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        <button class="btn btn-success" type="submit"><i class="fas fa-paper-plane"></i></button>
                        <div class="invalid-feedback text-white">Please enter a valid email.</div>
                    </div>
                    <div id="response-message" class="mt-2 text-white-50"></div>
                </form>
            </div>
        </div>

        
    </div>
</footer>

<script>
    document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>

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