document.addEventListener("DOMContentLoaded", function () {
    const listboxes = document.querySelectorAll(".custom-listbox")
    var cycleInput = document.getElementById('cycleIdInput')
    var careerInput = document.getElementById('careerIdInput')
    var stateInput = document.getElementById('stateInput')
    var estadoInput = document.getElementById('estadoInput')
    var cicloInput = document.getElementById('cicloIdInput')
    var carreraInput = document.getElementById('carreraIdInput')
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
                optionsList.style.display = "none"
                arrowDown.style.transform = "rotate(0deg)"
                listboxHeader.classList.remove("active")
                var Id = event.target.getAttribute('data-value')
                
                if (listbox.classList.contains("cycle")) {
                    cycleInput.value = Id
                } else if(listbox.classList.contains("career")) {
                    careerInput.value = Id
                } else if(listbox.classList.contains("state")) {
                    stateInput.value = selectedOptionSpan.textContent
                } else if(listbox.classList.contains("stateEdit")) {
                    estadoInput.value = selectedOptionSpan.textContent
                } else if(listbox.classList.contains("cycleEdit")) {
                    cicloInput.value = Id
                } else if(listbox.classList.contains("careerEdit")) {
                    carreraInput.value = Id
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

    const fileContainers = document.querySelectorAll('.file-container')
    fileContainers.forEach(function(fileContainer) {
        const inputFile = fileContainer.querySelector('.file-input')
        const imgArea = fileContainer.querySelector('.img-area')
        const uploadedImage = fileContainer.querySelector('img')

        fileContainer.addEventListener('click', function () {
            inputFile.click()
        })

        inputFile.addEventListener('change', function () {
            const image = this.files[0]

            if (image) {
                if (image.size < 2000000) {
                    const reader = new FileReader()

                    reader.onload = () => {
                        uploadedImage.src = reader.result
                        uploadedImage.style.display = 'block'
                        imgArea.classList.add('active')
                        imgArea.dataset.img = image.name
                    }

                    reader.readAsDataURL(image)
                } else {
                    clearFileInput(inputFile)
                }
            } else {
                uploadedImage.src = ''
                uploadedImage.style.display = 'none'
                imgArea.classList.remove('active')
                imgArea.dataset.img = ''
            }
        })
    })

    function clearFileInput(input) {
        try {
            input.value = ''
        } catch (e) {
            const newInput = document.createElement('input')
            newInput.type = 'file'
            newInput.className = input.className
            newInput.style.cssText = input.style.cssText
            newInput.hidden = true
            newInput.addEventListener('change', input.onchange)
            input.parentNode.replaceChild(newInput, input)
        }
    }

    let addCareerModal = document.getElementById('myModalCareer')
    let btnAddCareer = document.getElementById('btnAddCareer')
    let cancel = document.querySelector('.cancel')

    btnAddCareer.addEventListener('click', function () {
        openModal('myModalCareer')
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
        if (event.target === addCareerModal) {
            closeModal('myModalCareer')
        }
    })

    const formAddCareer = document.getElementById('formAddCareer')
    formAddCareer.addEventListener('submit', function (event) {
        const inputs = document.querySelectorAll("#formAddCareer .input-add-subject")
        for (const input of inputs) {
            const trimmedValue = input.value.trim()

            if (trimmedValue === '') {
                showNotification(`Por favor, completa el campo "${input.placeholder}"`, true, '#notificationS')
                event.preventDefault()
                return
            }
        }

        Promise.all([validarImagenWrapper('Avatar-Materia')])
            .catch(error => {
                showNotification(`${error.message} en el campo "${error.inputName}"`, true, '#notificationS')
            })

        const state = document.querySelector('.state .selected-option').textContent.trim()
        const cycle = document.querySelector('.cycle .selected-option').textContent.trim()
        const career = document.querySelector('.career .selected-option').textContent.trim()

        if (state === "Estado") {
            showNotification("Por favor, selecciona un Estado.", true, '#notificationS')
            event.preventDefault()
            return
        } else if (cycle === "Ciclo") {
            showNotification("Por favor, selecciona un Ciclo.", true, '#notificationS')
            event.preventDefault()
            return
        } else if ( career === "Carrera"){
            showNotification("Por favor, selecciona una Carrera.", true, '#notificationS')
            event.preventDefault()
            return
        }
    })

    async function validarImagenWrapper(inputName) {
        try {
            await validarImagen(inputName)
        } catch (error) {
            error.inputName = inputName
            throw error
        }
    }
    
    function validarImagen(inputName) {
        return new Promise((resolve, reject) => {
            var fileInput = document.getElementsByName(inputName)[0]
    
            if (fileInput && fileInput.files.length > 0) {
                var file = fileInput.files[0]
    
                var reader = new FileReader()
                reader.onload = function (e) {
                    resolve()
                }
                reader.readAsDataURL(file)
            } else {
                reject({ message: 'Por favor, selecciona una imagen', inputName: inputName })
            }
        })
    }

    const searchInput = document.getElementById('searchInput')
    const userListbox = document.getElementById('subjectListbox')
    const tableRows = document.querySelectorAll('#data-table-subjects tbody tr')

    searchInput.addEventListener('input', filterFirstTable)

    const optionsList = document.querySelector('.lt-subject .options')
    if (optionsList) {
        optionsList.addEventListener('click', filterFirstTable)
    } 

    function filterFirstTable() {
        const searchText = searchInput.value.trim().toLowerCase()
        const selectedCareer = userListbox.querySelector('.selected-option').textContent.trim().toLowerCase()
    
        tableRows.forEach(function(row) {
            const nameText = row.querySelector('td[data-values="Nombre"]').textContent.trim().toLowerCase()
            const careerText = row.querySelector('td[data-values="Carrera"]').textContent.trim().toLowerCase()
            const cycleText = row.querySelector('td[data-values="Ciclo"]').textContent.trim().toLowerCase()
    
            const containsSearchText = nameText.includes(searchText) || careerText.includes(searchText) || cycleText.includes(searchText)
            const matchesSelectedCareer = selectedCareer === 'todos' || careerText === selectedCareer
    
            if (selectedCareer === 'todos' || matchesSelectedCareer) {
                row.style.display = containsSearchText ? '' : 'none'
            } else {
                row.style.display = 'none'
            }
        })
    }

    const searchInputA = document.getElementById('searchInputA')
    const subjectListboxA = document.getElementById('subjectListboxA')
    const tableRowsA = document.querySelectorAll('#data-table-assignSubjects tbody tr')

    searchInputA.addEventListener('input', filterSecondTable)

    const optionsListA = document.querySelector('.lt-subject2 .options')
    if (optionsListA) {
        optionsListA.addEventListener('click', filterSecondTable)
    } 

    function filterSecondTable() {
        const searchText = searchInputA.value.trim().toLowerCase()
        const selectedCareer = subjectListboxA.querySelector('.selected-option').textContent.trim().toLowerCase()
    
        tableRowsA.forEach(function(row) {
            const nameText = row.querySelector('td[data-values="Nombre"]').textContent.trim().toLowerCase()
            const careerText = row.querySelector('td[data-values="Carrera"]').textContent.trim().toLowerCase()
            const cycleText = row.querySelector('td[data-values="Ciclo"]').textContent.trim().toLowerCase()
    
            const containsSearchText = nameText.includes(searchText) || careerText.includes(searchText) || cycleText.includes(searchText)
            const matchesSelectedCareer = selectedCareer === 'todos' || careerText === selectedCareer
    
            if (selectedCareer === 'todos' || matchesSelectedCareer) {
                row.style.display = containsSearchText ? '' : 'none'
            } else {
                row.style.display = 'none'
            }
        })
    }

    const formEditSubject = document.getElementById('formEditSubject')
    formEditSubject.addEventListener('submit', function (event) {
        const inputs = document.querySelectorAll("#formEditSubject .input-edit-subject")
        for (const input of inputs) {
            const trimmedValue = input.value.trim()

            if (trimmedValue === '') {
                showNotification(`Por favor, completa el campo "${input.placeholder}"`, true, '#notificationSE')
                event.preventDefault()
                return
            }
        }
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

    const buttons = document.querySelectorAll('.btn-edit, .btn-delete')
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal

            const subjectId = button.getAttribute('data-subjectId')
            const nameSubject = button.getAttribute('data-nameSubject')
            const code = button.getAttribute('data-code')
            const section = button.getAttribute('data-section')
            const avatar = button.getAttribute('data-avatar')
            const state = button.getAttribute('data-state')
            const cycleId = button.getAttribute('data-cycleId')
            const cycle = button.getAttribute('data-cycle')
            const careerId = button.getAttribute('data-careerId')
            const nameCareer = button.getAttribute('data-nameCareer')

            const subjectIdInput = document.getElementById('materiaId')
            const subjectIdEInput = document.getElementById('subjectId')
            const nameSubjectInput = document.getElementById('materiaInput')
            const codeInput = document.getElementById('codigoInput')
            const sectionInput = document.getElementById('seccionInput')
            const avatarInput = document.querySelector('.uploaded-image-a')
            const avatarInputFile = document.querySelector('#formEditSubject .file-input')
            const stateSpanInput = document.getElementById('stateSpanEdit')
            const estadoEInput = document.getElementById('estadoInput')
            const cycleIdInput = document.getElementById('cicloIdInput')
            const cycleSpanEdit = document.getElementById('cycleSpanEdit')
            const careerIdInput = document.getElementById('carreraIdInput')
            const careerSpanEdit = document.getElementById('careerSpanEdit')

            subjectIdInput.value = subjectId
            subjectIdEInput.value = subjectId
            nameSubjectInput.value = nameSubject
            codeInput.value = code
            sectionInput.value = section
            avatarInput.src = avatar
            avatarInput.style.display = 'block'
            avatarInputFile.value = ''
            stateSpanInput.innerText = state
            estadoEInput.value = state
            cycleIdInput.value = cycleId
            cycleSpanEdit.innerText = cycle
            careerIdInput.value = careerId
            careerSpanEdit.innerText = nameCareer

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

    var sectionInput = document.getElementById('sectionInput')
    sectionInput.addEventListener('input', function() {
        var inputValue = this.value
        
        var sanitizedValue = inputValue.replace(/[^A-Z]/g, '')
        
        this.value = sanitizedValue
    })

    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block'
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none'
    }
})