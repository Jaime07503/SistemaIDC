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

        listboxHeader.addEventListener("click", function () {
            if (openListbox && openListbox !== listbox) {
                openListbox.querySelector(".options").style.display = "none";
                openListbox.querySelector(".arrow-down").style.transform = "rotate(0deg)";
            }

            optionsList.style.display = optionsList.style.display === "block" ? "none" : "block";
            arrowDown.style.transform = optionsList.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)";
            openListbox = listbox;
        });

        optionsList.addEventListener("click", function (event) {
        if (event.target.tagName === "LI") {
            const selectedOption = event.target.textContent;
            const input = listbox.querySelector(".selected-option");
            input.value = selectedOption;
            optionsList.style.display = "none";
            arrowDown.style.transform = "rotate(0deg)";
        }
        });
    }
});