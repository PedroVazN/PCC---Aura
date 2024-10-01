const toggleButton = document.getElementById('toggleForm');
        const loginForm = document.querySelector('.login');
        const registerForm = document.querySelector('.registro');

        toggleButton.addEventListener('click', function() {
            if (registerForm.style.display === 'none') {
                registerForm.style.display = 'block';
                loginForm.style.display = 'none';
                toggleButton.textContent = 'Login';
            } else {
                registerForm.style.display = 'none';
                loginForm.style.display = 'block';
                toggleButton.textContent = 'Registrar-se';
            }
        });