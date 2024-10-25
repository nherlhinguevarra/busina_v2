// Function to toggle password visibility for a specific input
function togglePassword(inputId) {
    var passwordInput = document.getElementById(inputId);
    var eyeIcon = passwordInput.parentElement.querySelector('.eye-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    }
}

// Function to hide error message
function hideErrorMessage() {
    const errorMessage = document.getElementById('errorMessage');
    if (errorMessage) {
        errorMessage.style.display = 'none';
    }
}

// Function to hide success message
function hideSuccessMessage() {
    const successMessage = document.getElementById('successMessage');
    if (successMessage) {
        successMessage.style.display = 'none';
    }
}

// Setup event listeners when the DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    // Setup password toggle for all password fields
    const passwordFields = [
        'current_password',
        'new_password',
        'new_password_confirmation'
    ];

    passwordFields.forEach(fieldId => {
        const eyeIcon = document.querySelector(`#${fieldId}`).parentElement.querySelector('.eye-icon');
        if (eyeIcon) {
            eyeIcon.addEventListener('click', () => togglePassword(fieldId));
        }
    });

    // Handle error message auto-hide
    const errorMessage = document.getElementById('errorMessage');
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 5000);
    }

    // Handle success message auto-hide
    const successMessage = document.getElementById('successMessage');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000);
    }
});