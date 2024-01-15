document.addEventListener('DOMContentLoaded', function () {
    var avatarContainer = document.querySelector('.avatar-container');
    var avatarModal = document.getElementById('userModal');
    var modalVisible = false;

    avatarContainer.addEventListener('click', function (event) {
        event.stopPropagation();
        if (modalVisible) {
            avatarModal.style.display = 'none';
        } else {
            avatarModal.style.display = 'block';
        }
        modalVisible = !modalVisible;
    });

    // Obtener todos los enlaces dentro del modal
    var modalLinks = avatarModal.querySelectorAll('.enlace-div');

    // Agregar un evento de clic a cada enlace para cerrar el modal
    modalLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            avatarModal.style.display = 'none';
            modalVisible = false;
        });
    });

    document.addEventListener('click', function (event) {
        if (modalVisible && event.target !== avatarModal && !avatarModal.contains(event.target)) {
            avatarModal.style.display = 'none';
            modalVisible = false;
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modalVisible) {
            avatarModal.style.display = 'none';
            modalVisible = false;
        }
    });
});