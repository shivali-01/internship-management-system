// Form validation and interactivity
document.addEventListener('DOMContentLoaded', function() {
    // Confirm before delete
    const deleteLinks = document.querySelectorAll('.btn-delete, .confirm-delete');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => {
                if (alert.parentNode) alert.parentNode.removeChild(alert);
            }, 500);
        }, 5000);
    });

    // Real-time password match check
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    if (password && confirmPassword) {
        function checkPasswordMatch() {
            if (confirmPassword.value.length > 0) {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.classList.add('input-error');
                    confirmPassword.setCustomValidity('Passwords do not match');
                } else {
                    confirmPassword.classList.remove('input-error');
                    confirmPassword.setCustomValidity('');
                }
            }
        }
        password.addEventListener('input', checkPasswordMatch);
        confirmPassword.addEventListener('input', checkPasswordMatch);
    }

    // Phone number formatting - digits only
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').substring(0, 10);
        });
    });

    // Stipend input - numbers only
    const stipendInput = document.getElementById('stipend');
    if (stipendInput) {
        stipendInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
    }

    // Vacancies input - whole numbers only
    const vacanciesInput = document.getElementById('vacancies');
    if (vacanciesInput) {
        vacanciesInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (parseInt(this.value) < 1) this.value = 1;
        });
    }
});
