document.addEventListener("DOMContentLoaded", function () {
    const listboxes = document.querySelectorAll(".custom-listbox")
    const idTeacher = document.getElementById('idTeacher')
    const subjectIdInput = document.getElementById('subjectId')
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

                if (listbox.classList.contains("teacher")) {
                    idTeacher.value = event.target.dataset.value
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

    let cerrarModals = document.querySelectorAll('.cerrarModal')

    cerrarModals.forEach(function(cerrarModal){
        cerrarModal.addEventListener('click', function () {
            const modalId = cerrarModal.closest('.modal').id

            closeModal(modalId)
        })
    })

    let btnAprovedSubjects = document.querySelectorAll('.btn-aproved-subject');
    btnAprovedSubjects.forEach(function (btnAprovedSubject) {
        btnAprovedSubject.addEventListener('click', function (event) {
            let subjectId = btnAprovedSubject.getAttribute('data-values');

            fetch(`http://localhost/SistemaIDC/public/subject/${subjectId}`)
                .then(function (response) {
                    return response.text();
                })
                .then(function (state) {
                    actualizarCamposFormulario(state, subjectId, btnAprovedSubject);
                })
                .catch(function (error) {
                    console.error('Error en la solicitud Fetch:', error);
                });
        });
    });

    function actualizarCamposFormulario(state, subjectId, btnAprovedSubject) {
        btnAprovedSubject.style.display = 'none';

        var stateField = document.getElementById(`state-subject-${subjectId}`);
        stateField.textContent = state;
        stateField.style.display = 'inline-block';
    }

    const buttons = document.querySelectorAll('.btn-edit, .btn-delete')
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal

            const career = button.getAttribute('data-nameCareer')
            const subjectId = button.getAttribute('data-subjectId')

            subjectIdInput.value = subjectId

            fetch(`getTeachers/${career}`)
                .then(function (response) {
                    return response.json()
                })
                .then(function (jsonData){
                    buildEnrolledSubjects(jsonData)
                })

            openModal(modalId)
        })
    })

    function buildEnrolledSubjects(jsonTeachers) {
        let ltTeachers = document.getElementById('lt-teachers')

        while (ltTeachers.firstChild) {
            ltTeachers.removeChild(ltTeachers.firstChild)
        }

        jsonTeachers.forEach(function (teacher) {
            let li = document.createElement('li')
            li.setAttribute('data-value', teacher.teacherId)
            li.innerText = teacher.name
    
            ltTeachers.append(li)
        })
    }

    const assignTeacher = document.getElementById('assignTeacher')    
    assignTeacher.addEventListener('submit', function (event) {
        const teacherSpan = document.getElementById('teacher').getAttribute('data-value')
        if (teacherSpan.trim() === 'Docente') {
            showNotification('Por favor, selecciona un Docente', true, '#notificationAS')
            event.preventDefault()
            return
        }
    })

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