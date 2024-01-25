document.addEventListener("DOMContentLoaded", function () {
    // Variables
    const listboxes = document.querySelectorAll(".custom-listbox")
    var cycleInput = document.getElementById('cycleInput')
    var careerInput = document.getElementById('careerInput')
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
                var Id = event.target.getAttribute('data-value');  
                
                if (listbox.classList.contains("cycle")) {
                    cycleInput.value = Id;
                } else if(listbox.classList.contains("career")) {
                    careerInput.value = Id;
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

    const fileContainers = document.querySelectorAll('.file-container');
    fileContainers.forEach(function(fileContainer) {
        const inputFile = fileContainer.querySelector('.file-input');
        const imgArea = fileContainer.querySelector('.img-area');
        const uploadedImage = fileContainer.querySelector('#uploadedImage');

        fileContainer.addEventListener('click', function () {
            inputFile.click();
        });

        inputFile.addEventListener('change', function () {
            const image = this.files[0];

            if (image) {
                if (image.size < 2000000) {
                    const reader = new FileReader();

                    reader.onload = () => {
                        uploadedImage.src = reader.result;
                        uploadedImage.style.display = 'block';
                        imgArea.classList.add('active');
                        imgArea.dataset.img = image.name;
                    };

                    reader.readAsDataURL(image);
                } else {
                    showNotification("La imagen debe ser menor que 2MB", true);
                    clearFileInput(inputFile);
                }
            } else {
                uploadedImage.src = '';
                uploadedImage.style.display = 'none';
                imgArea.classList.remove('active');
                imgArea.dataset.img = '';
            }
        });
    });

    function clearFileInput(input) {
        try {
            input.value = '';
        } catch (e) {
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.className = input.className;
            newInput.style.cssText = input.style.cssText;
            newInput.hidden = true;
            newInput.addEventListener('change', input.onchange);
            input.parentNode.replaceChild(newInput, input);
        }
    }

    let addCareerModal = document.getElementById('myModalCareer')
    let btnAddCareer = document.getElementById('btnAddCareer')
    let cancel = document.querySelector('.cancel')

    btnAddCareer.addEventListener('click', function () {
        openModal('myModalCareer')
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
        if (event.target === addCareerModal) {
            closeModal('myModalCareer')
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

            // Llenar los campos del formulario dentro de la ventana modal
            // const userIdInput = document.getElementById('userIdEdit')
            // const teacherIdInput = document.getElementById('teacherIdEdit')
            // const nameInput = document.getElementById('nameInput')
            // const emailInput = document.getElementById('emailInput')
            // const roleInput = document.getElementById('roleInputEdit')
            // const IdInput = document.getElementById('idInputs')
            // const roleSpanEdit = document.getElementById('roleSpanEdit')

            // userIdInput.value = userId
            // nameInput.value = userName
            // emailInput.value = userEmail
            // roleInput.value = userRole
            // IdInput.value = userId

            openModal(modalId)
        });
    });

    // Asignar un evento de clic a los elementos con la clase 'close'
    const closeButtons = document.querySelectorAll('.modal .close')
    closeButtons.forEach(function (closeButton) {
        closeButton.addEventListener('click', function () {
            const modalId = closeButton.closest('.modal').id

            // Limpiar los campos del formulario al cerrar la ventana modal
            // const nameInput = document.getElementById('nameInput')
            // const emailInput = document.getElementById('emailInput')
            // const roleInput = document.getElementById('roleInput')

            // nameInput.value = ''
            // emailInput.value = ''
            // roleInput.value = ''

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
