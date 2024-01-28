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

    function showModal(modal) {
        modal.style.display = 'block';
    }

    function closeModal(modal) {
        modal.style.display = 'none';
    }

    var modals = {
        development: document.getElementById('myModalContribute'),
        conclusion: document.getElementById('myModalConclusion'),
        reference: document.getElementById('myModalReference')
    };

    var btns = {
        addDevelopment: document.getElementById('btnAddContribute'),
        addConclusion: document.getElementById('btnAddConclusion'),
        addReferences: document.getElementById('btnAddReference')
    };

    var closeBtns = {
        development: document.getElementById('cerrarModalContribute'),
        conclusion: document.getElementById('cerrarModalConclusion'),
        reference: document.getElementById('cerrarModalReference')
    };

    function handleModalClick(event, modal) {
        if (event.currentTarget  === modal) {
            closeModal(modal);                        
        }
    }

    function handleAddButtonClick(modal) {
        return function () {
            showModal(modal);
        };
    }

    function handleCloseButtonClick(modal) {
        return function () {
            closeModal(modal);
        };
    } 

    btns.addDevelopment.addEventListener('click', handleAddButtonClick(modals.development));
    btns.addConclusion.addEventListener('click', handleAddButtonClick(modals.conclusion));
    btns.addReferences.addEventListener('click', handleAddButtonClick(modals.reference));

    closeBtns.development.addEventListener('click', handleCloseButtonClick(modals.development));
    closeBtns.conclusion.addEventListener('click', handleCloseButtonClick(modals.conclusion));
    closeBtns.reference.addEventListener('click', handleCloseButtonClick(modals.reference));

    window.addEventListener('click', function (event) {
        if (event.currentTarget  === modals.conclusion) {
            closeModal(modals.conclusion);
        } else if (event.currentTarget  === modals.reference) {
            closeModal(modals.reference);
        }
    });

    document.getElementById('formContribute').addEventListener('submit', function (event) {
        const textareas = document.querySelectorAll("#formContribute .textareaD");
        for (const textarea of textareas) {
            const minLength = parseInt(textarea.getAttribute("min")) || 0;
            const trimmedValue = textarea.value.trim();

            if (trimmedValue === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationD');
                event.preventDefault();
                return;
            }

            if (trimmedValue.length < minLength) {
                showNotification(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true, '#notificationD');
                event.preventDefault();
                return;
            }
        }

        const fileInputs = document.querySelectorAll('.file-input');
        for (const fileInput of fileInputs) {
            if (!fileInput.files.length) {
                showNotification(`Por favor, suba una imagen para el campo "${fileInput.name}"`, true, '#notificationD');
                event.preventDefault(); 
                return;
            }
        }
    });

    document.getElementById('formContentEdit').addEventListener('submit', function (event) {
        const textareas = document.querySelectorAll("#formContentEdit .textareaDE");
        for (const textarea of textareas) {
            const minLength = parseInt(textarea.getAttribute("min")) || 0;
            const trimmedValue = textarea.value.trim();

            if (trimmedValue === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationDEV');
                event.preventDefault();
                return;
            }

            if (trimmedValue.length < minLength) {
                showNotification(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true, '#notificationDEV');
                event.preventDefault();
                return;
            }
        }

        const fileInputs = document.querySelectorAll('.file-input');
        for (const fileInput of fileInputs) {
            if (!fileInput.files.length) {
                showNotification(`Por favor, suba una imagen para el campo "${fileInput.name}"`, true, '#notificationD');
                event.preventDefault(); 
                return;
            }
        }
    });

    document.getElementById('formConclusion').addEventListener('submit', function (event) {
        const textareas = document.querySelectorAll("#formConclusion .textareaC");
        for (const textarea of textareas) {
            const minLength = parseInt(textarea.getAttribute("min")) || 0;
            const trimmedValue = textarea.value.trim();

            if (trimmedValue === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationC');
                event.preventDefault();
                return;
            }

            if (trimmedValue.length < minLength) {
                showNotification(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true, '#notificationC');
                event.preventDefault();
                return;
            }
        }
    });

    document.getElementById('formConclusionEdit').addEventListener('submit', function (event) {
        const textareas = document.querySelectorAll("#formConclusionEdit .textareaCO");
        for (const textarea of textareas) {
            const minLength = parseInt(textarea.getAttribute("min")) || 0;
            const trimmedValue = textarea.value.trim();

            if (trimmedValue === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationCO');
                event.preventDefault();
                return;
            }

            if (trimmedValue.length < minLength) {
                showNotification(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true, '#notificationCO');
                event.preventDefault();
                return;
            }
        }
    });

    document.getElementById('formReference').addEventListener('submit', function (event) {
        const textareas = document.querySelectorAll("#formReference .textareaR");
        for (const textarea of textareas) {
            const minLength = parseInt(textarea.getAttribute("min")) || 0;
            const trimmedValue = textarea.value.trim();

            if (trimmedValue === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationR');
                event.preventDefault();
                return;
            }

            if (trimmedValue.length < minLength) {
                showNotification(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true, '#notificationR');
                event.preventDefault();
                return;
            }
        }
    });

    document.getElementById('formReferenceEdit').addEventListener('submit', function (event) {
        const textareas = document.querySelectorAll("#formReferenceEdit .textareaRE");
        for (const textarea of textareas) {
            const minLength = parseInt(textarea.getAttribute("min")) || 0;
            const trimmedValue = textarea.value.trim();

            if (trimmedValue === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationRE');
                event.preventDefault();
                return;
            }

            if (trimmedValue.length < minLength) {
                showNotification(`El campo "${textarea.placeholder}" debe tener al menos ${minLength} caracteres`, true, '#notificationRE');
                event.preventDefault();
                return;
            }
        }
    });

    const buttonsCT = document.querySelectorAll('#data-table-contribute tbody tr td .btn-edit, #data-table-contribute tbody tr td .btn-delete');
    buttonsCT.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal;

            const developmentId = button.getAttribute('data-developmentId');
            const subtitle = button.getAttribute('data-subtitle');
            const content = button.getAttribute('data-content');

            const developmentIdInput = document.getElementById('developmentId');
            const developmentEIdInput = document.getElementById('developmentEId');
            const subtitleInput = document.getElementById('subtitle');
            const contentInput = document.getElementById('content');

            developmentIdInput.value = developmentId
            developmentEIdInput.value = developmentId
            subtitleInput.value = subtitle
            contentInput.value = content

            openModals(modalId);
        });
    });

    const buttonsCO = document.querySelectorAll('#data-table-conclusion tbody tr td .btn-edit, #data-table-conclusion tbody tr td .btn-delete');
    buttonsCO.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal;

            const conclusionId = button.getAttribute('data-conclusionId');
            const conclusion = button.getAttribute('data-conclusion');

            const conclusionIdInput = document.getElementById('conclusionId');
            const conclusionEInput = document.getElementById('conclusionEId');
            const conclusionInput = document.getElementById('conclusion');

            conclusionIdInput.value = conclusionId;
            conclusionEInput.value = conclusionId;
            conclusionInput.value = conclusion;

            openModals(modalId);
        });
    });

    const buttonsRE = document.querySelectorAll('#data-table-references tbody tr td .btn-edit, #data-table-references tbody tr td .btn-delete');
    buttonsRE.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal;

            const referenceId = button.getAttribute('data-referenceId');
            const reference = button.getAttribute('data-reference');

            const referenceIdInput = document.getElementById('referenceId');
            const referenceEIdInput = document.getElementById('referenceEId');
            const referenceInput = document.getElementById('reference');

            referenceIdInput.value = referenceId;
            referenceEIdInput.value = referenceId;
            referenceInput.value = reference;

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

    function showNotification(message, isError = false, notificationId) {
        const notification = document.querySelector(notificationId);
        notification.textContent = message;
        notification.className = isError ? 'notificationM error' : 'notificationM';
        notification.style.display = 'block';

        setTimeout(function () {
            notification.style.display = 'none';
        }, 3000);
    }
});