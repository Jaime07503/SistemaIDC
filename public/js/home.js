document.addEventListener("DOMContentLoaded", function () {
    const firstListboxHeader = document.querySelectorAll(".custom-listbox:first-child .listbox-header")[0];
    const firstOptionsList = document.querySelectorAll(".custom-listbox:first-child .options")[0];
    const secondListboxHeader = document.querySelectorAll(".custom-listbox:nth-child(3) .listbox-header")[0];
    const secondOptionsList = document.querySelectorAll(".custom-listbox:nth-child(3) .options")[0];
    const listboxHeaders = document.querySelectorAll(".custom-listbox .listbox-header");

    firstListboxHeader.addEventListener("click", function () {
        firstOptionsList.style.display = firstOptionsList.style.display === "block" ? "none" : "block";
        const arrowDown = document.querySelectorAll(".custom-listbox:first-child .arrow-down")[0];
        arrowDown.style.transform = firstOptionsList.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)";
      });
    
      // Manejar la selección de una opción para el primer listbox
      const firstOptions = document.querySelectorAll(".custom-listbox:first-child .options li");
      firstOptions.forEach(function (option) {
        option.addEventListener("click", function () {
          const selectedOption = option.textContent;
          document.querySelectorAll(".custom-listbox:first-child .selected-option")[0].textContent = selectedOption;
          firstOptionsList.style.display = "none";
          const arrowDown = document.querySelectorAll(".custom-listbox:first-child .arrow-down")[0];
          arrowDown.style.transform = "rotate(0deg)";
        });
      });

    secondListboxHeader.addEventListener("click", function () {
        secondOptionsList.style.display = secondOptionsList.style.display === "block" ? "none" : "block";
        const arrowDown = document.querySelectorAll(".custom-listbox:nth-child(3) .arrow-down")[0];
        arrowDown.style.transform = secondOptionsList.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)";
    });

    // Manejar la selección de una opción para el segundo listbox
    const secondOptions = document.querySelectorAll(".custom-listbox:nth-child(3) .options li");
        secondOptions.forEach(function (option) {
        option.addEventListener("click", function () {
            const selectedOption = option.textContent;
            document.querySelectorAll(".custom-listbox:nth-child(3) .selected-option")[0].textContent = selectedOption;
            secondOptionsList.style.display = "none";
            const arrowDown = document.querySelectorAll(".custom-listbox:nth-child(3) .arrow-down")[0];
            arrowDown.style.transform = "rotate(0deg)";
        });
    });

    listboxHeaders.forEach(function (listboxHeader) {
        listboxHeader.addEventListener("click", function () {
          const listbox = listboxHeader.parentElement;
          
          // Cierra todos los listboxes excepto el actual
          listboxHeaders.forEach(function (otherListboxHeader) {
            if (otherListboxHeader !== listboxHeader) {
              otherListboxHeader.classList.remove("active");
            }
          });
    
          // Abre o cierra el listbox actual
          listbox.classList.toggle("active");
        });
      });
  });
  