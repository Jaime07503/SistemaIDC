document.addEventListener("DOMContentLoaded", function () {
    let approvedDevelopmentCount = calculateApprovedDevelopmentCount();
    let approvedConclusionCount = calculateApprovedConclusionCount();
    let approvedReferenceCount = calculateApprovedReferenceCount();

    const textareas = document.querySelectorAll(".textarea");
    textareas.forEach(textarea => {
        textarea.addEventListener('keyup', e => {
            textarea.style.height = "2.95rem"; 
            let scHeight = e.target.scrollHeight;
            textarea.style.height = `${scHeight}px`;
        });
    });

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
                // Si no selecciona nada, limpiar la imagen y reiniciar el área
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

    let btnAprovedContributes = document.querySelectorAll('.btn-aproved-development');
    btnAprovedContributes.forEach(function (btnAprovedContribute) {
        btnAprovedContribute.addEventListener('click', function (event) {
            let idContribute = btnAprovedContribute.getAttribute('data-values');

            fetch(`http://localhost/SistemaIDC/public/updateDevelopment/${idContribute}`)
                .then(function (response) {
                    return response.text();
                })
                .then(function (state) {
                    actualizarCampoStateCT(state, idContribute, btnAprovedContribute);
                })
                .catch(function (error) {
                    console.error('Error en la solicitud Fetch:', error);
                });
        });
    });

    function actualizarCampoStateCT(state, idContribute, btnAprovedContribute) {
        btnAprovedContribute.style.display = 'none';

        var stateField = document.getElementById(`state-contribute-${idContribute}`);
        stateField.textContent = state;
        stateField.style.display = 'inline-block';

        if (state.trim() === 'Aprobado') {
            approvedDevelopmentCount++;
        }
    }

    let btnAprovedConclusions = document.querySelectorAll('.btn-aproved-conclusion');
    btnAprovedConclusions.forEach(function (btnAprovedConclusion) {
        btnAprovedConclusion.addEventListener('click', function (event) {
            let idConclusion = btnAprovedConclusion.getAttribute('data-values');

            fetch(`http://localhost/SistemaIDC/public/updateConclusion/${idConclusion}`)
                .then(function (response) {
                    return response.text();
                })
                .then(function (state) {
                    actualizarCampoStateTableC(state, idConclusion, btnAprovedConclusion);
                })
                .catch(function (error) {
                    console.error('Error en la solicitud Fetch:', error);
                });
        });
    });

    function actualizarCampoStateTableC(state, idConclusion, btnAprovedConclusion) {
        btnAprovedConclusion.style.display = 'none';

        var stateField = document.getElementById(`state-conclusion-${idConclusion}`);
        stateField.textContent = state;
        stateField.style.display = 'inline-block';

        if (state.trim() === 'Aprobado') {
            approvedConclusionCount++;
        }
    }

    let btnAprovedReferences = document.querySelectorAll('.btn-aproved-reference');
    btnAprovedReferences.forEach(function (btnAprovedReference) {
        btnAprovedReference.addEventListener('click', function (event) {
            let idReference = btnAprovedReference.getAttribute('data-values');

            fetch(`http://localhost/SistemaIDC/public/updateReference/${idReference}`)
                .then(function (response) {
                    return response.text();
                })
                .then(function (state) {
                    actualizarCampoStateTableR(state, idReference, btnAprovedReference);
                })
                .catch(function (error) {
                    console.error('Error en la solicitud Fetch:', error);
                });
        });
    });

    function actualizarCampoStateTableR(state, idReference, btnAprovedReference) {
        btnAprovedReference.style.display = 'none';

        var stateField = document.getElementById(`state-reference-${idReference}`);
        stateField.textContent = state;
        stateField.style.display = 'inline-block';

        if (state.trim() === 'Aprobado') {
            approvedReferenceCount++;
        }
    }

    const wordCountInput = document.getElementById('wordCount');
    const textareasSC = document.querySelectorAll(".textareaSC");

    function countTotalWords() {
        let totalWords = 0;
        textareasSC.forEach(textarea => {
            const words = textarea.value.trim().split(/\s+/).filter(word => word !== '').length;
            totalWords += words;
        });
        return totalWords;
    }

    wordCountInput.value = countTotalWords();

    textareasSC.forEach(textarea => {
        textarea.addEventListener('input', function() {
            wordCountInput.value = countTotalWords();
        });
    });

    function countWords(text) {
        return text.split(/\s+/).length;
    }
    
    function countWordsFromTextareas(textareas) {
        let totalWords = 0;
        textareas.forEach(textarea => {
            const words = textarea.value.trim().split(/\s+/).filter(word => word !== '').length;
            totalWords += words;
        });
        return totalWords;
    }    

    function countApprovedConclusionWords() {
        let totalWords = 0;
        const tableRows = document.querySelectorAll("#data-table-conclusion tbody tr");
        tableRows.forEach(row => {
            const stateElement = row.querySelector(".state");
            if (stateElement) {
                const state = stateElement.textContent.trim();
                if (state === 'Aprobado') {
                    const content = row.querySelector("[data-values='Conclusión']").textContent.trim();
                    totalWords += countWords(content);
                }
            }
        });
        return totalWords;
    }    

    const myForm = document.getElementById('myForm');
    const notification = document.getElementById('notification');

    myForm.addEventListener('submit', function (event) {
        const textareas = document.querySelectorAll(".textareaSC");
        for (const textarea of textareas) {
            const minLength = parseInt(textarea.getAttribute("min")) || 0;
            const trimmedValue = textarea.value.trim();

            if (trimmedValue === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true);
                event.preventDefault();
                return;
            }

            if (trimmedValue.length < minLength) {
                showNotification(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true);
                event.preventDefault();
                return;
            }
        }

        if (approvedDevelopmentCount < 3 || approvedDevelopmentCount > 3) {
            showNotification('Debe de tener 3 contenidos del tema', true);
            event.preventDefault();
            return;
        }

        if (approvedConclusionCount < 5) {
            showNotification('Debe haber al menos 5 conclusiones aprobadas.', true);
            event.preventDefault();
            return;
        }

        if (approvedReferenceCount < 2) {
            showNotification('Debe haber al menos 2 referencias aprobados.', true);
            event.preventDefault();
            return;
        }

        let totalWords = countWordsFromTextareas(textareasSC);
        totalWords += countApprovedConclusionWords();

        // Conteo de palabras del contenido de la tabla
        const tableRows = document.querySelectorAll("#data-table-contribute tbody tr");
        tableRows.forEach(row => {
            const stateElement = row.querySelector(".state");
            if (stateElement) {
                const state = stateElement.textContent.trim();
                if (state === 'Aprobado') {
                    const content = row.querySelector(".btn-edit").getAttribute("data-content");
                    totalWords += countWords(content);
                }
            }
        });

        // Actualizar el valor del input hidden con el total de palabras
        document.getElementById('wordCount').value = totalWords;
    })  

    const buttonsCT = document.querySelectorAll('#data-table-contribute tbody tr td .btn-edit')
    buttonsCT.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal;

            const subtitle = button.getAttribute('data-subtitle');
            const content = button.getAttribute('data-content');

            const subtitleInput = document.getElementById('subtitleV');
            const contentInput = document.getElementById('contentV');

            subtitleInput.value = subtitle
            contentInput.value = content

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

    function calculateApprovedDevelopmentCount() {
        let approvedCount = 0;
        const stateElements = document.querySelectorAll(`#data-table-contribute tbody tr td[data-values="Estado"] h4`);
        stateElements.forEach(function (stateElement) {
            if (stateElement.textContent.trim() === 'Aprobado') {
                approvedCount++;
            }
        });
        return approvedCount;
    }

    function calculateApprovedConclusionCount() {
        let approvedCount = 0;
        const stateElements = document.querySelectorAll(`#data-table-conclusion tbody tr td[data-values="Estado"] h4`);
        stateElements.forEach(function (stateElement) {
            if (stateElement.textContent.trim() === 'Aprobado') {
                approvedCount++;
            }
        });
        return approvedCount;
    }

    function calculateApprovedReferenceCount() {
        let approvedCount = 0;
        const stateElements = document.querySelectorAll(`#data-table-reference tbody tr td[data-values="Estado"] h4`);
        stateElements.forEach(function (stateElement) {
            if (stateElement.textContent.trim() === 'Aprobado') {
                approvedCount++;
            }
        });
        return approvedCount;
    }

    function openModals(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModals(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function showNotification(message, isError = false) {
        notification.textContent = message;
        notification.className = isError ? 'notification error' : 'notification';
        notification.style.display = 'block';

        setTimeout(function () {
            notification.style.display = 'none';
        }, 3000);
    }
});