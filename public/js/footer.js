document.addEventListener("DOMContentLoaded", function(){
    const buttons = document.querySelectorAll('.button');
    buttons.forEach(button => {
        const span = button.querySelector('span');
        const url = button.getAttribute('data-url');

        span.addEventListener('click', () => {
            // Redirige al usuario a la URL asociada al botón
            window.location.href = url;
        });
    });
});