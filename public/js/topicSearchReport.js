document.addEventListener("DOMContentLoaded", function () {
    let approvedSourcesCount = calculateApprovedSourceCount()
    let approvedGeneralOCount = calculateApprovedOGCount()
    let approvedSpecificOCount = calculateApprovedOECount()

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

    let btnAprovedSources = document.querySelectorAll('.btn-aproved-source');
    btnAprovedSources.forEach(function (btnAprovedSource) {
        btnAprovedSource.addEventListener('click', function (event) {
            let idSource = btnAprovedSource.getAttribute('data-values');

            fetch(`http://localhost/SistemaIDC/public/source/${idSource}`)
                .then(function (response) {
                    return response.text();
                })
                .then(function (state) {
                    actualizarCamposFormulario(state, idSource, btnAprovedSource);
                })
                .catch(function (error) {
                    console.error('Error en la solicitud Fetch:', error);
                });
        });
    });

    function actualizarCamposFormulario(state, idSource, btnAprovedSource) {
        btnAprovedSource.style.display = 'none';

        var stateField = document.getElementById(`state-source-${idSource}`);
        stateField.textContent = state;
        stateField.style.display = 'inline-block';

        if (state.trim() === 'Aprobado') {
            approvedSourcesCount++;
        }
    }

    let btnAprovedObjetivesE = document.querySelectorAll('.btn-aproved-objetiveE');
    btnAprovedObjetivesE.forEach(function (btnAprovedObjetiveE) {
        btnAprovedObjetiveE.addEventListener('click', function (event) {
            let idObjetive = btnAprovedObjetiveE.getAttribute('data-values');

            fetch(`http://localhost/SistemaIDC/public/updateObjetiveE/${idObjetive}`)
                .then(function (response) {
                    return response.text();
                })
                .then(function (state) {
                    actualizarCamposFormularioOE(state, idObjetive, btnAprovedObjetiveE);
                })
                .catch(function (error) {
                    console.error('Error en la solicitud Fetch:', error);
                });
        });
    });

    function actualizarCamposFormularioOE(state, idObjetive, btnAprovedObjetiveE) {
        btnAprovedObjetiveE.style.display = 'none';

        var stateField = document.getElementById(`state-specific-${idObjetive}`);
        stateField.textContent = state;
        stateField.style.display = 'inline-block';

        if (state.trim() === 'Aprobado') {
            approvedSpecificOCount++;
        }
    }

    let btnAprovedObjetivesG = document.querySelectorAll('.btn-aproved-objetiveG');
    btnAprovedObjetivesG.forEach(function (btnAprovedObjetiveG) {
        btnAprovedObjetiveG.addEventListener('click', function (event) {
            let idObjetive = btnAprovedObjetiveG.getAttribute('data-values');

            fetch(`http://localhost/SistemaIDC/public/updateObjetiveG/${idObjetive}`)
                .then(function (response) {
                    return response.text();
                })
                .then(function (state) {
                    actualizarCamposFormularioOG(state, idObjetive, btnAprovedObjetiveG);
                })
                .catch(function (error) {
                    console.error('Error en la solicitud Fetch:', error);
                });
        });
    });

    function actualizarCamposFormularioOG(state, idObjetive, btnAprovedObjetiveG) {
        btnAprovedObjetiveG.style.display = 'none';

        var stateField = document.getElementById(`state-general-${idObjetive}`);
        stateField.textContent = state;
        stateField.style.display = 'inline-block';

        if (state.trim() === 'Aprobado') {
            approvedGeneralOCount++;
        }
    }

    const myForm = document.getElementById('myForm');
    const notification = document.getElementById('notification');

    myForm.addEventListener('submit', function (event) {
        const textareas = document.querySelectorAll(".textarea");
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

        const fileInputs = document.querySelectorAll('.file-input');
        for (const fileInput of fileInputs) {
            if (!fileInput.files.length) {
                showNotification(`Por favor, suba una imagen para el campo "${fileInput.name}"`, true);
                event.preventDefault(); 
                return;
            }
        }

        const inputs = document.querySelectorAll(".calification");
        for (const input of inputs) {
            if (input.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${input.name}"`, true);
                event.preventDefault();
                return;
            }
        }

        if (approvedGeneralOCount < 1) {
            showNotification('Debe haber al menos 1 Objetivo General aprobado', true);
            event.preventDefault();
            return;
        }

        if (approvedSpecificOCount < 3) {
            showNotification('Debe haber al menos 3 Objetivos Específicos aprobados', true);
            event.preventDefault();
            return;
        }

        if (approvedSourcesCount < 2) {
            showNotification('Debe haber al menos 2 fuentes bibliográficas aprobadas', true);
            event.preventDefault();
            return;
        }
    });

    const numberInputs = document.querySelectorAll('.calification');
    for (const numberInput of numberInputs) {
        numberInput.addEventListener('input', function () {
            let inputValue = this.value.replace(/[^0-9]/g, '');
            this.value = inputValue;
        });
    }

    function calculateApprovedSourceCount() {
        let approvedCount = 0;
        const stateElements = document.querySelectorAll(`#data-table-sources tbody tr td[data-values="Estado"] h4`);
        stateElements.forEach(function (stateElement) {
            if (stateElement.textContent.trim() === 'Aprobado') {
                approvedCount++;
            }
        });
        return approvedCount;
    }

    function calculateApprovedOGCount() {
        let approvedCount = 0;
        const stateElements = document.querySelectorAll(`#data-table-objetivesG tbody tr td[data-values="Estado"] h4`);
        stateElements.forEach(function (stateElement) {
            if (stateElement.textContent.trim() === 'Aprobado') {
                approvedCount++;
            }
        });
        return approvedCount;
    }

    function calculateApprovedOECount() {
        let approvedCount = 0;
        const stateElements = document.querySelectorAll(`#data-table-objetivesE tbody tr td[data-values="Estado"] h4`);
        stateElements.forEach(function (stateElement) {
            if (stateElement.textContent.trim() === 'Aprobado') {
                approvedCount++;
            }
        });
        return approvedCount;
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