document.addEventListener('DOMContentLoaded', function() {
    // Load header
    fetch('header.html')
        .then(response => response.text())
        .then(data => {
            document.body.insertAdjacentHTML('afterbegin', data);
            initHeaderScripts();
        })
        .catch(error => {
            console.error('Error loading header:', error);
        });
});

function initHeaderScripts() {
    const previewOverlay = document.getElementById('previewOverlay');
    const previewContent = document.getElementById('previewContent');
    const previewTitle = document.getElementById('previewTitle');
    const previewClose = document.getElementById('previewClose');
    const overlayBackdrop = document.getElementById('overlayBackdrop');
    
    let previewTimeout;
    let currentPreviewUrl = '';
    let isMobile = window.innerWidth < 992;
    
    // Check screen size
    window.addEventListener('resize', function() {
        isMobile = window.innerWidth < 992;
    });
    
    // Load page content for preview
    async function loadPreviewContent(url) {
        try {
            previewContent.innerHTML = `
                <div class="preview-loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>`;
            
            const response = await fetch(url);
            if (!response.ok) throw new Error('Failed to load');
            
            const text = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(text, 'text/html');
            
            // Extract main content (adjust selector as needed)
            const mainContent = doc.querySelector('main') || doc.querySelector('.container') || doc.body;
            
            // Set title from the page's h1 or title tag
            const pageTitle = doc.querySelector('h1')?.textContent || 
                             doc.querySelector('title')?.textContent || 
                             'Preview';
            previewTitle.textContent = pageTitle;
            
            // Clean up content (remove scripts, etc.)
            mainContent.querySelectorAll('script').forEach(script => script.remove());
            
            // Set the preview content
            previewContent.innerHTML = '';
            previewContent.appendChild(mainContent);
            
            // Initialize any Bootstrap components in the preview
            if (typeof bootstrap !== 'undefined') {
                previewContent.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                    new bootstrap.Tooltip(el);
                });
            }
            
        } catch (error) {
            console.error('Preview error:', error);
            previewContent.innerHTML = `
                <div class="alert alert-danger">
                    Could not load preview content. Please visit the page directly.
                </div>`;
        }
    }
    
    // Show preview overlay
    function showPreview(url) {
        if (currentPreviewUrl === url && previewOverlay.classList.contains('active')) {
            return; // Already showing this preview
        }
        
        currentPreviewUrl = url;
        previewOverlay.classList.add('active');
        overlayBackdrop.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        loadPreviewContent(url);
    }
    
    // Hide preview overlay
    function hidePreview() {
        previewOverlay.classList.remove('active');
        overlayBackdrop.classList.remove('active');
        document.body.style.overflow = '';
        currentPreviewUrl = '';
    }
    
    // Add event listeners to all previewable links
    document.querySelectorAll('[data-preview-url]').forEach(link => {
        link.addEventListener('mouseenter', function() {
            if (isMobile) return;
            
            clearTimeout(previewTimeout);
            const url = this.getAttribute('data-preview-url');
            showPreview(url);
        });
        
        link.addEventListener('mouseleave', function() {
            if (isMobile) return;
            
            previewTimeout = setTimeout(() => {
                if (!previewOverlay.matches(':hover') && !overlayBackdrop.matches(':hover')) {
                    hidePreview();
                }
            }, 300);
        });
        
        // For click on mobile
        link.addEventListener('click', function(e) {
            if (!isMobile) return;
            e.preventDefault();
            const url = this.getAttribute('href');
            showPreview(url);
        });
    });
    
    // Keep preview visible when hovering over it
    previewOverlay.addEventListener('mouseenter', function() {
        clearTimeout(previewTimeout);
    });
    
    previewOverlay.addEventListener('mouseleave', function() {
        previewTimeout = setTimeout(() => {
            hidePreview();
        }, 300);
    });
    
    // Close button
    previewClose.addEventListener('click', hidePreview);
    overlayBackdrop.addEventListener('click', hidePreview);
    
    // Close mobile menu when clicking a link
    document.querySelectorAll('.offcanvas-body a').forEach(link => {
        link.addEventListener('click', function() {
            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('navbarOffcanvas'));
            if (offcanvas) offcanvas.hide();
        });
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    
    // Mega dropdown positioning
    const megaDropdowns = document.querySelectorAll('.mega-dropdown');
    megaDropdowns.forEach(dropdown => {
        dropdown.addEventListener('mouseenter', function() {
            if (isMobile) return;
            
            const menu = this.querySelector('.mega-menu');
            if (menu) {
                const rect = this.getBoundingClientRect();
                const windowWidth = window.innerWidth;
                const menuWidth = menu.offsetWidth;
                
                let left = rect.left;
                
                // Adjust if menu goes off screen right
                if (left + menuWidth > windowWidth) {
                    left = windowWidth - menuWidth - 20;
                }
                
                menu.style.left = `${left}px`;
            }
        });
    });
}