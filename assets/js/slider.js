let currentSlideIndex = 0;
let slides = document.querySelectorAll('.slide');
let dots = document.querySelectorAll('.nav-dot');
let autoSlideInterval;
let progressInterval;
<<<<<<< HEAD
const slideInterval = 5000; // 5 seconds
=======
const slideInterval = 8000; // 5 seconds
>>>>>>> 5a631e8 (Fixed UI)

// Initialize slider
function initSlider() {
    showSlide(0);
    startAutoSlide();
}

// Show specific slide
function showSlide(index) {
    // Remove active class from all slides and dots
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));

    // Add active class to current slide and dot
    slides[index].classList.add('active');
    dots[index].classList.add('active');

    currentSlideIndex = index;
    updateProgressBar();
}

// Change slide (next/previous)
function changeSlide(direction) {
    stopAutoSlide();
    currentSlideIndex += direction;

    if (currentSlideIndex >= slides.length) {
        currentSlideIndex = 0;
    } else if (currentSlideIndex < 0) {
        currentSlideIndex = slides.length - 1;
    }

    showSlide(currentSlideIndex);
    startAutoSlide();
}

// Go to specific slide
function currentSlide(index) {
    stopAutoSlide();
    showSlide(index - 1);
    startAutoSlide();
}

// Start automatic slideshow
function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
        currentSlideIndex = (currentSlideIndex + 1) % slides.length;
        showSlide(currentSlideIndex);
    }, slideInterval);

    startProgressBar();
}

// Stop automatic slideshow
function stopAutoSlide() {
    clearInterval(autoSlideInterval);
    clearInterval(progressInterval);
}

// Progress bar animation
function startProgressBar() {
    const progressBar = document.getElementById('progressBar');
    let width = 0;
    const increment = 100 / (slideInterval / 50);

    clearInterval(progressInterval);
    progressBar.style.width = '0%';

    progressInterval = setInterval(() => {
        width += increment;
        progressBar.style.width = width + '%';

        if (width >= 100) {
            clearInterval(progressInterval);
        }
    }, 50);
}

function updateProgressBar() {
    const progressBar = document.getElementById('progressBar');
    progressBar.style.width = '0%';
}

// Pause on hover
document.querySelector('.slider-container').addEventListener('mouseenter', () => {
    stopAutoSlide();
});

document.querySelector('.slider-container').addEventListener('mouseleave', () => {
    startAutoSlide();
});

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
        changeSlide(-1);
    } else if (e.key === 'ArrowRight') {
        changeSlide(1);
    }
});

// Touch/swipe support for mobile
let touchStartX = 0;
let touchEndX = 0;

document.querySelector('.slider-wrapper').addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
});

document.querySelector('.slider-wrapper').addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;

    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            changeSlide(1); // Swipe left, go to next
        } else {
            changeSlide(-1); // Swipe right, go to previous
        }
    }
}

// Initialize the slider when page loads
window.addEventListener('load', initSlider);