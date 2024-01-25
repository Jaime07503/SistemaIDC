document.addEventListener('DOMContentLoaded', function () {
    var avatarContainer = document.querySelector('.avatar-container');
    var avatarModal = document.getElementById('userModal');
    var notificationUser = document.querySelector('.ic_notificaciones');
    var notificationModal = document.getElementById('notificationModal');
    var modalUserVisible = false;
    var modalNotificationVisible = false;

    // Función para cerrar todas las modales
    function cerrarTodasModales() {
        avatarModal.style.display = 'none';
        notificationModal.style.display = 'none';
        modalUserVisible = false;
        modalNotificationVisible = false;
    }

    avatarContainer.addEventListener('click', function (event) {
        event.stopPropagation();
        cerrarTodasModales();
        avatarModal.style.display = 'block';
        modalUserVisible = true;
    });

    notificationUser.addEventListener('click', function (event) {
        event.stopPropagation();
        cerrarTodasModales();
        notificationModal.style.display = 'block';
        modalNotificationVisible = true;
    });

    // Obtener todos los enlaces dentro del modal
    var modalLinks = avatarModal.querySelectorAll('.enlace-div');

    // Agregar un evento de clic a cada enlace para cerrar el modal
    modalLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            cerrarTodasModales();
        });
    });

    // Cerrar modal al hacer clic fuera del modal
    document.addEventListener('click', function (event) {
        if ((modalUserVisible || modalNotificationVisible) && 
            event.target !== avatarModal && !avatarModal.contains(event.target) &&
            event.target !== notificationModal && !notificationModal.contains(event.target)) {
            cerrarTodasModales();
        }
    });

    // Cerrar modal al presionar la tecla Escape
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && (modalUserVisible || modalNotificationVisible)) {
            cerrarTodasModales();
        }
    });
});