document.addEventListener("DOMContentLoaded", function () {
    let approvedConclusionCount = calculateApprovedConclusionCount()
    let approvedReferenceCount = calculateApprovedReferenceCount()

    var modals = {
        conclusion: document.getElementById('myModalConclusion'),
        reference: document.getElementById('myModalReference')
    }

    var btns = {
        addConclusion: document.getElementById('btnAddConclusion'),
        addReferences: document.getElementById('btnAddReference')
    }

    var closeBtns = {
        conclusion: document.getElementById('cerrarModalConclusion'),
        reference: document.getElementById('cerrarModalReference')
    }

    const textareas = document.querySelectorAll(".textarea")
    textareas.forEach(textarea => {
        textarea.addEventListener('keyup', e => {
            textarea.style.height = "2.95rem"
            let scHeight = e.target.scrollHeight
            textarea.style.height = `${scHeight}px`
        })
    })

    const textareasT = document.querySelectorAll(".textareaSC")
    textareasT.forEach(textarea => {
        textarea.style.height = (textarea.scrollHeight > 9 * parseFloat(getComputedStyle(textarea).lineHeight) ? '10rem' : textarea.scrollHeight + 'px')
    })

    let btnAprovedConclusions = document.querySelectorAll('.btn-aproved-conclusion')
    btnAprovedConclusions.forEach(function (btnAprovedConclusion) {
        btnAprovedConclusion.addEventListener('click', function (event) {
            let idConclusion = btnAprovedConclusion.getAttribute('data-values')

            fetch(`http://localhost/SistemaIDC/public/updateConclusion/${idConclusion}`)
                .then(function (response) {
                    return response.text()
                })
                .then(function (state) {
                    actualizarCampoStateTableC(state, idConclusion, btnAprovedConclusion)
                })
                .catch(function (error) {
                    console.error('Error en la solicitud Fetch:', error)
                })
        })
    })

    function actualizarCampoStateTableC(state, idConclusion, btnAprovedConclusion) {
        btnAprovedConclusion.style.display = 'none'

        var stateField = document.getElementById(`state-conclusion-${idConclusion}`)
        stateField.textContent = state
        stateField.style.display = 'inline-block'

        if (state.trim() === 'Aprobado') {
            approvedConclusionCount++
        }
    }

    let btnAprovedReferences = document.querySelectorAll('.btn-aproved-reference')
    btnAprovedReferences.forEach(function (btnAprovedReference) {
        btnAprovedReference.addEventListener('click', function (event) {
            let idReference = btnAprovedReference.getAttribute('data-values')

            fetch(`http://localhost/SistemaIDC/public/updateReference/${idReference}`)
                .then(function (response) {
                    return response.text()
                })
                .then(function (state) {
                    actualizarCampoStateTableR(state, idReference, btnAprovedReference)
                })
                .catch(function (error) {
                    console.error('Error en la solicitud Fetch:', error)
                })
        })
    })

    function actualizarCampoStateTableR(state, idReference, btnAprovedReference) {
        btnAprovedReference.style.display = 'none'

        var stateField = document.getElementById(`state-reference-${idReference}`)
        stateField.textContent = state
        stateField.style.display = 'inline-block'

        if (state.trim() === 'Aprobado') {
            approvedReferenceCount++
        }
    }

    const wordCountInput = document.getElementById('wordCount')
    const textareasSC = document.querySelectorAll(".textareaSC")

    if(wordCountInput){
        function countTotalWords() {
            let totalWords = 0
            textareasSC.forEach(textarea => {
                const words = textarea.value.trim().split(/\s+/).filter(word => word !== '').length
                totalWords += words
            })
            return totalWords
        }
    
        wordCountInput.value = countTotalWords()
    
        textareasSC.forEach(textarea => {
            textarea.addEventListener('input', function() {
                wordCountInput.value = countTotalWords()
            })
        })
    }

    function countWords(text) {
        return text.split(/\s+/).length
    }
    
    function countWordsFromTextareas(textareas) {
        let totalWords = 0
        textareas.forEach(textarea => {
            const words = textarea.value.trim().split(/\s+/).filter(word => word !== '').length
            totalWords += words
        })
        return totalWords
    }    

    function countApprovedConclusionWords() {
        let totalWords = 0
        const tableRows = document.querySelectorAll("#data-table-conclusion tbody tr")
        tableRows.forEach(row => {
            const stateElement = row.querySelector(".state")
            if (stateElement) {
                const state = stateElement.textContent.trim()
                if (state === 'Aprobado') {
                    const content = row.querySelector("[data-values='Conclusión']").textContent.trim()
                    totalWords += countWords(content)
                }
            }
        })
        return totalWords
    }    

    const myForm = document.getElementById('myForm')
    const notification = document.getElementById('notification')

    if(myForm) {
        myForm.addEventListener('submit', function (event) {
            const textareas = document.querySelectorAll(".textareaSC")
            for (const textarea of textareas) {
                const minLength = parseInt(textarea.getAttribute("min")) || 0
                const trimmedValue = textarea.value.trim()
    
                if (trimmedValue === '') {
                    showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true)
                    event.preventDefault()
                    return
                }
    
                if (trimmedValue.length < minLength) {
                    showNotification(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true)
                    event.preventDefault()
                    return
                }
            }
    
            if (approvedConclusionCount < 5) {
                showNotification('Debe haber al menos 5 conclusiones aprobadas.', true)
                event.preventDefault()
                return
            }
    
            if (approvedReferenceCount < 2) {
                showNotification('Debe haber al menos 2 referencias aprobados.', true)
                event.preventDefault()
                return
            }
    
            let totalWords = countWordsFromTextareas(textareasSC)
            totalWords += countApprovedConclusionWords()
    
            document.getElementById('wordCount').value = totalWords
        })  
    }

    const buttonsCT = document.querySelectorAll('#data-table-contribute tbody tr td .btn-edit')
    buttonsCT.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal

            const subtitle = button.getAttribute('data-subtitle')
            const content = button.getAttribute('data-content')

            const subtitleInput = document.getElementById('subtitleV')
            const contentInput = document.getElementById('contentV')

            subtitleInput.value = subtitle
            contentInput.value = content

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

    function calculateApprovedConclusionCount() {
        let approvedCount = 0
        const stateElements = document.querySelectorAll(`#data-table-conclusion tbody tr td[data-values="Estado"] h4`)
        stateElements.forEach(function (stateElement) {
            if (stateElement.textContent.trim() === 'Aprobado') {
                approvedCount++
            }
        })
        return approvedCount
    }

    function calculateApprovedReferenceCount() {
        let approvedCount = 0
        const stateElements = document.querySelectorAll(`#data-table-references tbody tr td[data-values="Estado"] h4`)
        stateElements.forEach(function (stateElement) {
            if (stateElement.textContent.trim() === 'Aprobado') {
                approvedCount++
            }
        })
        return approvedCount
    }

    btns.addConclusion.addEventListener('click', handleAddButtonClick(modals.conclusion))
    btns.addReferences.addEventListener('click', handleAddButtonClick(modals.reference))

    closeBtns.conclusion.addEventListener('click', handleCloseButtonClick(modals.conclusion)) 
    closeBtns.reference.addEventListener('click', handleCloseButtonClick(modals.reference))

    window.addEventListener('click', function (event) {
        if (event.currentTarget  === modals.conclusion) {
            closeModal(modals.conclusion) 
        } else if (event.currentTarget  === modals.reference) {
            closeModal(modals.reference) 
        }
    }) 

    formConclusion = document.getElementById('formConclusion')
    if(formConclusion) {
        formConclusion.addEventListener('submit', function (event) {
            const textareas = document.querySelectorAll("#formConclusion .textareaC") 
            for (const textarea of textareas) {
                const minLength = parseInt(textarea.getAttribute("min")) || 0 
                const trimmedValue = textarea.value.trim() 
    
                if (trimmedValue === '') {
                    showNotificationM(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationC') 
                    event.preventDefault() 
                    return 
                }
    
                if (trimmedValue.length < minLength) {
                    showNotificationM(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true, '#notificationC') 
                    event.preventDefault() 
                    return 
                }
            }
        }) 
    }
    
    document.getElementById('formConclusionEdit').addEventListener('submit', function (event) {
        const textareas = document.querySelectorAll("#formConclusionEdit .textareaCO") 
        for (const textarea of textareas) {
            const minLength = parseInt(textarea.getAttribute("min")) || 0 
            const trimmedValue = textarea.value.trim() 

            if (trimmedValue === '') {
                showNotificationM(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationCO') 
                event.preventDefault() 
                return 
            }

            if (trimmedValue.length < minLength) {
                showNotificationM(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true, '#notificationCO') 
                event.preventDefault() 
                return 
            }
        }
    }) 

    document.getElementById('formReference').addEventListener('submit', function (event) {
        const textareas = document.querySelectorAll("#formReference .textareaR") 
        for (const textarea of textareas) {
            const minLength = parseInt(textarea.getAttribute("min")) || 0 
            const trimmedValue = textarea.value.trim() 

            if (trimmedValue === '') {
                showNotificationM(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationR') 
                event.preventDefault() 
                return 
            }

            if (trimmedValue.length < minLength) {
                showNotificationM(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true, '#notificationR') 
                event.preventDefault() 
                return 
            }
        }
    }) 

    document.getElementById('formReferenceEdit').addEventListener('submit', function (event) {
        const textareas = document.querySelectorAll("#formReferenceEdit .textareaRE") 
        for (const textarea of textareas) {
            const minLength = parseInt(textarea.getAttribute("min")) || 0 
            const trimmedValue = textarea.value.trim() 

            if (trimmedValue === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationRE') 
                event.preventDefault() 
                return 
            }

            if (trimmedValue.length < minLength) {
                showNotification(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true, '#notificationRE') 
                event.preventDefault() 
                return 
            }
        }
    }) 

    const buttonsCTE = document.querySelectorAll('#data-table-contribute tbody tr td .btn-edit, #data-table-contribute tbody tr td .btn-delete') 
    buttonsCTE.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal 

            const developmentId = button.getAttribute('data-developmentId') 
            const subtitle = button.getAttribute('data-subtitle') 
            const content = button.getAttribute('data-content') 

            const developmentIdInput = document.getElementById('developmentId') 
            const developmentEIdInput = document.getElementById('developmentEId') 
            const subtitleInput = document.getElementById('subtitle') 
            const contentInput = document.getElementById('content') 

            developmentIdInput.value = developmentId
            developmentEIdInput.value = developmentId
            subtitleInput.value = subtitle
            contentInput.value = content

            openModals(modalId) 
        }) 
    }) 

    const buttonsCO = document.querySelectorAll('#data-table-conclusion tbody tr td .btn-edit, #data-table-conclusion tbody tr td .btn-delete') 
    buttonsCO.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal 

            const conclusionId = button.getAttribute('data-conclusionId') 
            const conclusion = button.getAttribute('data-conclusion') 

            const conclusionIdInput = document.getElementById('conclusionId') 
            const conclusionEInput = document.getElementById('conclusionEId') 
            const conclusionInput = document.getElementById('conclusion') 

            conclusionIdInput.value = conclusionId 
            conclusionEInput.value = conclusionId 
            conclusionInput.value = conclusion 

            openModals(modalId) 
        }) 
    }) 

    const buttonsRE = document.querySelectorAll('#data-table-references tbody tr td .btn-edit, #data-table-references tbody tr td .btn-delete') 
    buttonsRE.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal 

            const referenceId = button.getAttribute('data-referenceId') 
            const reference = button.getAttribute('data-reference') 

            const referenceIdInput = document.getElementById('referenceId') 
            const referenceEIdInput = document.getElementById('referenceEId') 
            const referenceInput = document.getElementById('reference') 

            referenceIdInput.value = referenceId 
            referenceEIdInput.value = referenceId 
            referenceInput.value = reference 

            openModals(modalId) 
        }) 
    }) 
    
    const closeButtonsT = document.querySelectorAll('.modal .close') 
    closeButtonsT.forEach(function (closeButton) {
        closeButton.addEventListener('click', function () {
            const modalId = closeButton.closest('.modal').id 

            closeModals(modalId) 
        }) 
    }) 

    window.addEventListener('click', function (event) {
        if (event.target.id === 'eliminarModalTopic') {
            closeModals('eliminarModalTopic') 
        } else if(event.target.id === 'editarModalTopic') {
            closeModals('editarModalTopic') 
        }
    }) 

    function handleModalClick(event, modal) {
        if (event.currentTarget  === modal) {
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

    function showModal(modal) {
        modal.style.display = 'block' 
    }

    function closeModal(modal) {
        modal.style.display = 'none' 
    }

    function openModals(modalId) {
        document.getElementById(modalId).style.display = 'block' 
    }

    function closeModals(modalId) {
        document.getElementById(modalId).style.display = 'none' 
    }

    function showNotificationM(message, isError = false, notificationId) {
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

    function showNotification(message, isError = false) {
        notification.textContent = message 
        notification.className = isError ? 'notification error' : 'notification' 
        notification.style.display = 'block' 

        setTimeout(function () {
            notification.style.display = 'none' 
        }, 3000) 
    }
}) 