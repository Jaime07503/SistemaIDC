document.addEventListener("DOMContentLoaded", function () {
    // Variables
    const listboxes = document.querySelectorAll(".custom-listbox");
    var nameCareerInput = document.getElementById('nameCareerInput');
    var careerIdInput = document.getElementById('careerIdInput');
    let openListbox = null;
    const nameFacultyInput = document.querySelector('.nameFaculty');

    // Custom Listbox
    listboxes.forEach(function (listbox) {
        handleListbox(listbox);
    });

    function handleListbox(listbox) {
        const listboxHeader = listbox.querySelector(".listbox-header");
        const optionsList = listbox.querySelector(".options");
        const arrowDown = listbox.querySelector(".arrow-down");
        const selectedOptionSpan = listbox.querySelector(".selected-option");

        listboxHeader.addEventListener("click", function () {
            if (openListbox && openListbox !== listbox) {
                openListbox.querySelector(".options").style.display = "none";
                openListbox.querySelector(".arrow-down").style.transform = "rotate(0deg)";
                openListbox.querySelector(".listbox-header").classList.remove("active");
            }

            listboxHeader.classList.toggle("active");
            optionsList.style.display = optionsList.style.display === "block" ? "none" : "block";
            arrowDown.style.transform = optionsList.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)";
            openListbox = listbox;
        });

        optionsList.addEventListener("click", function (event) {
            if (event.target.tagName === "LI") {
                const selectedOption = event.target.textContent;
                selectedOptionSpan.textContent = selectedOption;
                optionsList.style.display = "none";
                arrowDown.style.transform = "rotate(0deg)";
                listboxHeader.classList.remove("active");
                var facultyId = event.target.getAttribute('data-value');
                markSelectedOption(event.target);
                nameFacultyInput.value = facultyId;
                if(listbox.classList.contains("faculty-lst")){
                    const idFaculty = document.querySelector('.idFaculty');
                    idFaculty.value=facultyId;
                    //console.log('click');
                }
            }
        });

        // Función para agregar o quitar el ícono de verificación a la opción seleccionada
        function markSelectedOption(selectedListItem) {
            const options = optionsList.querySelectorAll("li");
            options.forEach(function (option) {
                option.classList.remove("selected");
                option.innerHTML = option.textContent; // Limpiar el contenido HTML
            });

            selectedListItem.classList.add("selected");
            selectedListItem.innerHTML = '<i class="fa-solid fa-check"></i> ' + selectedListItem.textContent;
        }
    }

    let addUserModal = document.getElementById('myModalUser');
    let btnAddUser = document.getElementById('btnAddUser');
    let cerrarModalUser = document.getElementById('cerrarModalUser');
    let cancel = document.querySelector('.cancel');

    btnAddUser.addEventListener('click', function () {
        openModal('myModalUser');
    });

    cerrarModalUser.addEventListener('click', function () {
        closeModal('myModalUser');
    });

    cancel.addEventListener('click', function () {
        closeModal('eliminarModal');
    });

    window.addEventListener('click', function (event) {
        if (event.target === addUserModal) {
            closeModal('myModalUser');
        }
    });

    // Obtener todos los botones con la clase 'button-edit' y 'button-delete'
    const buttons = document.querySelectorAll('.button-edit, .button-delete');

    // Asignar un evento de clic a cada botón
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal;
            console.log('click');
            // Obtener datos del usuario desde los atributos data-*
            const nameSubject = button.getAttribute('data-nameSubject');
            const subjectId = button.getAttribute('data-subjectId');
            // const nameFaculty = button.getAttribute('data-nameFaculty');
            // const careerId = button.getAttribute('data-careerId');
            // const spanFaculty = document.querySelector('.faculty');
            // const idFaculty = button.getAttribute('data-idFaculty');
            // const careerIdInput = document.querySelector('.careerId');
            // const careerInput = document.getElementById('idInputs');
            // Llenar los campos del formulario dentro de la ventana modal
            const nameSubjectInput = document.getElementById('idInputs');

            nameSubjectInput.value = nameSubject;
            nameSubjectInput.value = subjectId;


            openModal(modalId);
        });
    });

    // Asignar un evento de clic a los elementos con la clase 'close'
    const closeButtons = document.querySelectorAll('.modal .close');
    closeButtons.forEach(function (closeButton) {
        closeButton.addEventListener('click', function () {
            const modalId = closeButton.closest('.modal').id;

            // Limpiar los campos del formulario al cerrar la ventana modal
            //const nameInput = document.getElementById('nameInput');
            //const emailInput = document.getElementById('emailInput');
            //const roleInput = document.getElementById('roleInput');

            //nameInput.value = '';
            //emailInput.value = '';
            //roleInput.value = '';

            closeModal(modalId);
        });
    });

    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
});
