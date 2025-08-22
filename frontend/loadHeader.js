// Main initialization when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    loadHeader().then(() => {
        setupMobileMenu();
        setupHeaderEffects();
        setupPreviewSystem();
    }).catch(error => {
        console.error('Header initialization failed:', error);
    });
});

// Load header HTML and insert into page
async function loadHeader() {
    try {
        const response = await fetch('header.html');
        if (!response.ok) throw new Error('Failed to load header');
        
        const headerHTML = await response.text();
        document.body.insertAdjacentHTML('afterbegin', headerHTML);
    } catch (error) {
        console.error('Error loading header:', error);
        throw error;
    }
}

// Mobile menu functionality using event delegation
function setupMobileMenu() {
    // Track mobile menu state
    let isMobileMenuOpen = false;
    
    // Handle all clicks in document
    document.addEventListener('click', function(event) {
        // Open menu when toggle button is clicked
        if (event.target.closest('#mobileMenuButton')) {
            toggleMobileMenu(true);
        }
        
        // Close menu when close button or backdrop is clicked
        if (event.target.closest('#closeMobileMenu') || 
            event.target.closest('.mobile-menu-backdrop')) {
            toggleMobileMenu(false);
        }
        
        // Close menu when clicking nav links (optional)
        if (isMobileMenuOpen && event.target.closest('.mobile-nav-link')) {
            toggleMobileMenu(false);
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992 && isMobileMenuOpen) {
            toggleMobileMenu(false);
        }
    });
    
    // Toggle menu function
    function toggleMobileMenu(shouldOpen) {
        const mobileMenu = document.getElementById('mobileMenu');
        const backdrop = document.querySelector('.mobile-menu-backdrop');
        
        if (!mobileMenu) return;
        
        isMobileMenuOpen = shouldOpen;
        
        if (shouldOpen) {
            mobileMenu.classList.add('open');
            document.body.style.overflow = 'hidden';
            
            // Create backdrop if it doesn't exist
            if (!backdrop) {
                const newBackdrop = document.createElement('div');
                newBackdrop.className = 'mobile-menu-backdrop';
                document.body.appendChild(newBackdrop);
            }
        } else {
            mobileMenu.classList.remove('open');
            document.body.style.overflow = '';
            
            // Remove backdrop if it exists
            if (backdrop) {
                backdrop.remove();
            }
        }
    }
}

// Header scroll effects and other UI behaviors
function setupHeaderEffects() {
    // Scroll effect for header
    const header = document.querySelector('.header-container');
    
    if (header) {
        window.addEventListener('scroll', function() {
            header.classList.toggle('scrolled', window.scrollY > 50);
        });
        
        // Initialize immediately in case page is already scrolled
        header.classList.toggle('scrolled', window.scrollY > 50);
    }
    
    // Dropdown hover effects for desktop
    const dropdowns = document.querySelectorAll('.dropdown-container');
    
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('mouseenter', function() {
            if (window.innerWidth >= 992) {
                this.querySelector('.dropdown-menu').classList.add('show');
            }
        });
        
        dropdown.addEventListener('mouseleave', function() {
            if (window.innerWidth >= 992) {
                this.querySelector('.dropdown-menu').classList.remove('show');
            }
        });
    });
}


// Helper function to check if element is in viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}