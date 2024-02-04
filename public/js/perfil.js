document.addEventListener("DOMContentLoaded", function () {
    const fileContainers = document.querySelectorAll('.file-container')
    fileContainers.forEach(function (fileContainer) {
        const inputFile = fileContainer.querySelector('.file-input')
        const imgArea = fileContainer.querySelector('.img-area')
        const uploadedImage = fileContainer.querySelector('#uploadedImage')
    
        fileContainer.addEventListener('click', function () {
            inputFile.click();
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
                        };
    
                        reader.readAsDataURL(image)
                    } else {
                        showNotification("La imagen debe ser menor que 2MB", true)
                        clearFileInput(inputFile)
                    }
                } else {
                    showNotification("Solo se permiten archivos de imagen (PNG, JPG o JPEG)", true)
                    clearFileInput(inputFile);
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
            newInput.type = 'file';
            newInput.className = input.className
            newInput.style.cssText = input.style.cssText
            newInput.hidden = true
            newInput.addEventListener('change', input.onchange)
            input.parentNode.replaceChild(newInput, input)
        }
    }

    const formChangeAvatar = document.getElementById('formChangeAvatar')
    const notification = document.getElementById('notificationU')

    formChangeAvatar.addEventListener('submit', function (event) {
        const fileInputs = document.querySelectorAll('.file-input')
        for (const fileInput of fileInputs) {
            if (!fileInput.files.length) {
                showNotification(`Por favor, suba una imagen para el campo "${fileInput.name}"`, true)
                event.preventDefault();
                return
            }
        }
    })

    function showNotification(message, isError = false) {
        notification.textContent = message
        notification.className = isError ? 'notificationM error' : 'notificationM'
        notification.style.display = 'block';

        setTimeout(function () {
            notification.style.display = 'none'
        }, 3000)
    }

    function showModal(modal) {
        modal.style.display = 'block'
    }

    function closeModal(modal) {
        modal.style.display = 'none'
    }

    var modals = {
        user: document.getElementById('myModalEditUser')
    }

    var btns = {
        addAvatar: document.getElementById('btnChangeAvatar')
    }

    var closeBtns = {
        user: document.getElementById('cerrarModalEditUser')
    }

    function handleModalClick(event, modal) {
        if (event.target === modal) {
            closeModal(modal)
            console.log('cierre')                          
        }
    }

    function handleAddButtonClick(modal) {
        return function () {
            showModal(modal)
            console.log('abrir')
        }
    }

    function handleCloseButtonClick(modal) {
        return function () {
            closeModal(modal)
            console.log('cierre')
        }
    } 

    btns.addAvatar.addEventListener('click', handleAddButtonClick(modals.user))

    closeBtns.user.addEventListener('click', handleCloseButtonClick(modals.user))

    window.addEventListener('click', function (event) {
        if (event.target === modals.user) {
            closeModal(modals.user)
        }
    })
})