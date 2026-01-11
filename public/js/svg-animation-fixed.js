/**
 * 7 ENSEMBLE - SVG Dancing Persons Animation (FIXED)
 * This script ensures SVG persons animate properly
 */

(function() {
    'use strict';

    console.log('🎭 SVG Animation Script Loaded');

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        console.log('🎬 Initializing SVG Animation...');

        // Method 1: Target by class .p
        const persons = document.querySelectorAll('.p');

        if (persons.length === 0) {
            console.error('❌ No SVG persons found! Make sure elements have class "p"');
            return;
        }

        console.log(`✅ Found ${persons.length} SVG persons`);

        // Apply animation to each person
        persons.forEach((person, index) => {
            const personNum = index + 1;

            // Ensure the person has the correct class
            person.classList.add(`svg-person-${personNum}`);

            // Set transform origin
            person.style.transformOrigin = 'center bottom';

            // Force animation (in case CSS doesn't apply)
            const animations = [
                'dance-move-left',
                'dance-move-center',
                'dance-move-right',
                'dance-move-left',
                'dance-move-center',
                'dance-move-right',
                'dance-move-left'
            ];

            const animationName = animations[index];
            const delay = index * 0.2;

            // Apply inline animation as fallback
            person.style.animation = `${animationName} 1.8s ease-in-out infinite`;
            person.style.animationDelay = `${delay}s`;

            // Add colors if not present
            const colors = [
                '#ff6b6b', // Red
                '#ffa94d', // Orange
                '#ffd93b', // Yellow
                '#51cf66', // Green
                '#22b8cf', // Blue
                '#5c7cfa', // Indigo
                '#cc5de8'  // Purple
            ];

            if (!person.style.color) {
                person.style.color = colors[index];
            }

            // Add hover listeners
            person.addEventListener('mouseenter', function() {
                this.style.animationPlayState = 'paused';
            });

            person.addEventListener('mouseleave', function() {
                this.style.animationPlayState = 'running';
            });

            console.log(`✅ Person ${personNum}: ${animationName}, delay: ${delay}s, color: ${person.style.color}`);
        });

        // Ensure SVG container is visible
        const svg = document.querySelector('.svg-responsive, svg');
        if (svg) {
            svg.style.overflow = 'visible';
            svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
            console.log('✅ SVG container configured');
        }

        // Test animation after 1 second
        setTimeout(testAnimation, 1000);
    }

    function testAnimation() {
        const persons = document.querySelectorAll('.p');
        persons.forEach((person, index) => {
            const computedStyle = window.getComputedStyle(person);
            const animation = computedStyle.animation || computedStyle.webkitAnimation;

            if (animation && animation !== 'none') {
                console.log(`✅ Person ${index + 1} is animating:`, animation.substring(0, 50) + '...');
            } else {
                console.error(`❌ Person ${index + 1} is NOT animating!`);
            }
        });
    }

    // Add global function to toggle animation (for debugging)
    window.toggleSVGAnimation = function() {
        const persons = document.querySelectorAll('.p');
        persons.forEach(person => {
            const state = person.style.animationPlayState;
            person.style.animationPlayState = state === 'paused' ? 'running' : 'paused';
        });
        console.log('🔄 Animation toggled');
    };

    console.log('🎉 SVG Animation Script Initialized');
    console.log('💡 Type "toggleSVGAnimation()" in console to toggle animation');

})();
