document.addEventListener("DOMContentLoaded", function () {
    // Variables
    const listboxes = document.querySelectorAll(".custom-listbox");
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
   });