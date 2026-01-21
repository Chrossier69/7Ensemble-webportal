/**
 * 7 ENSEMBLE - Enhanced Modal Management
 * Handles three popup scenarios with proper state management
 */

// Global state
let currentModalMode = null; // 'both', '3only', '7only'

/**
 * SCENARIO A: Show modal with both options
 * Called from generic "Rejoindre" buttons
 */
function showModalBothOptions() {
    currentModalMode = 'both';
    openRegistrationModal();
}

/**
 * SCENARIO B: Show modal with ONLY 3 people option
 * Called from "Commencer avec 3 personnes" button
 */
function showModalThreeOnly() {
    currentModalMode = '3only';
    openRegistrationModal();
}

/**
 * SCENARIO C: Show modal with ONLY 7 people option
 * Called from "Commencer avec 7 personnes" button
 */
function showModalSevenOnly() {
    currentModalMode = '7only';
    openRegistrationModal();
}

/**
 * Main function to open and configure the modal
 */
function openRegistrationModal() {
    const modal = document.getElementById('registrationModal');
    if (!modal) {
        console.error('Registration modal not found');
        return;
    }

    // Reset form and errors
    resetModal();

    // Configure options based on mode
    configureModalOptions();

    // Show modal
    modal.style.display = 'block';
    modal.classList.add('show');
    document.body.classList.add('modal-open');

    // Focus first input
    setTimeout(() => {
        const firstInput = modal.querySelector('input[type="text"]');
        if (firstInput) firstInput.focus();
    }, 100);
}

/**
 * Configure which options to show based on current mode
 */
function configureModalOptions() {
    const option3Container = document.getElementById('option3Container');
    const option7Container = document.getElementById('option7Container');
    const option3Radio = document.getElementById('option3Radio');
    const option7Radio = document.getElementById('option7Radio');
    const optionsTitle = document.getElementById('optionsTitle');

    if (!option3Container || !option7Container) {
        console.error('Option containers not found');
        return;
    }

    // Reset all
    option3Container.style.display = 'none';
    option7Container.style.display = 'none';
    if (option3Radio) option3Radio.checked = false;
    if (option7Radio) option7Radio.checked = false;

    // Configure based on mode
    switch (currentModalMode) {
        case 'both':
            // Show both options
            option3Container.style.display = 'block';
            option7Container.style.display = 'block';
            if (optionsTitle) optionsTitle.textContent = '✨ Choisir mon option ✨';
            // Don't pre-select any
            break;

        case '3only':
            // Show only 3 people option
            option3Container.style.display = 'block';
            option7Container.style.display = 'none';
            if (option3Radio) option3Radio.checked = true;
            if (optionsTitle) optionsTitle.textContent = '✨ Votre option : 3 personnes ✨';
            break;

        case '7only':
            // Show only 7 people option
            option3Container.style.display = 'none';
            option7Container.style.display = 'block';
            if (option7Radio) option7Radio.checked = true;
            if (optionsTitle) optionsTitle.textContent = '✨ Votre option : 7 personnes ✨';
            break;
    }
}

/**
 * Close modal
 */
function closeModal() {
    const modal = document.getElementById('registrationModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');
    }

    // Reset state
    currentModalMode = null;
    resetModal();
}

/**
 * Reset modal form and validation
 */
function resetModal() {
    const form = document.getElementById('registrationForm');
    if (form) {
        form.reset();
        clearValidationErrors();
    }
}

/**
 * Clear all validation error messages
 */
function clearValidationErrors() {
    const errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach(el => el.remove());

    const invalidInputs = document.querySelectorAll('.invalid');
    invalidInputs.forEach(input => input.classList.remove('invalid'));
}

/**
 * Show validation error for a specific field
 */
function showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    // Remove existing error
    const existingError = field.parentElement.querySelector('.error-message');
    if (existingError) existingError.remove();

    // Add invalid class
    field.classList.add('invalid');

    // Create error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    field.parentElement.appendChild(errorDiv);
}

/**
 * Validate form fields
 */
function validateForm() {
    clearValidationErrors();
    let isValid = true;

    // Validate Prénom
    const prenom = document.getElementById('prenom');
    if (!prenom.value.trim()) {
        showFieldError('prenom', 'Le prénom est requis');
        isValid = false;
    } else if (prenom.value.trim().length < 2) {
        showFieldError('prenom', 'Le prénom doit contenir au moins 2 caractères');
        isValid = false;
    }

    // Validate Nom
    const nom = document.getElementById('nom');
    if (!nom.value.trim()) {
        showFieldError('nom', 'Le nom est requis');
        isValid = false;
    } else if (nom.value.trim().length < 2) {
        showFieldError('nom', 'Le nom doit contenir au moins 2 caractères');
        isValid = false;
    }

    // Validate Email
    const email = document.getElementById('email');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value.trim()) {
        showFieldError('email', 'L\'email est requis');
        isValid = false;
    } else if (!emailPattern.test(email.value.trim())) {
        showFieldError('email', 'Veuillez entrer une adresse email valide');
        isValid = false;
    }

    // Validate Country
    const country = document.getElementById('country');
    if (!country.value) {
        showFieldError('country', 'Veuillez choisir votre pays');
        isValid = false;
    }

    // Validate Payment Method
    const paymentMethod = document.getElementById('paymentMethod');
    if (!paymentMethod.value) {
        showFieldError('paymentMethod', 'Veuillez choisir un mode de paiement');
        isValid = false;
    }

    // Validate Terms
    const terms = document.getElementById('terms');
    if (!terms.checked) {
        showFieldError('terms', 'Vous devez accepter les conditions');
        isValid = false;
    }

    // Validate Option (only if mode is 'both')
    if (currentModalMode === 'both') {
        const option3 = document.getElementById('option3Radio');
        const option7 = document.getElementById('option7Radio');
        if (!option3.checked && !option7.checked) {
            // Show error near the options
            const optionsContainer = document.querySelector('.options-container');
            if (optionsContainer) {
                const existingError = optionsContainer.querySelector('.error-message');
                if (existingError) existingError.remove();

                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = 'Veuillez choisir une option (3 ou 7 personnes)';
                optionsContainer.appendChild(errorDiv);
            }
            isValid = false;
        }
    }

    return isValid;
}

/**
 * Handle form submission
 */
function submitRegistrationForm(event) {
    event.preventDefault();

    // Validate form
    if (!validateForm()) {
        // Scroll to first error
        const firstError = document.querySelector('.invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
        return false;
    }

    // Get form data
    const form = document.getElementById('registrationForm');
    const formData = new FormData(form);

    // Get selected option
    let selectedOption;
    if (currentModalMode === '3only') {
        selectedOption = '3';
    } else if (currentModalMode === '7only') {
        selectedOption = '7';
    } else {
        selectedOption = formData.get('choixOption');
    }

    // Prepare data object
    const data = {
        prenom: formData.get('prenom'),
        nom: formData.get('nom'),
        email: formData.get('email'),
        country: formData.get('country'),
        paymentMethod: formData.get('paymentMethod'),
        option: selectedOption,
        terms: formData.get('terms') === 'on'
    };

    // Log data (since no backend yet)
    console.log('Form submitted with data:', data);

    // Show success message
    showSuccessMessage();

    // Close modal after delay
    setTimeout(() => {
        closeModal();
    }, 2000);

    return false;
}

/**
 * Show success message
 */
function showSuccessMessage() {
    const successDiv = document.createElement('div');
    successDiv.className = 'success-toast';
    successDiv.innerHTML = `
        <div class="success-content">
            <span class="success-icon">✅</span>
            <div class="success-text">
                <strong>Merci !</strong>
                <p>Votre inscription a été enregistrée.</p>
            </div>
        </div>
    `;
    document.body.appendChild(successDiv);

    // Add show class after small delay for animation
    setTimeout(() => {
        successDiv.classList.add('show');
    }, 10);

    // Remove after 5 seconds
    setTimeout(() => {
        successDiv.classList.remove('show');
        setTimeout(() => successDiv.remove(), 300);
    }, 5000);
}

/**
 * Event Listeners Setup
 */
document.addEventListener('DOMContentLoaded', function() {
    // Close modal on outside click
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('registrationModal');
        if (event.target === modal) {
            closeModal();
        }
    });

    // Close modal on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('registrationModal');
            if (modal && modal.classList.contains('show')) {
                closeModal();
            }
        }
    });

    // Add real-time validation feedback
    const form = document.getElementById('registrationForm');
    if (form) {
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim()) {
                    // Remove error when field is filled
                    this.classList.remove('invalid');
                    const error = this.parentElement.querySelector('.error-message');
                    if (error) error.remove();
                }
            });
        });
    }
});

// Legacy function names for compatibility
function showSevenModal() {
    showModalSevenOnly();
}

function showThreeModal() {
    showModalThreeOnly();
}
