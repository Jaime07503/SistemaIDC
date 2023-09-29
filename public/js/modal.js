document.addEventListener('DOMContentLoaded', function () {
    // Obtén el elemento del div avatar-container y el modal
    var avatarContainer = document.querySelector('.avatar-container');
    var avatarModal = document.getElementById('avatarModal');

    avatarContainer.addEventListener('click', function () {
        console.log('Clic en avatarContainer'); // Agrega este mensaje de registro
        avatarModal.style.display = 'block';
    });

    // Cuando se hace clic en el div avatar-container, muestra el modal
    avatarContainer.addEventListener('click', function () {
        avatarModal.style.display = 'block';
    });

    // Cuando se hace clic en el botón de cierre del modal, cierra el modal
    var cerrarAvatarModal = document.getElementById('avatarModal');
    cerrarAvatarModal.addEventListener('click', function () {
        avatarModal.style.display = 'none';
    });

    // Cuando se hace clic fuera del modal, cierra el modal
    window.addEventListener('click', function (event) {
        if (event.target == avatarModal) {
            avatarModal.style.display = 'none';
        }
    });

    // Evento para cerrar el modal si se presiona la tecla Escape
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && avatarModal.style.display === 'block') {
            avatarModal.style.display = 'none';
        }
    });
});