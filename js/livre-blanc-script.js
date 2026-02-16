/* ===================================
   LIVRE BLANC 7 ENSEMBLE - JAVASCRIPT
   Interactive functionality - FIXED VERSION
   =================================== */

// === CONFIGURATION DATA ===
const defaultConfig = {
    titre_principal: "Redonner du pouvoir d'achat, pas des illusions",
    sous_titre: "Un livre blanc sur les vraies solutions",
    nom_marque: "O'❤️2 LA PUB.ch – Projet 7 Ensemble",
    contact_info: "contact@exemple.ch"
};

// === DOM READY ===
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Loaded - Initializing...');
    initSommaireToggle();
    initSmoothScroll();
    initScrollAnimations();
    console.log('Initialization complete');
});

// === SOMMAIRE TOGGLE FUNCTIONALITY ===
function initSommaireToggle() {
    // Handle expandable sommaire items
    const expandableLinks = document.querySelectorAll('.sommaire-link-expandable');
    
    expandableLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            
            const parentItem = link.closest('.sommaire-item-expandable');
            
            // Toggle the is-open class
            parentItem.classList.toggle('is-open');
            
            // Optional: Close other open items (single accordion behavior)
            // Uncomment below to enable
            /*
            const allExpandableItems = document.querySelectorAll('.sommaire-item-expandable');
            allExpandableItems.forEach(item => {
                if (item !== parentItem) {
                    item.classList.remove('is-open');
                }
            });
            */
        });
    });
}

// === SMOOTH SCROLL FOR ALL ANCHOR LINKS ===
function initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            
            // Skip if it's just "#" or if it's an expandable link
            if (href === '#' || link.classList.contains('sommaire-link-expandable')) {
                return;
            }
            
            e.preventDefault();
            
            const targetId = href.substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const headerOffset = 100;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// === ANIMATION ON SCROLL - FIXED VERSION ===
function initScrollAnimations() {
    // Check if IntersectionObserver is supported
    if (!('IntersectionObserver' in window)) {
        console.log('IntersectionObserver not supported - skipping animations');
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Add animation class when element comes into view
                entry.target.classList.add('animate-in');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    // Observe all sections
    const sections = document.querySelectorAll('.section');
    sections.forEach((section, index) => {
        // Add a slight delay for staggered animation
        section.style.setProperty('--animation-order', index);
        observer.observe(section);
    });
}

// === PRINT FUNCTIONALITY ===
function printDocument() {
    window.print();
}

// === SHARE FUNCTIONALITY ===
async function shareDocument() {
    if (navigator.share) {
        try {
            await navigator.share({
                title: document.getElementById('titre-principal').textContent,
                text: document.getElementById('sous-titre').textContent,
                url: window.location.href
            });
        } catch (err) {
            console.log('Error sharing:', err);
        }
    } else {
        // Fallback: copy URL to clipboard
        navigator.clipboard.writeText(window.location.href)
            .then(() => alert('Lien copié dans le presse-papier!'))
            .catch(err => console.error('Could not copy:', err));
    }
}

// === CONTENT MANAGEMENT ===
function updateContent(elementId, newContent) {
    const element = document.getElementById(elementId);
    if (element) {
        element.textContent = newContent;
        localStorage.setItem(`content_${elementId}`, newContent);
        return true;
    }
    return false;
}

function loadSavedContent() {
    const editableElements = ['titre-principal', 'sous-titre', 'nom-marque', 'contact-info'];
    
    editableElements.forEach(id => {
        const savedContent = localStorage.getItem(`content_${id}`);
        if (savedContent) {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = savedContent;
            }
        }
    });
}

// === THEME MANAGEMENT ===
function updateColors(colors) {
    const {
        background_color,
        primary_color,
        secondary_color,
        text_color,
        surface_color
    } = colors;
    
    if (background_color) {
        document.body.style.background = background_color;
    }
    
    if (text_color) {
        document.body.style.color = text_color;
    }
    
    if (primary_color && secondary_color) {
        const header = document.querySelector('.header');
        if (header) {
            header.style.background = `linear-gradient(135deg, ${primary_color} 0%, ${secondary_color} 100%)`;
        }
    }
    
    if (surface_color) {
        const sections = document.querySelectorAll('.section');
        sections.forEach(section => {
            section.style.background = surface_color;
        });
    }
    
    localStorage.setItem('theme_colors', JSON.stringify(colors));
}

function loadSavedColors() {
    const savedColors = localStorage.getItem('theme_colors');
    if (savedColors) {
        try {
            const colors = JSON.parse(savedColors);
            updateColors(colors);
        } catch (e) {
            console.error('Error loading saved colors:', e);
        }
    }
}

function resetToDefault() {
    localStorage.clear();
    window.location.reload();
}

// === ACCESSIBILITY IMPROVEMENTS ===
function initAccessibility() {
    // Add keyboard navigation for expandable links
    const expandableLinks = document.querySelectorAll('.sommaire-link-expandable');
    
    expandableLinks.forEach(link => {
        link.setAttribute('role', 'button');
        link.setAttribute('tabindex', '0');
        link.setAttribute('aria-expanded', 'false');
        
        link.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                link.click();
                
                // Update aria-expanded
                const parentItem = link.closest('.sommaire-item-expandable');
                const isOpen = parentItem.classList.contains('is-open');
                link.setAttribute('aria-expanded', isOpen.toString());
            }
        });
        
        // Update aria-expanded on click
        link.addEventListener('click', () => {
            setTimeout(() => {
                const parentItem = link.closest('.sommaire-item-expandable');
                const isOpen = parentItem.classList.contains('is-open');
                link.setAttribute('aria-expanded', isOpen.toString());
            }, 50);
        });
    });
    
    // Add ARIA roles to sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.setAttribute('role', 'region');
        const heading = section.querySelector('h2');
        if (heading && !heading.id) {
            heading.id = `heading-${section.id}`;
        }
        if (heading) {
            section.setAttribute('aria-labelledby', heading.id);
        }
    });
}

// === IMAGE LAZY LOADING ===
function initLazyLoading() {
    if ('loading' in HTMLImageElement.prototype) {
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            img.src = img.dataset.src || img.src;
        });
    } else {
        // Fallback for browsers that don't support lazy loading
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
        document.body.appendChild(script);
    }
}

// === EXPORT FUNCTIONS FOR EXTERNAL USE ===
window.LivreBlanc = {
    updateContent,
    updateColors,
    loadSavedColors,
    loadSavedContent,
    resetToDefault,
    print: printDocument,
    share: shareDocument,
    config: defaultConfig
};

// === INITIALIZE ON LOAD ===
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        loadSavedColors();
        loadSavedContent();
        initAccessibility();
        initLazyLoading();
    });
} else {
    loadSavedColors();
    loadSavedContent();
    initAccessibility();
    initLazyLoading();
}

// === DEBUG MODE ===
const DEBUG = true;

if (DEBUG) {
    console.log('🚀 Livre Blanc 7 Ensemble - Debug Mode');
    console.log('📋 Configuration:', defaultConfig);
    console.log('⚙️ Available functions:', Object.keys(window.LivreBlanc));
    
    // Log when each function is called
    window.addEventListener('load', () => {
        console.log('✅ Page fully loaded');
        console.log('📊 Sections found:', document.querySelectorAll('.section').length);
        console.log('🎯 Testimonials found:', document.querySelectorAll('.testi-card').length);
    });
}

// === ERROR HANDLING ===
window.addEventListener('error', (e) => {
    console.error('❌ JavaScript Error:', e.error);
});

// === PERFORMANCE MONITORING ===
if (DEBUG && 'performance' in window) {
    window.addEventListener('load', () => {
        setTimeout(() => {
            const perfData = performance.getEntriesByType('navigation')[0];
            console.log('⚡ Page Load Time:', Math.round(perfData.loadEventEnd - perfData.fetchStart), 'ms');
        }, 0);
    });
}