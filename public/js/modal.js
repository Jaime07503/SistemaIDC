document.addEventListener('DOMContentLoaded', function () {
    var avatarContainer = document.querySelector('.avatar-container')
    var avatarModal = document.getElementById('userModal')
    var notificationUser = document.querySelector('.ic_notificaciones')
    var notificationModal = document.getElementById('notificationModal')
    var modalUserVisible = false
    var modalNotificationVisible = false

    function cerrarTodasModales() {
        avatarModal.style.display = 'none'
        notificationModal.style.display = 'none'
        modalUserVisible = false
        modalNotificationVisible = false
    }

    avatarContainer.addEventListener('click', function (event) {
        event.stopPropagation()
        if (modalUserVisible) {
            cerrarTodasModales()
        } else {
            cerrarTodasModales()
            avatarModal.style.display = 'block'
            modalUserVisible = true
        }
    })

    notificationUser.addEventListener('click', function (event) {
        event.stopPropagation()
        if (modalNotificationVisible) {
            cerrarTodasModales()
        } else {
            cerrarTodasModales()
            notificationModal.style.display = 'block'
            modalNotificationVisible = true
        }
    })

    var modalLinks = avatarModal.querySelectorAll('.enlace-div')
    modalLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            cerrarTodasModales()
        })
    })

    document.addEventListener('click', function (event) {
        if ((modalUserVisible || modalNotificationVisible) && event.target !== avatarModal && !avatarModal.contains(event.target) 
        && event.target !== notificationModal && !notificationModal.contains(event.target)) {
            cerrarTodasModales()
        }
    })

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && (modalUserVisible || modalNotificationVisible)) {
            cerrarTodasModales()
        }
    })
})