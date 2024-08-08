window.addEventListener('DOMContentLoaded', (event) => {
    const inputs = document.querySelectorAll('.label-container input');

    inputs.forEach(input => {
        const label = input.nextElementSibling;

        const updateLabel = () => {
            if (input !== document.activeElement && input.value === '') {

                label.style.top = '50%';
                label.style.left = '50%';
                label.style.transform = 'translate(-50%, -50%)';
                label.style.transition = 'all 0.1s ease-in-out';
                label.style.color = '#a5a5a5';
                label.style.cursor = 'text';
            } else if (input === document.activeElement) {

                label.style.top = '-15%';
                label.style.left = '50%';
                label.style.transform = 'translate(-50%, -50%)';
                label.style.transition = '0.2s ease-in-out';
                label.style.color = 'var(--light-global-color)';
                label.style.cursor = 'default';
            } else if (input.value !== '') {

                label.style.top = '-15%';
                label.style.left = '50%';
                label.style.transform = 'translate(-50%, -50%)';
                label.style.transition = '0.2s ease-in-out';
                label.style.color = '#a5a5a5';
                label.style.cursor = 'default';
            }
        };

        input.addEventListener('focus', updateLabel);
        input.addEventListener('blur', updateLabel);
        input.addEventListener('input', updateLabel);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var email = document.getElementById('email');
    var senha = document.getElementById('senha');
    var submit = document.getElementById('submit');

    function checkInput() {
        if (email.value && senha.value) {
            submit.classList.remove('blocked');
        } else {
            submit.classList.add('blocked');
        }
    }

    email.addEventListener('input', checkInput);
    senha.addEventListener('input', checkInput);

    checkInput();
});