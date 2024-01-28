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
                nameFacultyInput.value = facultyId;
                markSelectedOption(event.target);

                if(listbox.classList.contains("faculty-lst")){
                    const idFaculty = document.querySelector('.idFaculty');
                    idFaculty.value = facultyId;
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
    let cerrarModals = document.querySelectorAll('.cerrarModal');
    let cancel = document.querySelector('.cancel');

    btnAddUser.addEventListener('click', function () {
        openModal('myModalUser');
    });

    cerrarModals.forEach(function(cerrarModal){
        cerrarModal.addEventListener('click', function () {
            const modalId = cerrarModal.closest('.modal').id

            closeModal(modalId);
        });
    })

    cancel.addEventListener('click', function () {
        closeModal('eliminarModal');
    });

    window.addEventListener('click', function (event) {
        if (event.target === addUserModal) {
            closeModal('myModalUser');
        }
    });

    // Obtener todos los botones con la clase 'button-edit' y 'button-delete'
    const buttons = document.querySelectorAll('.btn-edit, .btn-delete');

    // Asignar un evento de clic a cada botón
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            const modalId = button.dataset.modal;

            // Obtener datos del usuario desde los atributos data-*
            const nameCareer = button.getAttribute('data-nameCareer');
            const nameFaculty = button.getAttribute('data-nameFaculty');
            const careerId = button.getAttribute('data-careerId');
            const spanFaculty = document.querySelector('.faculty');
            const idFaculty = button.getAttribute('data-idFaculty');
            const careerIdInput = document.querySelector('.careerId');
            const careerInput = document.getElementById('idInputs');

            // Llenar los campos del formulario dentro de la ventana modal
            const nameCareerInput = document.getElementById('nameCareerInput');

            nameCareerInput.value = nameCareer;
            spanFaculty.innerHTML = nameFaculty;
            nameFacultyInput.value = idFaculty;
            careerIdInput.value = careerId;
            careerInput.value = careerId;

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