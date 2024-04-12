document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('form');
    const usernameInput = document.querySelector('input[name="username"]');
    const passwordInput = document.querySelector('input[name="password"]');

    loginForm.addEventListener('submit', function (event) {
        
        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();

        
        if (!username || !password) {
            event.preventDefault(); 
            alert('Please enter both a username and password.');
        }
    });
});
