document.addEventListener("DOMContentLoaded", function () {
    const textareas = document.querySelectorAll(".textarea");
    textareas.forEach(textarea => {
        textarea.addEventListener('keyup', e => {
            textarea.style.height = "2.95rem"; 
            let scHeight = e.target.scrollHeight;
            console.log(scHeight);
            textarea.style.height = `${scHeight}px`;
        });
    });

    const fileContainers = document.querySelectorAll('.file-container')
    fileContainers.forEach(function (fileContainer) {
        const inputFile = fileContainer.querySelector('.file-input')
        const imgArea = fileContainer.querySelector('.img-area')
        const uploadedImage = fileContainer.querySelector('#uploadedImage')
    
        fileContainer.addEventListener('click', function () {
            inputFile.click()
        })
    
        inputFile.addEventListener('change', function () {
            const image = this.files[0]
    
            if (image) {
                const allowedTypes = ['image/png', 'image/jpeg']
    
                if (allowedTypes.includes(image.type)) {
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
                        showNotification("La imagen debe ser menor que 2MB", true, '#notificationT')
                        clearFileInput(inputFile)
                    }
                } else {
                    showNotification("Solo se permiten archivos de imagen (PNG, JPG o JPEG)", true, '#notificationT')
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

    function showModal(modal) {
        modal.style.display = 'block'
    }

    function closeModal(modal) {
        modal.style.display = 'none'
    }

    var modals = {
        topic: document.getElementById('myModalTopic')
    }

    var btns = {
        addTopic: document.getElementById('btnAddTopic')
    }

    var closeBtns = {
        topic: document.getElementById('cerrarModalTopic')
    }

    function handleModalClick(event, modal) {
        if (event.target === modal) {
            closeModal(modal)                           
        }
    }

    function handleAddButtonClick(modal) {
        return function () {
            showModal(modal)
        }
    }

    function handleCloseButtonClick(modal) {
        return function () {
            closeModal(modal)
        }
    } 

    btns.addTopic.addEventListener('click', handleAddButtonClick(modals.topic))

    closeBtns.topic.addEventListener('click', handleCloseButtonClick(modals.topic))

    window.addEventListener('click', function (event) {
        if (event.target === modals.topic) {
            closeModal(modals.topic)
        }
    })

    const buttonsOE = document.querySelectorAll('#data-table-topics tbody tr td .btn-edit, #data-table-topics tbody tr td .btn-delete')
    buttonsOE.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal

            const topicId = button.getAttribute('data-topicId')
            const nameTopic = button.getAttribute('data-nameTopic')
            const description = button.getAttribute('data-description')
            const subjectRelevance = button.getAttribute('data-subjectRelevance')
            const localUpdateImg = button.getAttribute('data-localUpdateImg')
            const globalUpdateImg = button.getAttribute('data-globalUpdateImg')
            const updatedInformation = button.getAttribute('data-updatedInformation')
            const localRelevance = button.getAttribute('data-localRelevance')
            const globalRelevance = button.getAttribute('data-globalRelevance')

            const topicIdInput = document.getElementById('topicId')
            const topicIdTInput = document.getElementById('topicTId')
            const nameTopicInput = document.getElementById('theme')
            const descriptionInput = document.getElementById('description')
            const subjectRelevanceInput = document.getElementById('subjectRelevance')
            const localUpdateImgInput = document.querySelector('.uploaded-image-l')
            const globalUpdateImgInput = document.querySelector('.uploaded-image-g')
            const inputFiles = document.querySelectorAll('#formEditTopic .file-input')
            const updatedInformationInput = document.getElementById('updatedInformation')
            const localRelevanceInput = document.getElementById('localRelevance')
            const globalRelevanceInput = document.getElementById('globalRelevance')

            topicIdInput.value = topicId
            topicIdTInput.value = topicId
            nameTopicInput.value = nameTopic
            descriptionInput.value = description
            subjectRelevanceInput.value = subjectRelevance
            localUpdateImgInput.src = localUpdateImg
            localUpdateImgInput.style.display = 'block'
            globalUpdateImgInput.src = globalUpdateImg
            globalUpdateImgInput.style.display = 'block'
            updatedInformationInput.value = updatedInformation
            localRelevanceInput.value = localRelevance
            globalRelevanceInput.value = globalRelevance
            
            inputFiles.forEach(function(inputFile){
                inputFile.value = ''
            })

            openModals(modalId)
        })
    })
    
    const closeButtons = document.querySelectorAll('.modal .close')
    closeButtons.forEach(function (closeButton) {
        closeButton.addEventListener('click', function () {
            const modalId = closeButton.closest('.modal').id

            closeModals(modalId)
        })
    })

    function openModals(modalId) {
        document.getElementById(modalId).style.display = 'block'
    }

    function closeModals(modalId) {
        document.getElementById(modalId).style.display = 'none'
    }

    window.addEventListener('click', function (event) {
        if (event.target.id === 'eliminarModalTopic') {
            closeModals('eliminarModalTopic')
        } else if(event.target.id === 'editarModalTopic') {
            closeModals('editarModalTopic')
        }
    })

    document.getElementById('formTopic').addEventListener('submit', function (event) {
        event.preventDefault() 
    
        const textareas = document.querySelectorAll("#formTopic .textareaTopicA")
        for (const textarea of textareas) {
            if (textarea.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationT')
                return 
            }
        }
    
        Promise.all([validarImagenWrapper('Imagen-Importancia-Global'), validarImagenWrapper('Imagen-Importancia-Local')])
            .then(() => {
                document.getElementById('formTopic').submit()
            })
            .catch(error => {
                showNotification(`${error.message} en el campo "${error.inputName}"`, true, '#notificationT')
            })
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

    document.getElementById('formTopicEdit').addEventListener('submit', function (event) {
        event.preventDefault()  
    
        const textareas = document.querySelectorAll("#formTopicEdit .textareaT")
        for (const textarea of textareas) {
            if (textarea.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationTE')
                return  
            }
        }

        this.submit()
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
})