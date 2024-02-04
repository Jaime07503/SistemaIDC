document.addEventListener("DOMContentLoaded", function () {
    let addFacultyModal = document.getElementById('myModalFaculty')
    let btnAddFaculty = document.getElementById('btnAddFaculty')
    let cerrarModals = document.querySelectorAll('.cerrarModal')
    let cancel = document.querySelector('.cancel')

    btnAddFaculty.addEventListener('click', function () {
        openModal('myModalFaculty')
    })

    cerrarModals.forEach(function(cerrarModal){
        cerrarModal.addEventListener('click', function () {
            const modalId = cerrarModal.closest('.modal').id

            closeModal(modalId)
        })
    })

    cancel.addEventListener('click', function () {
        closeModal('eliminarModal')
    })

    window.addEventListener('click', function (event) {
        if (event.target === addFacultyModal) {
            closeModal('myModalFaculty')
        }
    })

    const searchInput = document.getElementById('searchInput')
    const tableRows = document.querySelectorAll('#data-table-faculty tbody tr')

    searchInput.addEventListener('input', function () {
        const searchText = searchInput.value.trim().toLowerCase()

        tableRows.forEach(function (row) {
            const facultyText = row.querySelector('td[data-values="Facultad"]').textContent.trim().toLowerCase()
            const containsSearchText = facultyText.includes(searchText)

            row.style.display = containsSearchText ? '' : 'none'
        })
    })

    const formAddFaculty = document.getElementById('formAddFaculty')    
    formAddFaculty.addEventListener('submit', function (event) {
        const inputCycles = document.querySelectorAll("#formAddFaculty .input-faculty")
        for(const inputCycle of inputCycles) {
            if (inputCycle.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${inputCycle.placeholder}"`, true, '#notificationF')
                event.preventDefault()
                return
            }
        }
    })

    const formEditFaculty = document.getElementById('formEditFaculty')    
    formEditFaculty.addEventListener('submit', function (event) {
        const inputCycles = document.querySelectorAll("#formEditFaculty .input-faculty")
        for(const inputCycle of inputCycles) {
            if (inputCycle.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${inputCycle.placeholder}"`, true, '#notificationFE')
                event.preventDefault()
                return
            }
        }
    })

    const buttons = document.querySelectorAll('.btn-edit, .btn-delete')
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal

            const facultyId = button.getAttribute('data-facultyId')
            const nameFaculty = button.getAttribute('data-nameFaculty')

            const facultyIdInput = document.getElementById('facultyId')
            const facultyIdEditInput = document.getElementById('facultyEditId')
            const nameFacultyInput = document.getElementById('nameFaculty')

            facultyIdInput.value = facultyId
            facultyIdEditInput.value = facultyId
            nameFacultyInput.value = nameFaculty

            openModal(modalId)
        })
    })

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

    function showNotification(message, isError = false, notificationId) {
        const notification = document.querySelector(notificationId)
    
        if (notification) {
            notification.textContent = message
            notification.className = isError ? 'notificationM error' : 'notificationM'
            notification.style.display = 'block'
    
            setTimeout(function () {
                notification.style.display = 'none'
            }, 3000)
        }
    }

    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block'
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none'
    }
})