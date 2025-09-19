document.addEventListener('DOMContentLoaded', function() {
    // Menu toggle functionality
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu'); 
    
    menuToggle.addEventListener('click', function() {
        mobileMenu.classList.toggle('active');
        // Close search if open
        searchBox.classList.remove('active');
    });
    
    // Search toggle functionality
    const searchToggle = document.getElementById('search-toggle');
    const searchBox = document.getElementById('search-box');
    
    searchToggle.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent closing immediately
        searchBox.classList.toggle('active');
        // Close menu if open 
        mobileMenu.classList.remove('active');
    });
    
    // Close both menus when clicking outside
    document.addEventListener('click', function(event) {
        if (!menuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
            mobileMenu.classList.remove('active');
        }
        if (!searchToggle.contains(event.target) && !searchBox.contains(event.target)) {
            searchBox.classList.remove('active');
        }
    });
    
    // Prevent form submission from closing the search box
    searchBox.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});