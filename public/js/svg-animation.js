/**
 * 7 ENSEMBLE - SVG Dancing Persons Animation
 *
 * This script ensures the SVG dancing persons animate properly
 * with smooth movements and proper timing.
 */

(function() {
    'use strict';

    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeSVGAnimation();
    });

    /**
     * Initialize SVG animation
     */
    function initializeSVGAnimation() {
        const svgPersons = document.querySelectorAll('.p');

        if (svgPersons.length === 0) {
            console.warn('No SVG persons found with class ".p"');
            return;
        }

        console.log(`Found ${svgPersons.length} SVG dancing persons`);

        // Ensure each person has proper animation class
        svgPersons.forEach((person, index) => {
            // Add specific class for individual timing
            person.classList.add(`svg-person-${index + 1}`);

            // Set transform origin for better animation
            person.style.transformOrigin = 'center bottom';

            // Add hover effect listeners
            person.addEventListener('mouseenter', function() {
                this.style.animationPlayState = 'paused';
            });

            person.addEventListener('mouseleave', function() {
                this.style.animationPlayState = 'running';
            });
        });

        // Make SVG responsive
        const svg = document.querySelector('.svg-responsive, svg');
        if (svg) {
            svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');

            // Ensure overflow is visible for animations
            svg.style.overflow = 'visible';
        }

        console.log('SVG animation initialized successfully');
    }

    /**
     * Optional: Add color animation on click
     */
    function addClickAnimation() {
        const svgPersons = document.querySelectorAll('.p');

        svgPersons.forEach(person => {
            person.addEventListener('click', function(e) {
                // Create a pulse effect
                this.style.transition = 'transform 0.3s ease-out';
                this.style.transform = 'scale(1.3) translateY(-20px)';

                setTimeout(() => {
                    this.style.transform = '';
                }, 300);
            });
        });
    }

    // Optional: Call this to add click animations
    // addClickAnimation();

})();
