/**
 * 7 ENSEMBLE - Animations
 * Handles scroll-triggered animations and number counting
 */

// Animate numbers on scroll
function animateNumbers() {
    const numbers = document.querySelectorAll('.stat-number, .tour-amount');
    numbers.forEach(num => {
        const rect = num.getBoundingClientRect();
        if (rect.top < window.innerHeight && !num.classList.contains('animated')) {
            num.classList.add('animated');
            const finalValue = num.textContent;
            num.textContent = '0';
            let current = 0;
            const target = parseInt(finalValue.replace(/[^\d]/g, ''));
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    num.textContent = finalValue;
                    clearInterval(timer);
                } else {
                    num.textContent = Math.floor(current) + (finalValue.includes('€') ? '€' : '');
                }
            }, 50);
        }
    });
}

// Add scroll listener for number animations
if (typeof window !== 'undefined') {
    window.addEventListener('scroll', animateNumbers);
    // Trigger once on load
    document.addEventListener('DOMContentLoaded', animateNumbers);
}

// Animate elements on scroll
function animateOnScroll() {
    const elements = document.querySelectorAll('.impact-card, .goal-item');
    elements.forEach((el, index) => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.8) {
            el.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
        }
    });
}

// Add scroll listener for element animations
if (typeof window !== 'undefined') {
    window.addEventListener('scroll', animateOnScroll);
    document.addEventListener('DOMContentLoaded', animateOnScroll);
}

// Create confetti for mission page
function createConfetti() {
    const confetti = document.createElement('div');
    confetti.className = 'confetti';
    confetti.style.left = Math.random() * 100 + '%';
    confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
    confetti.style.backgroundColor = [
        '#ff6b6b', '#4ecdc4', '#45b7d1', '#feca57', '#f093fb'
    ][Math.floor(Math.random() * 5)];

    document.body.appendChild(confetti);

    setTimeout(() => {
        confetti.remove();
    }, 5000);
}

// Start confetti animation if on mission page
if (typeof window !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        // Check if we're on the mission page
        if (document.querySelector('.hero-mission')) {
            setInterval(createConfetti, 300);
        }
    });
}

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        animateNumbers,
        animateOnScroll,
        createConfetti
    };
}
