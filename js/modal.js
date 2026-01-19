/**
 * 7 ENSEMBLE - Modal Management
 * Handles all modal functionality with proper state management
 */

// Global state to track which option was clicked
let selectedOption = null;

// Open modal for 7 people option
function showSevenModal() {
    selectedOption = 7;
    showRegistrationModal();
}

// Open modal for 3 people option
function showThreeModal() {
    selectedOption = 3;
    showRegistrationModal();
}

// Main function to show registration modal
function showRegistrationModal() {
    const modal = document.getElementById('registrationModal');
    if (!modal) {
        console.error('Registration modal not found');
        return;
    }

    // Reset form first
    const form = document.getElementById('registrationForm');
    if (form) {
        form.reset();
    }

    // Show/hide radio buttons based on selected option
    const option3Container = document.getElementById('option3Container');
    const option7Container = document.getElementById('option7Container');
    const option3Radio = document.getElementById('option3Radio');
    const option7Radio = document.getElementById('option7Radio');

    if (selectedOption === 3) {
        // Show only 3 people option
        if (option3Container) option3Container.style.display = 'block';
        if (option7Container) option7Container.style.display = 'none';
        if (option3Radio) option3Radio.checked = true;
    } else if (selectedOption === 7) {
        // Show only 7 people option
        if (option3Container) option3Container.style.display = 'none';
        if (option7Container) option7Container.style.display = 'block';
        if (option7Radio) option7Radio.checked = true;
    }

    // Show modal
    modal.classList.add('show');
    modal.style.display = 'block';

    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
}

// Close modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';

        // Restore body scroll
        document.body.style.overflow = 'auto';

        // Reset selected option
        selectedOption = null;
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        const modalId = event.target.id;
        closeModal(modalId);
    }
}

// Close with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('.modal.show');
        modals.forEach(modal => {
            closeModal(modal.id);
        });
    }
});

// Form submission handler with AJAX
function submitRegistrationForm(event) {
    event.preventDefault();

    const form = document.getElementById('registrationForm');
    if (!form) {
        console.error('Form not found');
        return false;
    }

    // Get form data
    const formData = new FormData(form);

    // Add CSRF token if available (Laravel)
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        formData.append('_token', csrfToken.getAttribute('content'));
    }

    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '⏳ Envoi en cours...';

    // Submit via AJAX
    fetch('/api/register', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showSuccessMessage(data.message || 'Inscription réussie ! Nous vous contacterons bientôt.');

            // Close modal
            closeModal('registrationModal');

            // Reset form
            form.reset();
        } else {
            // Show error message
            showErrorMessage(data.message || 'Une erreur est survenue. Veuillez réessayer.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorMessage('Erreur de connexion. Veuillez vérifier votre connexion internet et réessayer.');
    })
    .finally(() => {
        // Restore button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });

    return false;
}

// Show success message
function showSuccessMessage(message) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'alert alert-success';
    messageDiv.innerHTML = `
        <div style="position: fixed; top: 20px; right: 20px; z-index: 10000; background: linear-gradient(45deg, #51cf66, #22b8cf); color: white; padding: 20px 30px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); animation: slideIn 0.3s ease-out;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="font-size: 2rem;">✅</span>
                <div>
                    <strong style="font-size: 1.1rem; display: block; margin-bottom: 5px;">Succès !</strong>
                    <span>${message}</span>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(messageDiv);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        messageDiv.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => messageDiv.remove(), 300);
    }, 5000);
}

// Show error message
function showErrorMessage(message) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'alert alert-error';
    messageDiv.innerHTML = `
        <div style="position: fixed; top: 20px; right: 20px; z-index: 10000; background: linear-gradient(45deg, #ff6b6b, #ff8787); color: white; padding: 20px 30px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); animation: slideIn 0.3s ease-out;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="font-size: 2rem;">⚠️</span>
                <div>
                    <strong style="font-size: 1.1rem; display: block; margin-bottom: 5px;">Erreur</strong>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.parentElement.remove()" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; margin-left: 10px;">&times;</button>
            </div>
        </div>
    `;
    document.body.appendChild(messageDiv);

    // Auto-remove after 7 seconds
    setTimeout(() => {
        if (document.body.contains(messageDiv)) {
            messageDiv.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => messageDiv.remove(), 300);
        }
    }, 7000);
}

// Add CSS for animations
if (!document.getElementById('modal-animations')) {
    const style = document.createElement('style');
    style.id = 'modal-animations';
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}
