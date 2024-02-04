document.addEventListener("DOMContentLoaded", function () {
    const listboxes = document.querySelectorAll(".custom-listbox")
    var roleInput = document.getElementById('roleInput')
    var contractTypeInput = document.getElementById('contractTypeInput')
    var specialtyInput = document.getElementById('specialtyInput')
    var roleInputEdit = document.getElementById('roleInputEdit')
    var contractTypeInputEdit = document.getElementById('contractTypeInputEdit')
    var specialtyInputEdit = document.getElementById('specialtyInputEdit')
    let openListbox = null

    listboxes.forEach(function (listbox) {
        handleListbox(listbox)
    })

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
            openListbox = listbox
        })

        optionsList.addEventListener("click", function (event) {
            if (event.target.tagName === "LI") {
                const selectedOption = event.target.textContent
                selectedOptionSpan.textContent = selectedOption
                selectedOptionSpan.setAttribute('data-value', selectedOptionSpan.textContent)
                optionsList.style.display = "none"
                arrowDown.style.transform = "rotate(0deg)"
                listboxHeader.classList.remove("active")              
        
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
        })

        function markSelectedOption(selectedListItem) {
            const options = optionsList.querySelectorAll("li")
            options.forEach(function (option) {
                option.classList.remove("selected")
                option.innerHTML = option.textContent
            })

            selectedListItem.classList.add("selected")
            selectedListItem.innerHTML = '<i class="fa-solid fa-check"></i> ' + selectedListItem.textContent
        }
    }

    let addUserModal = document.getElementById('myModalUser')
    let btnAddUser = document.getElementById('btnAddUser')
    let cancel = document.querySelector('.cancel')

    btnAddUser.addEventListener('click', function () {
        openModal('myModalUser')
    })

    const cerrarModals = document.querySelectorAll('.cerrarModal')
    cerrarModals.forEach(function (cerrarModal) {
        cerrarModal.addEventListener('click', function(){
            const modalId = cerrarModal.closest('.modal').id
            
            closeModal(modalId)
        })
    })

    cancel.addEventListener('click', function () {
        closeModal('eliminarModal')
    })

    window.addEventListener('click', function (event) {
        if (event.target === addUserModal) {
            closeModal('myModalUser')
        }
    })

    const searchInput = document.getElementById('searchInput')
    const userListbox = document.getElementById('userListbox')
    const tableRows = document.querySelectorAll('#data-table-users tbody tr')

    searchInput.addEventListener('input', filterTable)

    const optionsList = document.querySelector('.custom-listbox .options')
    if (optionsList) {
        optionsList.addEventListener('click', filterTable)
    } 

    function filterTable() {
        const searchText = searchInput.value.trim().toLowerCase();
        const selectedRol = userListbox.querySelector('.selected-option').textContent.trim().toLowerCase();
    
        tableRows.forEach(function(row) {
            const nameText = row.querySelector('td[data-values="Nombre"]').textContent.trim().toLowerCase();
            const emailText = row.querySelector('td[data-values="Correo"]').textContent.trim().toLowerCase();
            const roleText = row.querySelector('td[data-values="Rol"]').textContent.trim().toLowerCase();
    
            const containsSearchText = nameText.includes(searchText) || emailText.includes(searchText) || roleText.includes(searchText);
            const matchesSelectedRole = selectedRol === 'todos' || roleText === selectedRol;
    
            if (selectedRol === 'todos' || matchesSelectedRole) {
                row.style.display = containsSearchText ? '' : 'none';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    const formAddUser = document.getElementById('formAddUser')    
    formAddUser.addEventListener('submit', function (event) {
        const inputUsers = document.querySelectorAll("#formAddUser .input-user")
        for(const inputUser of inputUsers) {
            if (inputUser.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${inputUser.placeholder}"`, true, '#notificationU')
                event.preventDefault()
                return
            }
        }

        const emailInput = document.getElementById('emailInput');
        const emailValue = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(emailValue)) {
            showNotification('Por favor, ingresa un correo electrónico válido', true, '#notificationU');
            event.preventDefault();
            return;
        }

        if (!emailValue.endsWith('@catolica.edu.sv')) {
            showNotification('Por favor, ingresa un correo electrónico con la extensión "@catolica.edu.sv"', true, '#notificationU');
            event.preventDefault();
            return;
        }

        const roleSpan = document.getElementById('role').getAttribute('data-value')
        if (roleSpan.trim() === 'Rol') {
            showNotification('Por favor, selecciona un Rol', true, '#notificationU')
            event.preventDefault()
            return
        }
    
        if (roleSpan === 'Docente' || roleSpan === 'Coordinador') {
            const contractType = document.getElementById('contractType').getAttribute('data-value').trim();
            const specialty = document.getElementById('specialty').getAttribute('data-value').trim();
    
            if (contractType.trim() === 'Tipo de contrato') {
                showNotification('Por favor, selecciona un Tipo de Contrato', true, '#notificationU');
                event.preventDefault();
                return;
            }
    
            if (specialty.trim() === 'Especialidad') {
                showNotification('Por favor, selecciona una Especialidad', true, '#notificationU');
                event.preventDefault();
                return;
            }
        }
    })

    const formEditUser = document.getElementById('formEditUser')    
    formEditUser.addEventListener('submit', function (event) {
        const inputUsers = document.querySelectorAll("#formEditUser .input-user")
        for(const inputUser of inputUsers) {
            if (inputUser.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${inputUser.placeholder}"`, true, '#notificationUE')
                event.preventDefault()
                return
            }
        }

        const emailInput = document.getElementById('emailEditInput');
        const emailValue = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(emailValue)) {
            showNotification('Por favor, ingresa un correo electrónico válido', true, '#notificationUE');
            event.preventDefault();
            return;
        }

        if (!emailValue.endsWith('@catolica.edu.sv')) {
            showNotification('Por favor, ingresa un correo electrónico con la extensión "@catolica.edu.sv"', true, '#notificationUE');
            event.preventDefault();
            return;
        }
    })

    const buttons = document.querySelectorAll('.btn-edit, .btn-delete')
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal

            const userId = button.getAttribute('data-userId')
            const teacherId = button.getAttribute('data-teacherId')
            const userName = button.getAttribute('data-userName')
            const userEmail = button.getAttribute('data-userEmail')
            const userRole = button.getAttribute('data-userRole')
            const contractType = button.getAttribute('data-contractType')
            const specialty = button.getAttribute('data-specialty')

            const userIdInput = document.getElementById('userIdEdit')
            const teacherIdInput = document.getElementById('teacherIdEdit')
            const nameInput = document.getElementById('nameEditInput')
            const emailInput = document.getElementById('emailEditInput')
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
                document.querySelector('.lst-role-edit').setAttribute("hidden", "false")
                document.querySelector('.lst-contract-edit').setAttribute("hidden", "false")
                document.querySelector('.lst-specialty-edit').setAttribute("hidden", "false")
            }

            openModal(modalId)
        })
    })

    const closeButtons = document.querySelectorAll('.modal .close')
    closeButtons.forEach(function (closeButton) {
        closeButton.addEventListener('click', function () {
            const modalId = closeButton.closest('.modal').id

            const nameInput = document.getElementById('nameInput')
            const emailInput = document.getElementById('emailInput')
            const roleInput = document.getElementById('roleInput')

            nameInput.value = ''
            emailInput.value = ''
            roleInput.value = ''

            closeModal(modalId)
        })
    })

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