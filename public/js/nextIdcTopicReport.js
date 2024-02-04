document.addEventListener("DOMContentLoaded", function () {
    let approvedTopicsCount = calculateApprovedTopicsCount()

    const textareas = document.querySelectorAll(".textarea");
    textareas.forEach(textarea => {
        textarea.addEventListener('keyup', e => {
            textarea.style.height = "2.95rem"; 
            let scHeight = e.target.scrollHeight;
            console.log(scHeight);
            textarea.style.height = `${scHeight}px`;
        });
    });

    let btnAprovedTopics = document.querySelectorAll('.btn-aproved-topic')
    btnAprovedTopics.forEach(function (btnAprovedTopic) {
        btnAprovedTopic.addEventListener('click', function (event) {
            let idTopic = btnAprovedTopic.getAttribute('data-values')

            fetch(`http://localhost/SistemaIDC/public/updateTopic/${idTopic}`)
                .then(function (response) {
                    return response.text()
                })
                .then(function (state) {
                    actualizarCamposFormulario(state, idTopic, btnAprovedTopic)
                })
                .catch(function (error) {
                    console.error('Error en la solicitud Fetch:', error)
                })
        })
    })

    function actualizarCamposFormulario(state, idTopic, btnAprovedTopic) {
        btnAprovedTopic.style.display = 'none'

        var stateField = document.getElementById(`state-topic-${idTopic}`)
        stateField.textContent = state
        stateField.style.display = 'inline-block'

        if (state.trim() === 'Aprobado') {
            approvedTopicsCount++
        }

        if(approvedTopicsCount === 3) {
            const approveButtons = document.querySelectorAll(".btn-aproved-topic")
            approveButtons.forEach(btn => btn.style.display = 'none')
        }
    }

    const myForm = document.getElementById('myForm')
    const notification = document.getElementById('notification')

    const buttonsViews = document.querySelectorAll('#data-table-topic tbody tr td .btn-edit')
    buttonsViews.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal

            const nameTopic = button.getAttribute('data-nameTopic')
            const subjectRelevance = button.getAttribute('data-subjectRelevance')
            const localUpdateImg = button.getAttribute('data-localUpdateImg')
            const globalUpdateImg = button.getAttribute('data-globalUpdateImg')
            const updatedInformation = button.getAttribute('data-updatedInformation')
            const localRelevance = button.getAttribute('data-localRelevance')
            const globalRelevance = button.getAttribute('data-globalRelevance')

            const nameTopicInput = document.getElementById('theme')
            const subjectRelevanceInput = document.getElementById('subjectRelevance')
            const localUpdateImgInput = document.querySelector('.uploaded-image-l')
            const globalUpdateImgInput = document.querySelector('.uploaded-image-g')
            const updatedInformationInput = document.getElementById('updatedInformation')
            const localRelevanceInput = document.getElementById('localRelevance')
            const globalRelevanceInput = document.getElementById('globalRelevance')

            nameTopicInput.value = nameTopic
            subjectRelevanceInput.value = subjectRelevance
            localUpdateImgInput.src = localUpdateImg
            globalUpdateImgInput.src = globalUpdateImg
            updatedInformationInput.value = updatedInformation
            localRelevanceInput.value = localRelevance
            globalRelevanceInput.value = globalRelevance

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

    myForm.addEventListener('submit', function (event) {        
        const textareas = document.querySelectorAll(".textareaTopic")
        for (const textarea of textareas) {
            if (textarea.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true)
                event.preventDefault()
                return
            }
        }

        if (approvedTopicsCount < 3) {
            showNotification('Deben haber 3 temas de investigación aprobados', true)
            event.preventDefault()
            return
        }
    })

    function calculateApprovedTopicsCount() {
        let approvedCount = 0
        const stateElements = document.querySelectorAll(`#data-table-topic tbody tr td[data-values="Estado"] h4`)
        stateElements.forEach(function (stateElement) {
            if (stateElement.textContent.trim() === 'Aprobado') {
                approvedCount++
            }

            if(approvedCount === 3) {
                const approveButtons = document.querySelectorAll(".btn-aproved-topic")
                approveButtons.forEach(btn => btn.style.display = 'none')
            }
        })
        return approvedCount
    }

    function openModals(modalId) {
        document.getElementById(modalId).style.display = 'block'
    }

    function closeModals(modalId) {
        document.getElementById(modalId).style.display = 'none'
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