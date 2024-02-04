document.addEventListener("DOMContentLoaded", function () {
    const listboxes = document.querySelectorAll(".custom-listbox")
    let openListbox = null
    var stateInput = document.getElementById('stateInput')
    var stateInputEdit = document.getElementById('stateInputEdit')

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
                const selectedValue = event.target.dataset.value
                selectedOptionSpan.textContent = selectedOption
                selectedOptionSpan.setAttribute('data-value', selectedValue)
                optionsList.style.display = "none"
                arrowDown.style.transform = "rotate(0deg)"
                listboxHeader.classList.remove("active")
        
                if (listbox.classList.contains("state")) {
                    stateInput.value = selectedOptionSpan.textContent
                    stateInput.setAttribute('data-value', selectedValue)
                } else if (listbox.classList.contains("state-edit")) {
                    stateInputEdit.value = selectedOptionSpan.textContent
                    stateInputEdit.setAttribute('data-value', selectedValue)
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

    const searchInput = document.getElementById('searchInput')
    const tableRows = document.querySelectorAll('#data-table-cycle tbody tr')

    searchInput.addEventListener('input', function () {
        const searchText = searchInput.value.trim().toLowerCase()

        tableRows.forEach(function (row) {
            const cycleText = row.querySelector('td[data-values="Ciclo"]').textContent.trim().toLowerCase()
            const stateText = row.querySelector('td[data-values="Estado"]').textContent.trim().toLowerCase()
            const containsSearchText = cycleText.includes(searchText) || stateText.includes(searchText)

            row.style.display = containsSearchText ? '' : 'none'
        })
    })

    let addCycleModal = document.getElementById('myModalCycle')
    let btnAddCycle = document.getElementById('btnAddCycle')
    let cerrarModals = document.querySelectorAll('.cerrarModal')
    let cancel = document.querySelector('.cancel')

    btnAddCycle.addEventListener('click', function () {
        openModal('myModalCycle')
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
        if (event.target === addCycleModal) {
            closeModal('myModalCycle')
        }
    })

    const formAddCycle = document.getElementById('formAddCycle')    
    formAddCycle.addEventListener('submit', function (event) {
        const inputCycles = document.querySelectorAll("#formAddCycle .input-cycle")
        for(const inputCycle of inputCycles) {
            if (inputCycle.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${inputCycle.placeholder}"`, true, '#notificationC')
                event.preventDefault()
                return
            }
        }

        const stateSpan = document.getElementById('state').getAttribute('data-value')
        if (stateSpan.trim() === 'Estado') {
            showNotification('Por favor, selecciona un Estado', true, '#notificationC')
            event.preventDefault()
            return
        }
    })

    const formEditCycle = document.getElementById('formEditCycle')    
    formEditCycle.addEventListener('submit', function (event) {
        const inputCycles = document.querySelectorAll("#formEditCycle .input-cycle")
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

            const cycleId = button.getAttribute('data-cycleId')
            const nameCycle = button.getAttribute('data-nameCycle')
            const state = button.getAttribute('data-state')

            const cycleIdInput = document.getElementById('cycleId')
            const cycleIdEditInput = document.getElementById('cycleEditId')
            const nameCycleInput = document.getElementById('nameCycle')
            const stateSpan = document.getElementById('spanStateEdit')

            cycleIdInput.value = cycleId
            cycleIdEditInput.value = cycleId
            nameCycleInput.value = nameCycle
            stateSpan.innerText = state
            stateInputEdit.value = state

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