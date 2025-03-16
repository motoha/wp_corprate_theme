/**
 * Mobile Menu JavaScript
 * Handles toggling the mobile menu and dropdowns
 */
(function() {
    // Mobile menu toggle functionality
    const menuButton = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            menuButton.classList.toggle('is-active');
            
            // Toggle aria-expanded for accessibility
            const expanded = menuButton.getAttribute('aria-expanded') === 'true' || false;
            menuButton.setAttribute('aria-expanded', !expanded);
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!mobileMenu.contains(event.target) && !menuButton.contains(event.target) && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            menuButton.classList.remove('is-active');
            menuButton.setAttribute('aria-expanded', 'false');
        }
    });
    
    // Handle mobile dropdown toggles
    const dropdownTriggers = document.querySelectorAll('.mobile-menu .dropdown-trigger');
    
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            // Only prevent default if this is a parent menu item with dropdowns
            if (this.nextElementSibling && this.nextElementSibling.classList.contains('mobile-dropdown')) {
                e.preventDefault();
                
                // Toggle the dropdown
                const dropdown = this.nextElementSibling;
                dropdown.classList.toggle('active');
                
                // Rotate the chevron icon
                const chevron = this.querySelector('.chevron');
                if (chevron) {
                    chevron.classList.toggle('rotate-90');
                }
            }
        });
    });
    
    // Handle resize - reset mobile menu state on desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            menuButton.classList.remove('is-active');
            menuButton.setAttribute('aria-expanded', 'false');
        }
    });
})();