document.addEventListener("DOMContentLoaded", function () {
    // Variables
    const listboxes = document.querySelectorAll(".custom-listbox")
    var roleInput = document.getElementById('roleInput')
    var contractTypeInput = document.getElementById('contractTypeInput')
    var specialtyInput = document.getElementById('specialtyInput')
    var roleInputEdit = document.getElementById('roleInputEdit');
    var contractTypeInputEdit = document.getElementById('contractTypeInputEdit');
    var specialtyInputEdit = document.getElementById('specialtyInputEdit');
    let openListbox = null

    // Custom Listbox
    listboxes.forEach(function (listbox) {
        handleListbox(listbox)
    });

    function handleListbox(listbox) {
        const listboxHeader = listbox.querySelector(".listbox-header")
        const optionsList = listbox.querySelector(".options")
        const arrowDown = listbox.querySelector(".arrow-down")
        const selectedOptionSpan = listbox.querySelector(".selected-option")

        listboxHeader.addEventListener("click", function () {
            if (openListbox && openListbox !== listbox) {
                openListbox.querySelector(".options").style.display = "none"
                openListbox.querySelector(".arrow-down").style.transform = "rotate(0deg)"
                openListbox.querySelector(".listbox-header").classList.remove("active")
            }

            listboxHeader.classList.toggle("active")
            optionsList.style.display = optionsList.style.display === "block" ? "none" : "block"
            arrowDown.style.transform = optionsList.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)"
            openListbox = listbox;
        });

        optionsList.addEventListener("click", function (event) {
            if (event.target.tagName === "LI") {
                const selectedOption = event.target.textContent
                selectedOptionSpan.textContent = selectedOption
                optionsList.style.display = "none"
                arrowDown.style.transform = "rotate(0deg)"
                listboxHeader.classList.remove("active")              
        
                // Asignar valor a los campos de entrada según el tipo de listbox
                if (listbox.classList.contains("role")) {
                    roleInput.value = selectedOptionSpan.textContent
                } else if(listbox.classList.contains("contract")) {
                    contractTypeInput.value = selectedOptionSpan.textContent
                } else if (listbox.classList.contains("specialty")) {
                    specialtyInput.value = selectedOptionSpan.textContent
                } else if (listbox.classList.contains("role-edit")) {
                    roleInputEdit.value = selectedOptionSpan.textContent
                } else if (listbox.classList.contains("contract-edit")) {
                    contractTypeInputEdit.value = selectedOptionSpan.textContent
                } else if (listbox.classList.contains("specialty-edit")) {
                    specialtyInputEdit.value = selectedOptionSpan.textContent
                }
        
                // Mostrar u ocultar los listbox según la opción seleccionada
                if ( selectedOption.trim() === 'Docente' ||
                    selectedOption.trim() === 'Coordinador' ||
                    listbox.classList.contains("contract") ||
                    listbox.classList.contains("specialty")
                ) {
                    document.querySelector('.lst-contract').removeAttribute("hidden")
                    document.querySelector('.lst-specialty').removeAttribute("hidden")
                } else {
                    // Ocultar todos los listbox
                    document.querySelector('.lst-contract').setAttribute("hidden", "false")
                    document.querySelector('.lst-specialty').setAttribute("hidden", "false")
                }
        
                markSelectedOption(event.target)
            }
        });

        // Función para agregar o quitar el ícono de verificación a la opción seleccionada
        function markSelectedOption(selectedListItem) {
            const options = optionsList.querySelectorAll("li")
            options.forEach(function (option) {
                option.classList.remove("selected")
                option.innerHTML = option.textContent // Limpiar el contenido HTML
            });

            selectedListItem.classList.add("selected")
            selectedListItem.innerHTML = '<i class="fa-solid fa-check"></i> ' + selectedListItem.textContent
        }
    }

    let addUserModal = document.getElementById('myModalUser')
    let btnAddUser = document.getElementById('btnAddUser')
    let cancel = document.querySelector('.cancel')

    btnAddUser.addEventListener('click', function () {
        openModal('myModalUser')
    });

    const cerrarModals = document.querySelectorAll('.cerrarModal')
    cerrarModals.forEach(function (cerrarModal) {
        cerrarModal.addEventListener('click', function(){
            const modalId = cerrarModal.closest('.modal').id
            
            closeModal(modalId)
        })
    });

    cancel.addEventListener('click', function () {
        closeModal('eliminarModal')
    });

    window.addEventListener('click', function (event) {
        if (event.target === addUserModal) {
            closeModal('myModalUser')
        }
    });

    // Obtener todos los botones con la clase 'button-edit' y 'button-delete'
    const buttons = document.querySelectorAll('.btn-edit, .btn-delete')

    // Asignar un evento de clic a cada botón
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal

            // Obtener datos del usuario desde los atributos data-*
            const userId = button.getAttribute('data-userId')
            const teacherId = button.getAttribute('data-teacherId')
            const userName = button.getAttribute('data-userName')
            const userEmail = button.getAttribute('data-userEmail')
            const userRole = button.getAttribute('data-userRole')
            const contractType = button.getAttribute('data-contractType')
            const specialty = button.getAttribute('data-specialty')

            // Llenar los campos del formulario dentro de la ventana modal
            const userIdInput = document.getElementById('userIdEdit')
            const teacherIdInput = document.getElementById('teacherIdEdit')
            const nameInput = document.getElementById('nameInput')
            const emailInput = document.getElementById('emailInput')
            const roleInput = document.getElementById('roleInputEdit')
            const IdInput = document.getElementById('idInputs')
            const roleSpanEdit = document.getElementById('roleSpanEdit')
            const contractTypeSpanEdit = document.getElementById('contractTypeSpanEdit')
            const specialtySpanEdit = document.getElementById('specialtySpanEdit')

            userIdInput.value = userId
            nameInput.value = userName
            emailInput.value = userEmail
            roleInput.value = userRole
            IdInput.value = userId

            roleSpanEdit.innerText = userRole

            if (userRole === 'Docente' || userRole === 'Coordinador') {
                document.querySelector('.lst-contract-edit').removeAttribute("hidden")
                document.querySelector('.lst-specialty-edit').removeAttribute("hidden")
                
                teacherIdInput.value = teacherId
                contractTypeInputEdit.value = contractType
                specialtyInputEdit.value = specialty
                contractTypeSpanEdit.innerText = contractType
                specialtySpanEdit.innerText = specialty

            } else {
                document.querySelector('.lst-contract-edit').setAttribute("hidden", "false")
                document.querySelector('.lst-specialty-edit').setAttribute("hidden", "false")
            }

            openModal(modalId)
        });
    });

    // Asignar un evento de clic a los elementos con la clase 'close'
    const closeButtons = document.querySelectorAll('.modal .close')
    closeButtons.forEach(function (closeButton) {
        closeButton.addEventListener('click', function () {
            const modalId = closeButton.closest('.modal').id

            // Limpiar los campos del formulario al cerrar la ventana modal
            const nameInput = document.getElementById('nameInput')
            const emailInput = document.getElementById('emailInput')
            const roleInput = document.getElementById('roleInput')

            nameInput.value = ''
            emailInput.value = ''
            roleInput.value = ''

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