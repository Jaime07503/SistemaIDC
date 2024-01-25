document.addEventListener("DOMContentLoaded", function () {
    let addFacultyModal = document.getElementById('myModalFaculty')
    let btnAddFaculty = document.getElementById('btnAddFaculty')
    let cerrarModals = document.querySelectorAll('.cerrarModal')
    let cancel = document.querySelector('.cancel')

    btnAddFaculty.addEventListener('click', function () {
        openModal('myModalFaculty');
    });

    cerrarModals.forEach(function(cerrarModal){
        cerrarModal.addEventListener('click', function () {
            const modalId = cerrarModal.closest('.modal').id

            closeModal(modalId);
        });
    })

    cancel.addEventListener('click', function () {
        closeModal('eliminarModal')
    });

    window.addEventListener('click', function (event) {
        if (event.target === addFacultyModal) {
            closeModal('myModalFaculty')
        }
    });

    // Obtener todos los botones con la clase 'button-edit' y 'button-delete'
    const buttons = document.querySelectorAll('.btn-edit, .btn-delete')

    // Asignar un evento de clic a cada botón
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal

            // Obtener datos del usuario desde los atributos data-
            const facultyId = button.getAttribute('data-facultyId')
            const nameFaculty = button.getAttribute('data-nameFaculty')

            // Llenar los campos del formulario dentro de la ventana modal
            const facultyIdInput = document.getElementById('facultyId')
            const facultyIdEditInput = document.getElementById('facultyEditId')
            const nameFacultyInput = document.getElementById('nameFaculty')

            facultyIdInput.value = facultyId
            facultyIdEditInput.value = facultyId
            nameFacultyInput.value = nameFaculty

            openModal(modalId)
        })
    })

    // Asignar un evento de clic a los elementos con la clase 'close'
    const closeButtons = document.querySelectorAll('.modal .close')
    closeButtons.forEach(function (closeButton) {
        closeButton.addEventListener('click', function () {
            const modalId = closeButton.closest('.modal').id

            // Limpiar los campos del formulario al cerrar la ventana modal
            //const nameInput = document.getElementById('nameInput')
            //const emailInput = document.getElementById('emailInput')
            //const roleInput = document.getElementById('roleInput')

            //nameInput.value = ''
            //emailInput.value = ''
            //roleInput.value = ''

            closeModal(modalId)
        });
    });

    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block'
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none'
    }
});
