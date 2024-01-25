document.addEventListener("DOMContentLoaded", function () {
    const fileContainers = document.querySelectorAll('.file-container');
    fileContainers.forEach(function (fileContainer) {
        const inputFile = fileContainer.querySelector('.file-input');
        const imgArea = fileContainer.querySelector('.img-area');
        const uploadedImage = fileContainer.querySelector('.uploaded-image');

        fileContainer.addEventListener('click', function () {
            inputFile.click();
        });

        inputFile.addEventListener('change', function () {
            const image = this.files[0];
            handleImageUpload(image, uploadedImage, imgArea, inputFile);
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

    function handleImageUpload(image, uploadedImage, imgArea, inputFile) {
        console.log('handleImageUpload is running');
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
                showNotification("La imagen debe ser menor que 2MB", true, '#notificationT');
                clearFileInput(inputFile);
            }
        } else {
            uploadedImage.src = '';
            uploadedImage.style.display = 'none';
            imgArea.classList.remove('active');
            imgArea.dataset.img = '';
        }
    }

    function showModal(modal) {
        modal.style.display = 'block';
    }

    function closeModal(modal) {
        modal.style.display = 'none';
    }

    var modals = {
        topic: document.getElementById('myModalTopic')
    };

    var btns = {
        addTopic: document.getElementById('btnAddTopic')
    };

    var closeBtns = {
        topic: document.getElementById('cerrarModalTopic')
    };

    function handleModalClick(event, modal) {
        if (event.target === modal) {
            closeModal(modal);
            console.log('cierre');                            
        }
    }

    function handleAddButtonClick(modal) {
        return function () {
            showModal(modal);
            console.log('abrir');
        };
    }

    function handleCloseButtonClick(modal) {
        return function () {
            closeModal(modal);
            console.log('cierre');
        };
    } 

    btns.addTopic.addEventListener('click', handleAddButtonClick(modals.topic));

    closeBtns.topic.addEventListener('click', handleCloseButtonClick(modals.topic));

    window.addEventListener('click', function (event) {
        if (event.target === modals.topic) {
            closeModal(modals.topic);
        }
    });

    const buttonsOE = document.querySelectorAll('#data-table-topics tbody tr td .btn-edit, #data-table-topics tbody tr td .btn-delete');
    buttonsOE.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal;

            const topicId = button.getAttribute('data-topicId');
            const nameTopic = button.getAttribute('data-nameTopic');
            const subjectRelevance = button.getAttribute('data-subjectRelevance');
            const localUpdateImg = button.getAttribute('data-localUpdateImg');
            const globalUpdateImg = button.getAttribute('data-globalUpdateImg');
            const updatedInformation = button.getAttribute('data-updatedInformation');
            const localRelevance = button.getAttribute('data-localRelevance');
            const globalRelevance = button.getAttribute('data-globalRelevance');

            const topicIdInput = document.getElementById('topicId');
            const topicIdTInput = document.getElementById('topicTId');
            const nameTopicInput = document.getElementById('theme');
            const subjectRelevanceInput = document.getElementById('subjectRelevance');
            const localUpdateImgInput = document.getElementById('localUpdateImg');
            const globalUpdateImgInput = document.getElementById('globalUpdateImg');
            const updatedInformationInput = document.getElementById('updatedInformation');
            const localRelevanceInput = document.getElementById('localRelevance');
            const globalRelevanceInput = document.getElementById('globalRelevance');

            const localUpdateImgArea = document.querySelector('#container3 .img-area');
            const globalUpdateImgArea = document.querySelector('#container4 .img-area');
            const inputFileImg3 = document.getElementById('img3');
            const inputFileImg4 = document.getElementById('img4');

            topicIdInput.value = topicId;
            topicIdTInput.value = topicId;
            nameTopicInput.value = nameTopic;
            subjectRelevanceInput.value = subjectRelevance;
            console.log('Before handleImageUpload');
            handleImageUpload(localUpdateImg, localUpdateImgInput, localUpdateImgArea, inputFileImg3);
            console.log('After handleImageUpload');
            handleImageUpload(globalUpdateImg, globalUpdateImgInput, globalUpdateImgArea, inputFileImg4);
            updatedInformationInput.value = updatedInformation;
            localRelevanceInput.value = localRelevance;
            globalRelevanceInput.value = globalRelevance;

            console.log('localUpdateImg:', localUpdateImg);
            console.log('globalUpdateImg:', globalUpdateImg);
            console.log('localUpdateImgArea:', localUpdateImgArea);
            console.log('globalUpdateImgArea:', globalUpdateImgArea);
            console.log('inputFileImg3:', inputFileImg3);
            console.log('inputFileImg4:', inputFileImg4);

            openModals(modalId);
        });
    });
    
    const closeButtons = document.querySelectorAll('.modal .close');
    closeButtons.forEach(function (closeButton) {
        closeButton.addEventListener('click', function () {
            const modalId = closeButton.closest('.modal').id;

            closeModals(modalId);
        });
    });

    function openModals(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModals(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    window.addEventListener('click', function (event) {
        if (event.target.id === 'eliminarModalTopic') {
            closeModals('eliminarModalTopic');
        } else if(event.target.id === 'editarModalTopic') {
            closeModals('editarModalTopic');
        }
    });

    document.getElementById('formTopic').addEventListener('submit', function (event) {
        event.preventDefault();  
    
        const textareas = document.querySelectorAll("#formTopic .textareaTopicA");
    
        for (const textarea of textareas) {
            if (textarea.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationT');
                return;  
            }
        }
    
        Promise.all([validarImagenWrapper('Imagen-Importancia-Global'), validarImagenWrapper('Imagen-Importancia-Local')])
            .then(() => {
                document.getElementById('formTopic').submit();
            })
            .catch(error => {
                showNotification(`Error: ${error.message} en el campo "${error.inputName}"`, true, '#notificationT');
            });
    });
    
    async function validarImagenWrapper(inputName) {
        try {
            await validarImagen(inputName);
        } catch (error) {
            error.inputName = inputName;
            throw error;
        }
    }
    
    function validarImagen(inputName) {
        return new Promise((resolve, reject) => {
            var fileInput = document.getElementsByName(inputName)[0];
    
            if (fileInput && fileInput.files.length > 0) {
                var file = fileInput.files[0];
    
                var reader = new FileReader();
                reader.onload = function (e) {
                    resolve();
                };
                reader.readAsDataURL(file);
            } else {
                reject({ message: 'Por favor, selecciona una imagen.', inputName: inputName });
            }
        });
    }
    
    function showNotification(message, isError = false, notificationId) {
        const notification = document.querySelector(notificationId);
    
        if (notification) {
            notification.textContent = message;
            notification.className = isError ? 'notificationM error' : 'notificationM';
            notification.style.display = 'block';
    
            setTimeout(function () {
                notification.style.display = 'none';
            }, 3000);
        } else {
            console.error(`Element with ID ${notificationId} not found in the DOM.`);
        }
    }
});