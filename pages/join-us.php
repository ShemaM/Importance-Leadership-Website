<?php
// pages/join-us.php - Join Us Page with component architecture
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/security.php';

// Page configuration
$page_title = "Join Us | Become a Leader & Transform Communities | Importance Leadership";
$meta_description = "Join Importance Leadership community of change-makers. Access leadership training, mentorship programs, and exclusive opportunities to make a lasting impact on communities across Africa.";
$meta_keywords = "join us, leadership community, mentorship, leadership training, youth empowerment, volunteer opportunities, community impact";
$canonical_url = "https://www.importanceleadership.com/join-us";
$body_class = "join-us-page";

// Additional head content for join-us page
$additional_head = '
<link rel="canonical" href="' . $canonical_url . '">
<meta property="og:title" content="' . $page_title . '">
<meta property="og:description" content="' . $meta_description . '">
<meta property="og:type" content="website">
<meta property="og:url" content="' . $canonical_url . '">
<meta property="og:image" content="' . $canonical_url . '/assets/images/join-us-hero.jpg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . $page_title . '">
<meta name="twitter:description" content="' . $meta_description . '">
<meta name="twitter:image" content="' . $canonical_url . '/assets/images/join-us-hero.jpg">
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}
@keyframes slideInLeft {
    0% { opacity: 0; transform: translateX(-30px); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes slideInRight {
    0% { opacity: 0; transform: translateX(30px); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
.animate-float {
    animation: float 3s ease-in-out infinite;
}
.animate-fadeIn {
    animation: fadeIn 1s ease-in forwards;
}
.animate-fadeInUp {
    animation: fadeInUp 1s ease-out forwards;
}
.animate-slideInLeft {
    animation: slideInLeft 0.8s ease-out forwards;
}
.animate-slideInRight {
    animation: slideInRight 0.8s ease-out forwards;
}
.animate-pulse-custom {
    animation: pulse 2s ease-in-out infinite;
}
.animate-shake {
    animation: shake 0.5s ease-in-out;
}
.gradient-overlay {
    background: linear-gradient(135deg, rgba(11, 31, 58, 0.95) 0%, rgba(11, 31, 58, 0.85) 100%);
}
.form-container {
    backdrop-filter: blur(10px);
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.form-container:hover {
    transform: translateY(-5px);
}
.form-input {
    transition: all 0.3s ease;
}
.form-input:focus {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(11, 31, 58, 0.15);
}
.password-strength-weak { width: 33%; background-color: #ef4444; }
.password-strength-medium { width: 66%; background-color: #f59e0b; }
.password-strength-strong { width: 100%; background-color: #10b981; }
.modal {
    backdrop-filter: blur(5px);
    transition: all 0.3s ease;
}
.modal-content {
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.form-decoration {
    background: radial-gradient(circle, rgba(124, 173, 233, 0.1) 0%, transparent 70%);
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
    <section class="relative min-h-screen flex items-center justify-center text-white overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" 
                 alt="Leadership community meeting" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 gradient-overlay"></div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="animate-slideInLeft">
                    <span class="inline-block bg-accent-500 text-primary-500 px-4 py-2 rounded-full text-sm font-bold mb-6">
                        JOIN THE MOVEMENT
                    </span>
                    <h1 class="text-4xl md:text-6xl font-bold font-secondary leading-tight mb-6">
                        Join Our Community of Leaders
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 opacity-95">
                        Become part of a movement that's shaping the future of leadership in Africa. Sign up to access exclusive resources, mentorship, and growth opportunities.
                    </p>
                    
                    <!-- Benefits List -->
                    <div class="grid md:grid-cols-2 gap-4 mb-8">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-accent-500 mr-3 text-lg"></i>
                            <span>Access to leadership training programs</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-accent-500 mr-3 text-lg"></i>
                            <span>Connect with mentors and peers</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-accent-500 mr-3 text-lg"></i>
                            <span>Exclusive event invitations</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-accent-500 mr-3 text-lg"></i>
                            <span>Personalized growth roadmap</span>
                        </div>
                    </div>
                </div>
                
                <!-- Signup Form -->
                <div class="animate-slideInRight">
                    <div class="form-container bg-white bg-opacity-95 rounded-2xl p-8 md:p-10 shadow-2xl relative overflow-hidden">
                        <!-- Form Decorations -->
                        <div class="form-decoration absolute top-0 right-0 w-32 h-32 -mr-16 -mt-16"></div>
                        <div class="form-decoration absolute bottom-0 left-0 w-24 h-24 -ml-12 -mb-12"></div>
                        
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold font-secondary text-primary-500 mb-2">Create Your Account</h2>
                            <p class="text-gray-600">Start your leadership journey today</p>
                        </div>
                        
                        <form id="signupForm" action="/forms/join-us-handler.php" method="POST" class="space-y-6" novalidate>
                            <!-- First Name -->
                            <div class="relative">
                                <label for="firstName" class="block text-gray-700 font-semibold mb-2">First Name</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" id="firstName" name="firstname" 
                                           class="form-input w-full pl-12 pr-4 py-4 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500" 
                                           placeholder="John" required>
                                </div>
                                <span id="firstNameError" class="text-red-500 text-sm mt-1 hidden"></span>
                            </div>
                            
                            <!-- Last Name -->
                            <div class="relative">
                                <label for="lastName" class="block text-gray-700 font-semibold mb-2">Last Name</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" id="lastName" name="lastname" 
                                           class="form-input w-full pl-12 pr-4 py-4 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500" 
                                           placeholder="Doe" required>
                                </div>
                                <span id="lastNameError" class="text-red-500 text-sm mt-1 hidden"></span>
                            </div>
                            
                            <!-- Email -->
                            <div class="relative">
                                <label for="email" class="block text-gray-700 font-semibold mb-2">Email Address</label>
                                <div class="relative">
                                    <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="email" id="email" name="email" 
                                           class="form-input w-full pl-12 pr-4 py-4 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500" 
                                           placeholder="your@email.com" required>
                                </div>
                                <span id="emailError" class="text-red-500 text-sm mt-1 hidden"></span>
                            </div>
                            
                            <!-- Password -->
                            <div class="relative">
                                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="password" id="password" name="password" 
                                           class="form-input w-full pl-12 pr-12 py-4 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500" 
                                           placeholder="At least 8 characters" required minlength="8">
                                    <button type="button" id="togglePassword" 
                                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <!-- Password Strength Meter -->
                                <div class="mt-2">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div id="passwordStrength" class="h-2 rounded-full transition-all duration-300"></div>
                                    </div>
                                    <span id="passwordStrengthText" class="text-sm mt-1 block"></span>
                                </div>
                                <span id="passwordError" class="text-red-500 text-sm mt-1 hidden"></span>
                            </div>
                            
                            <!-- Confirm Password -->
                            <div class="relative">
                                <label for="confirmPassword" class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="password" id="confirmPassword" name="confirmPassword" 
                                           class="form-input w-full pl-12 pr-12 py-4 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500" 
                                           placeholder="Repeat your password" required>
                                    <button type="button" id="toggleConfirmPassword" 
                                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <span id="confirmPasswordError" class="text-red-500 text-sm mt-1 hidden"></span>
                            </div>
                            
                            <!-- Interests -->
                            <div class="relative">
                                <label for="interests" class="block text-gray-700 font-semibold mb-2">Areas of Interest</label>
                                <div class="relative">
                                    <i class="fas fa-lightbulb absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <select id="interests" name="interests" 
                                            class="form-input w-full pl-12 pr-4 py-4 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500">
                                        <option value="">Select your primary interest</option>
                                        <option value="leadership-development">Leadership Development</option>
                                        <option value="mentorship">Mentorship Programs</option>
                                        <option value="community-impact">Community Impact</option>
                                        <option value="youth-empowerment">Youth Empowerment</option>
                                        <option value="networking">Professional Networking</option>
                                        <option value="climate-action">Climate Action</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" id="submitBtn" 
                                    class="w-full bg-gradient-to-r from-accent-500 to-yellow-500 hover:from-yellow-500 hover:to-accent-500 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all transform hover:-translate-y-1 shadow-xl">
                                <span id="submitText">Create Account</span>
                                <i id="submitSpinner" class="fas fa-spinner fa-spin ml-2 hidden"></i>
                            </button>
                            
                            <!-- Login Link -->
                            <p class="text-center text-gray-600 mt-6">
                                Already have an account? 
                                <a href="/login" class="text-primary-500 hover:text-primary-600 font-semibold">Sign in here</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-primary-500 to-blue-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold font-secondary mb-6">Ready to Lead the Change?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto opacity-95">
                Join thousands of young leaders who are already making a difference in their communities.
            </p>
            <a href="#main-content" 
               class="inline-flex items-center bg-accent-500 hover:bg-yellow-500 text-white font-bold py-4 px-8 rounded-full text-lg transition-all transform hover:-translate-y-2 shadow-xl animate-pulse-custom">
                <i class="fas fa-arrow-up mr-3"></i>
                Join Now
            </a>
        </div>
    </section>
</main>

<!-- Success Modal -->
<div id="successModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 invisible transition-all">
    <div class="modal-content bg-white rounded-2xl p-8 max-w-md mx-4 text-center transform scale-95">
        <div class="bg-green-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check-circle text-white text-2xl"></i>
        </div>
        <h3 class="text-2xl font-bold font-secondary text-primary-500 mb-4">Welcome to Importance Leadership!</h3>
        <p class="text-gray-600 mb-6">
            We've sent a confirmation email to <span id="confirmedEmail" class="font-semibold text-primary-500"></span>.
            Please check your inbox to verify your account.
        </p>
        <button id="successModalBtn" class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-6 rounded-lg transition-all">
            Continue
        </button>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 invisible transition-all">
    <div class="modal-content bg-white rounded-2xl p-8 max-w-md mx-4 text-center transform scale-95">
        <div class="bg-red-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-exclamation-circle text-white text-2xl"></i>
        </div>
        <h3 class="text-2xl font-bold font-secondary text-primary-500 mb-4">Registration Failed</h3>
        <p id="errorModalMessage" class="text-gray-600 mb-6">
            We encountered an issue while processing your registration. Please try again.
        </p>
        <button id="errorModalBtn" class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-6 rounded-lg transition-all">
            Try Again
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Form elements
    const form = document.getElementById('signupForm');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const passwordStrengthBar = document.getElementById('passwordStrength');
    const passwordStrengthText = document.getElementById('passwordStrengthText');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');

    // Modal elements
    const successModal = document.getElementById('successModal');
    const errorModal = document.getElementById('errorModal');
    const successModalBtn = document.getElementById('successModalBtn');
    const errorModalBtn = document.getElementById('errorModalBtn');
    const confirmedEmail = document.getElementById('confirmedEmail');
    const errorModalMessage = document.getElementById('errorModalMessage');

    // Password visibility toggle
    function setupPasswordToggle(toggleBtn, inputField) {
        toggleBtn.addEventListener('click', () => {
            const isPassword = inputField.type === 'password';
            inputField.type = isPassword ? 'text' : 'password';
            toggleBtn.querySelector('i').classList.toggle('fa-eye');
            toggleBtn.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }

    setupPasswordToggle(togglePassword, passwordInput);
    setupPasswordToggle(toggleConfirmPassword, confirmPasswordInput);

    // Password strength checker
    function checkPasswordStrength(password) {
        let score = 0;
        const checks = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[^A-Za-z0-9]/.test(password)
        };

        Object.values(checks).forEach(check => check && score++);

        if (password.length === 0) {
            passwordStrengthBar.className = 'h-2 rounded-full transition-all duration-300';
            passwordStrengthText.textContent = '';
            return;
        }

        if (score < 2) {
            passwordStrengthBar.className = 'h-2 rounded-full transition-all duration-300 password-strength-weak';
            passwordStrengthText.textContent = 'Weak password';
            passwordStrengthText.className = 'text-sm mt-1 block text-red-500';
        } else if (score < 4) {
            passwordStrengthBar.className = 'h-2 rounded-full transition-all duration-300 password-strength-medium';
            passwordStrengthText.textContent = 'Medium strength';
            passwordStrengthText.className = 'text-sm mt-1 block text-yellow-500';
        } else {
            passwordStrengthBar.className = 'h-2 rounded-full transition-all duration-300 password-strength-strong';
            passwordStrengthText.textContent = 'Strong password';
            passwordStrengthText.className = 'text-sm mt-1 block text-green-500';
        }
    }

    passwordInput.addEventListener('input', (e) => {
        checkPasswordStrength(e.target.value);
    });

    // Field validation
    function validateField(field) {
        const value = field.value.trim();
        const errorElement = document.getElementById(`${field.id}Error`);
        let isValid = true;

        errorElement.classList.add('hidden');
        field.classList.remove('border-red-500');

        if (field.required && !value) {
            showFieldError(field, errorElement, 'This field is required');
            isValid = false;
        } else if (value) {
            switch (field.type) {
                case 'email':
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                        showFieldError(field, errorElement, 'Please enter a valid email address');
                        isValid = false;
                    }
                    break;
                case 'password':
                    if (field.id === 'password' && value.length < 8) {
                        showFieldError(field, errorElement, 'Password must be at least 8 characters');
                        isValid = false;
                    } else if (field.id === 'confirmPassword' && value !== passwordInput.value) {
                        showFieldError(field, errorElement, 'Passwords do not match');
                        isValid = false;
                    }
                    break;
            }
        }

        return isValid;
    }

    function showFieldError(field, errorElement, message) {
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
        field.classList.add('border-red-500');
        field.classList.add('animate-shake');
        setTimeout(() => field.classList.remove('animate-shake'), 500);
    }

    // Real-time validation
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('blur', () => validateField(input));
        input.addEventListener('input', () => {
            if (input.id === 'confirmPassword') {
                validateField(input);
            }
        });
    });

    // Form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        let isValid = true;
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });

        if (!isValid) return;

        // Show loading state
        submitBtn.disabled = true;
        submitText.textContent = 'Creating Account...';
        submitSpinner.classList.remove('hidden');

        try {
            // Simulate form submission (replace with actual endpoint)
            await new Promise(resolve => setTimeout(resolve, 2000));
            
            // Show success modal
            confirmedEmail.textContent = document.getElementById('email').value;
            showModal(successModal);
        } catch (error) {
            // Show error modal
            errorModalMessage.textContent = 'Registration failed. Please try again.';
            showModal(errorModal);
        } finally {
            // Reset button state
            submitBtn.disabled = false;
            submitText.textContent = 'Create Account';
            submitSpinner.classList.add('hidden');
        }
    });

    // Modal functions
    function showModal(modal) {
        modal.classList.remove('opacity-0', 'invisible');
        modal.classList.add('opacity-100', 'visible');
        modal.querySelector('.modal-content').classList.remove('scale-95');
        modal.querySelector('.modal-content').classList.add('scale-100');
    }

    function hideModal(modal) {
        modal.classList.add('opacity-0', 'invisible');
        modal.classList.remove('opacity-100', 'visible');
        modal.querySelector('.modal-content').classList.add('scale-95');
        modal.querySelector('.modal-content').classList.remove('scale-100');
    }

    // Modal event listeners
    successModalBtn.addEventListener('click', () => hideModal(successModal));
    errorModalBtn.addEventListener('click', () => hideModal(errorModal));

    // Close modals when clicking outside
    [successModal, errorModal].forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                hideModal(modal);
            }
        });
    });

    // Smooth scrolling for CTA button
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

});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>