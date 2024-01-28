document.addEventListener("DOMContentLoaded", function () {
    const textareas = document.querySelectorAll(".textarea");
    textareas.forEach(textarea => {
        textarea.addEventListener('keyup', e => {
            textarea.style.height = "2.95rem"; 
            let scHeight = e.target.scrollHeight;
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
        info: document.getElementById('myModalInfo'),
        objetivoGeneral: document.getElementById('myModalObjetivoGeneral'),
        objetivoEspecifico: document.getElementById('myModalObjetivoEspecifico'),
    };

    var btns = {
        addInfo: document.getElementById('btnAddInfo'),
        addObjetivoGeneral: document.getElementById('btnAddObjetivoGeneral'),
        addObjetivoEspecifico: document.getElementById('btnAddObjetivoEspecifico'),
    };

    var closeBtns = {
        info: document.getElementById('cerrarModalInfo'),
        objetivoGeneral: document.getElementById('cerrarModalObjetivoGeneral'),
        objetivoEspecifico: document.getElementById('cerrarModalObjetivoEspecifico'),
    };

    function handleModalClick(event, modal) {
        if (event.target === modal) {
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

    btns.addInfo.addEventListener('click', handleAddButtonClick(modals.info));
    btns.addObjetivoGeneral.addEventListener('click', handleAddButtonClick(modals.objetivoGeneral));
    btns.addObjetivoEspecifico.addEventListener('click', handleAddButtonClick(modals.objetivoEspecifico));

    closeBtns.info.addEventListener('click', handleCloseButtonClick(modals.info));
    closeBtns.objetivoGeneral.addEventListener('click', handleCloseButtonClick(modals.objetivoGeneral));
    closeBtns.objetivoEspecifico.addEventListener('click', handleCloseButtonClick(modals.objetivoEspecifico));

    window.addEventListener('click', function (event) {
        if (event.target === modals.info) {
            closeModal(modals.info);
        } else if (event.target === modals.objetivoGeneral) {
            closeModal(modals.objetivoGeneral);
        } else if (event.target === modals.objetivoEspecifico) {
            closeModal(modals.objetivoEspecifico);
        }
    });

    const buttonsS = document.querySelectorAll('#data-table-sources tbody tr td .btn-edit, #data-table-sources tbody tr td .btn-delete');
    buttonsS.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal;

            const sourceId = button.getAttribute('data-bibliographicSourceId');
            const year = button.getAttribute('data-year');
            const author = button.getAttribute('data-author');
            const theme = button.getAttribute('data-theme');
            const averageType = button.getAttribute('data-averageType');
            const source = button.getAttribute('data-source');
            const link = button.getAttribute('data-link');

            const sourceIdInput = document.getElementById('bibliographicSourceId');
            const sourceEIdInput = document.getElementById('bibliographicSourceEId');
            const yearInput = document.getElementById('year');
            const authorInput = document.getElementById('author');
            const themeInput = document.getElementById('theme');
            const averageTypeInput = document.getElementById('averageType');
            const sourceInput = document.getElementById('source');
            const linkInput = document.getElementById('link');

            sourceIdInput.value = sourceId;
            sourceEIdInput.value = sourceId;
            yearInput.value = year;
            authorInput.value = author;
            themeInput.value = theme;
            averageTypeInput.value = averageType;
            sourceInput.value = source;
            linkInput.value = link;

            openModals(modalId);
        });
    });

    const buttonsOG = document.querySelectorAll('#data-table-objetivesG tbody tr td .btn-edit, #data-table-objetivesG tbody tr td .btn-delete');
    buttonsOG.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal;

            const objetiveId = button.getAttribute('data-objetiveId');
            const objetive = button.getAttribute('data-objetive');

            const objetiveIdInput = document.getElementById('objetiveGGId');
            const objetiveGIdInput = document.getElementById('objetiveGId');
            const objetiveInput = document.getElementById('generalObjetive');

            objetiveIdInput.value = objetiveId;
            objetiveGIdInput.value = objetiveId;
            objetiveInput.value = objetive;

            openModals(modalId);
        });
    });

    const buttonsOE = document.querySelectorAll('#data-table-objetivesE tbody tr td .btn-edit, #data-table-objetivesE tbody tr td .btn-delete');
    buttonsOE.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal;

            const objetiveId = button.getAttribute('data-objetiveId');
            const objetive = button.getAttribute('data-objetive');


            const objetiveIdInput = document.getElementById('objetiveEEId');
            const objetiveEIdInput = document.getElementById('objetiveEId');
            const objetiveInput = document.getElementById('specificObjetive');

            objetiveIdInput.value = objetiveId;
            objetiveEIdInput.value = objetiveId;
            objetiveInput.value = objetive;

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
        if (event.target.id === 'eliminarModalSource') {
            closeModals('eliminarModalSource');
        } else if(event.target.id === 'editarModalSource') {
            closeModals('editarModalSource');
        } else if(event.target.id === 'eliminarModalObjetiveG') {
            closeModals('eliminarModalObjetiveG');
        }
    });

    document.getElementById('formSourceCreate').addEventListener('submit', function (event) {
        const input = document.querySelector("#formSourceCreate .year");
        if (input.value.trim() === '') {
            showNotification(`Por favor, completa el campo "${input.placeholder}"`, true, '#notificationS');
            event.preventDefault();
            return;
        }

        const textareas = document.querySelectorAll("#formSourceCreate .textarea");
        for (const textarea of textareas) {
            if (textarea.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationS');
                event.preventDefault();
                return;
            }
        }
    });

    document.getElementById('formSourceEdit').addEventListener('submit', function (event) {
        const input = document.querySelector("#formSourceEdit .year");
        if (input.value.trim() === '') {
            showNotification(`Por favor, completa el campo "${input.placeholder}"`, true, '#notificationSE');
            event.preventDefault();
            return;
        }

        const textareas = document.querySelectorAll("#formSourceEdit .textarea");
        for (const textarea of textareas) {
            if (textarea.value.trim() === '') {
                showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationSE');
                event.preventDefault();
                return;
            }
        }
    });

    document.getElementById('formObjetiveG').addEventListener('submit', function (event) {
        const textarea = document.querySelector("#formObjetiveG .textareaOG");
        if (textarea.value.trim() === '') {
            showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationOG');
            event.preventDefault();
            return;
        }
    });

    document.getElementById('formObjetiveGEdit').addEventListener('submit', function (event) {
        const textarea = document.querySelector("#formObjetiveGEdit .textareaOG");
        if (textarea.value.trim() === '') {
            showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationOGEdit');
            event.preventDefault();
            return;
        }
    });

    document.getElementById('formObjetiveE').addEventListener('submit', function (event) {
        const textarea = document.querySelector("#formObjetiveE .textareaOE");
        if (textarea.value.trim() === '') {
            showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationOE');
            event.preventDefault();
            return;
        }
    });

    document.getElementById('formObjetiveEEdit').addEventListener('submit', function (event) {
        const textarea = document.querySelector("#formObjetiveEEdit .textareaOE");
        if (textarea.value.trim() === '') {
            showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationOEEdit');
            event.preventDefault();
            return;
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

    const yearInput = document.querySelector('.year')
    yearInput.addEventListener('input', function () {
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue;
    });
});