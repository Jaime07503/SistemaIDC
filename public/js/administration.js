document.addEventListener("DOMContentLoaded", function () {
    // Variables
    const listboxes = document.querySelectorAll(".custom-listbox");
    var roleInput = document.getElementById('roleInput');
    var contractTypeInput = document.getElementById('contractTypeInput');
    var specialtyInput = document.getElementById('specialtyInput');
    let openListbox = null;

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
                var selectedOptiont = selectedOptionSpan.textContent;
                roleInput.value = selectedOptiont;
        
                // Asignar valor a los campos de entrada según el tipo de listbox
                if (listbox.classList.contains("contract")) {
                    contractTypeInput.value = selectedOptionSpan.textContent;
                } else if (listbox.classList.contains("specialty")) {
                    specialtyInput.value = selectedOptionSpan.textContent;
                }
        
                // Mostrar u ocultar los listbox según la opción seleccionada
                if (
                    selectedOption.trim() === 'Docente' ||
                    selectedOption.trim() === 'Coordinador' ||
                    listbox.classList.contains("contract") ||
                    listbox.classList.contains("specialty")
                ) {
                    document.querySelector('.lst-contract').removeAttribute("hidden");
                    document.querySelector('.lst-specialty').removeAttribute("hidden");
                } else {
                    // Ocultar todos los listbox
                    document.querySelector('.lst-contract').setAttribute("hidden", "false");
                    document.querySelector('.lst-specialty').setAttribute("hidden", "false");
                }
        
                markSelectedOption(event.target);
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

            // Obtener datos del usuario desde los atributos data-*
            const userName = button.getAttribute('data-userName');
            const userEmail = button.getAttribute('data-userEmail');
            const userRole = button.getAttribute('data-userRole');
            const userId = button.getAttribute('data-userId');

            // Llenar los campos del formulario dentro de la ventana modal
            const nameInput = document.getElementById('nameInput');
            const emailInput = document.getElementById('emailInput');
            const roleInput = document.getElementById('roleInputEdit');
            const IdInput = document.getElementById('idInputs');

            nameInput.value = userName;
            emailInput.value = userEmail;
            roleInput.value = userRole;
            IdInput.value = userId;

            openModal(modalId);
        });
    });

    // Asignar un evento de clic a los elementos con la clase 'close'
    const closeButtons = document.querySelectorAll('.modal .close');
    closeButtons.forEach(function (closeButton) {
        closeButton.addEventListener('click', function () {
            const modalId = closeButton.closest('.modal').id;

            // Limpiar los campos del formulario al cerrar la ventana modal
            const nameInput = document.getElementById('nameInput');
            const emailInput = document.getElementById('emailInput');
            const roleInput = document.getElementById('roleInput');

            nameInput.value = '';
            emailInput.value = '';
            roleInput.value = '';

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