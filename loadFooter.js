
document.addEventListener("DOMContentLoaded", function() {
    // Footer HTML template
    
    
const footerHTML = `
<footer class="footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <img src="image/website-logo.png" alt="Importance Leadership Logo" class="footer-logo" loading="lazy">
        <p class="mb-4">Developing ethical, visionary leaders who drive positive change in Africa and beyond through mentorship, education, and community engagement.</p>
        <div class="social-links mb-4">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-md-4">
        <div class="footer-links">
          <h5>Navigation</h5>
          <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="programs.html">Programs</a></li>
            <li><a href="impact.html">Impact</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="contact-us.html">Contact</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-3 col-md-4">
        <div class="footer-links">
          <h5>Programs</h5>
          <ul>
            <li><a href="#">Emerging Leaders</a></li>
            <li><a href="#">Executive Mentorship</a></li>
            <li><a href="#">Community Changemakers</a></li>
            <li><a href="#">Women in Leadership</a></li>
            <li><a href="#">Corporate Training</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-3 col-md-4">
        <div class="footer-links">
          <h5>Contact Us</h5>
          <ul>
            <li><i class="fas fa-map-marker-alt me-2 text-secondary"></i> Kenya, USA, Canada</li>
            <li><i class="fas fa-phone me-2 text-secondary"></i> +254 792 732 177</li>
            <li><i class="fas fa-envelope me-2 text-secondary"></i> info@importanceleadership.com</li>
          </ul>

          <h5 class="mt-4">Newsletter</h5>
          <p class="small">Subscribe for updates and insights</p>
          <form>
            <div class="input-group mb-3">
              <input type="email" class="form-control form-control-sm" placeholder="Your Email" required>
              <button class="btn btn-accent btn-sm" type="submit">Join</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <hr class="my-4 bg-secondary opacity-25">

    <div class="row">
      <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
        <p class="mb-0 small">&copy; 2025 Importance Leadership. All rights reserved.</p>
      </div>
      <div class="col-md-6 text-center text-md-end">
        <a href="#" class="text-white text-decoration-none small me-3">Privacy Policy</a>
        <a href="#" class="text-white text-decoration-none small me-3">Terms of Service</a>
        <a href="#" class="text-white text-decoration-none small">Cookie Policy</a>
      </div>
    </div>
  </div>
</footer>
 
    `;

    // Add the back-to-top button to the footer HTML
    const backToTopHTML = `
<div class="back-to-top" id="backToTop">
  <i class="fas fa-arrow-up"></i>
</div>
    `;

    // Insert the footer and back-to-top button into the page
    document.body.insertAdjacentHTML('beforeend', footerHTML + backToTopHTML);
});

