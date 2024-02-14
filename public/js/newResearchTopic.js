document.addEventListener("DOMContentLoaded", function () {
    const textareas = document.querySelectorAll(".textarea")
    textareas.forEach(textarea => {
        textarea.addEventListener('keyup', e => {
            textarea.style.height = "2.95rem"
            let scHeight = e.target.scrollHeight
            console.log(scHeight)
            textarea.style.height = `${scHeight}px`
        })
    })

    const fileContainers = document.querySelectorAll('.file-container')
    fileContainers.forEach(function (fileContainer) {
        const inputFile = fileContainer.querySelector('.file-input')
        const imgArea = fileContainer.querySelector('.img-area')
        const uploadedImage = fileContainer.querySelector('#uploadedImage')
    
        fileContainer.addEventListener('click', function () {
            inputFile.click();
        });
    
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
        });
    });

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

    document.getElementById('formAddResearchTopic').addEventListener('submit', function (event) {
        event.preventDefault() 
    
        const textareas = document.querySelectorAll("#formAddResearchTopic .textareaTopicA")
        for (const textarea of textareas) {
            if (textarea.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationT')
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