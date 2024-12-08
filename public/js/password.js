document.addEventListener('DOMContentLoaded', function() {
    var password = document.getElementById('password');
    var confirmPassword = document.getElementById('confirmPassword');
    var message = document.getElementById('message');
    var form = document.getElementById('form');

    function validatePassword() {
        if (password.value === confirmPassword.value) {
            message.textContent = 'パスワードが一致しています。';
            message.style.color = 'black';
            message.className = 'success';
        } else if (password.value === '' || confirmPassword.value === '') {
            message.textContent = '';
            message.className = '';
        } else {
            message.textContent = 'パスワードが一致していません。';
            message.style.color = 'red';
            message.className = 'error';
        }
    }

    password.addEventListener('input', validatePassword);
    confirmPassword.addEventListener('input', validatePassword);

    form.addEventListener('submit', function(event) {
        if (password.value !== confirmPassword.value) {
            event.preventDefault();
            alert('パスワードが一致していません。');
        }
    });

    form.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
        }
    });
});