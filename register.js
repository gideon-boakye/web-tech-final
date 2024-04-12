document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.querySelector('form');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');

   
    function validatePassword() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.setCustomValidity("Passwords do not match.");
        } else {
            confirmPasswordInput.setCustomValidity('');
        }
    }

 
    passwordInput.addEventListener('change', validatePassword);
    confirmPasswordInput.addEventListener('keyup', validatePassword);

    
    registerForm.addEventListener('submit', function (event) {
        validatePassword();
 
        if (passwordInput.value !== confirmPasswordInput.value) {
            event.preventDefault();
        }
    });
});
