document.addEventListener("DOMContentLoaded", function () {
    const listboxes = document.querySelectorAll(".custom-listbox")
    let openListbox = null
    const nameFacultyInput = document.querySelector('.nameFaculty')

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
                var facultyId = event.target.getAttribute('data-value')
                nameFacultyInput.value = facultyId
                markSelectedOption(event.target)

                if(listbox.classList.contains("faculty-lst")){
                    const idFaculty = document.querySelector('.idFaculty')
                    idFaculty.value = facultyId
                }
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
    let cerrarModals = document.querySelectorAll('.cerrarModal')
    let cancel = document.querySelector('.cancel')

    btnAddUser.addEventListener('click', function () {
        openModal('myModalUser')
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
        if (event.target === addUserModal) {
            closeModal('myModalUser')
        }
    })

    const searchInput = document.getElementById('searchInput')
    const facultyListbox = document.getElementById('facultyListbox')
    const tableRows = document.querySelectorAll('#data-table-careers tbody tr')

    searchInput.addEventListener('input', filterTable)

    const optionsList = document.querySelector('.custom-listbox .options')
    if (optionsList) {
        optionsList.addEventListener('click', filterTable)
    } 

    function filterTable() {
        const searchText = searchInput.value.trim().toLowerCase()
        const selectedFaculty = facultyListbox.querySelector('.selected-option').textContent.trim().toLowerCase()

        tableRows.forEach(function(row) {
            const careerText = row.querySelector('td[data-values="Carrera"]').textContent.trim().toLowerCase()
            const facultyText = row.querySelector('td[data-values="Facultad"]').textContent.trim().toLowerCase()

            const containsSearchText = careerText.includes(searchText) || facultyText.includes(searchText)
            const matchesSelectedFaculty = selectedFaculty === 'Todos' || facultyText === selectedFaculty

            if (selectedFaculty === 'Todos' || matchesSelectedFaculty) {
                row.style.display = containsSearchText ? '' : 'none'
            } else {
                row.style.display = 'none'
            }
        })
    }

    const formAddCareer = document.getElementById('formAddCareer')    
    formAddCareer.addEventListener('submit', function (event) {
        const inputCycles = document.querySelectorAll("#formAddCareer .input-career")
        for(const inputCycle of inputCycles) {
            if (inputCycle.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${inputCycle.placeholder}"`, true, '#notificationC')
                event.preventDefault()
                return
            }
        }

        const facultySpan = document.getElementById('faculty').getAttribute('data-value')
        if (facultySpan.trim() === 'Facultad') {
            showNotification('Por favor, selecciona una Facultad', true, '#notificationC')
            event.preventDefault()
            return
        }
    })

    const formEditCareer = document.getElementById('formEditCareer')    
    formEditCareer.addEventListener('submit', function (event) {
        const inputCycles = document.querySelectorAll("#formEditCareer .input-career")
        for(const inputCycle of inputCycles) {
            if (inputCycle.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${inputCycle.placeholder}"`, true, '#notificationCE')
                event.preventDefault()
                return
            }
        }
    })

    const buttons = document.querySelectorAll('.btn-edit, .btn-delete')
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal

            const nameCareer = button.getAttribute('data-nameCareer')
            const nameFaculty = button.getAttribute('data-nameFaculty')
            const careerId = button.getAttribute('data-careerId')
            const spanFaculty = document.querySelector('.faculty')
            const idFaculty = button.getAttribute('data-idFaculty')
            const careerIdInput = document.querySelector('.careerId')
            const careerInput = document.getElementById('idInputs')

            const nameCareerInput = document.getElementById('nameCareerEditInput')

            nameCareerInput.value = nameCareer
            spanFaculty.innerHTML = nameFaculty
            nameFacultyInput.value = idFaculty
            careerIdInput.value = careerId
            careerInput.value = careerId

            openModal(modalId)
        })
    })

    const closeButtons = document.querySelectorAll('.modal .close')
    closeButtons.forEach(function (closeButton) {
        closeButton.addEventListener('click', function () {
            const modalId = closeButton.closest('.modal').id

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