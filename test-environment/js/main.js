// main.js - Core JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    console.log('Importance Leadership Website loaded successfully!');
    
    // Test all basic functionality
    initializeComponents();
});

function initializeComponents() {
    console.log('Initializing components...');
    
    // Test flash message functionality
    if (typeof window.showFlashMessage === 'undefined') {
        window.showFlashMessage = function(type, message) {
            console.log(`Flash message: [${type}] ${message}`);
        };
    }
    
    // Test loading indicator
    if (typeof window.showLoading === 'undefined') {
        window.showLoading = function() {
            const indicator = document.getElementById('loading-indicator');
            if (indicator) {
                indicator.style.display = 'flex';
            }
        };
        
        window.hideLoading = function() {
            const indicator = document.getElementById('loading-indicator');
            if (indicator) {
                indicator.style.display = 'none';
            }
        };
    }
    
    console.log('All components initialized successfully!');
}