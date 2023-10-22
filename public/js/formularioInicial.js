document.addEventListener("DOMContentLoaded", function () {
    //Listboxs
    const firstListbox = document.querySelector(".custom-listbox"); 
    const secondListbox = document.querySelector(".info-carnet-año .custom-listbox"); 
    const thirdListbox = document.querySelector(".options-subjects .custom-listbox");  
    const fourthListbox = document.querySelector(".subject-postulate .custom-listbox"); 

    //Radiobutton
    const yesRadioButton = document.getElementById("option-yes");
    const noRadioButton = document.getElementById("option-no");
    const inputBox = document.getElementById("input-box");

    //Options First-Listbox
    const firstListboxHeader = firstListbox.querySelector(".listbox-header");
    const firstOptionsList = firstListbox.querySelector(".options");
    const firstArrowDown = firstListbox.querySelector(".arrow-down");

    //Options Second-Listbox
    const secondListboxHeader = secondListbox.querySelector(".listbox-header");
    const secondOptionsList = secondListbox.querySelector(".options");
    const secondArrowDown = secondListbox.querySelector(".arrow-down");

    //Options Third-Listbox
    const thirdListboxHeader = thirdListbox.querySelector(".listbox-header");
    const thirdOptionsList = thirdListbox.querySelector(".options");
    const thirdArrowDown = thirdListbox.querySelector(".arrow-down");

    //Options Fourth-Listbox
    const fourthListboxHeader = fourthListbox.querySelector(".listbox-header");
    const fourthOptionsList = fourthListbox.querySelector(".options");
    const fourthArrowDown = fourthListbox.querySelector(".arrow-down");

    //Events click Listboxs
    firstListboxHeader.addEventListener("click", function () {
        firstOptionsList.style.display = firstOptionsList.style.display === "block" ? "none" : "block";
        firstArrowDown.style.transform = firstOptionsList.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)";
        console.log('click');
    });

    secondListboxHeader.addEventListener("click", function () {
        secondOptionsList.style.display = secondOptionsList.style.display === "block" ? "none" : "block";
        secondArrowDown.style.transform = secondOptionsList.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)";
        console.log('click');
    });

    thirdListboxHeader.addEventListener("click", function () {
        thirdOptionsList.style.display = thirdOptionsList.style.display === "block" ? "none" : "block";
        thirdArrowDown.style.transform = thirdOptionsList.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)";
        console.log('click');
        actualizarMaterias();
    });

    fourthListboxHeader.addEventListener("click", function () {
        fourthOptionsList.style.display = fourthOptionsList.style.display === "block" ? "none" : "block";
        fourthArrowDown.style.transform = fourthOptionsList.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)";
        console.log('click');
    });

    // Manage a listbox option
    const firstOptions = firstListbox.querySelectorAll(".options li");
    firstOptions.forEach(function (option) {
        option.addEventListener("click", function () {
            const selectedOption = option.textContent;
            firstListbox.querySelector(".selected-option").textContent = selectedOption;
            firstOptionsList.style.display = "none";
            firstArrowDown.style.transform = "rotate(0deg)";
        });
    });

    const secondOptions = secondListbox.querySelectorAll(".options li");
    secondOptions.forEach(function (option) {
        option.addEventListener("click", function () {
            const selectedOption = option.textContent;
            secondListbox.querySelector(".selected-option").textContent = selectedOption;
            secondOptionsList.style.display = "none";
            secondArrowDown.style.transform = "rotate(0deg)";
        });
    });

    const fourthOptions = fourthListbox.querySelectorAll(".options li");
    fourthOptions.forEach(function (option) {
        option.addEventListener("click", function () {
            const selectedOption = option.textContent;
            fourthListbox.querySelector(".selected-option").textContent = selectedOption;
            fourthOptionsList.style.display = "none";
            fourthArrowDown.style.transform = "rotate(0deg)";
        });
    });

    // Add an event to detect the change in the radio button
    yesRadioButton.addEventListener("change", function() {
        if (yesRadioButton.checked) {
            inputBox.style.display = "block"; // Show radio-button
        } else {
            inputBox.style.display = "none"; // Hidden radio-button
        }
    });

    noRadioButton.addEventListener("change", function() {
        if (noRadioButton.checked) {
            inputBox.style.display = "none"; // Hidden radio-button
        }
    });

    const careerListbox = document.getElementById('career');
    const yearListbox = document.getElementById('year');
    const subjectList = document.getElementById('subject-list');
    const form = document.getElementById('subject-form');

    careerListbox.addEventListener('change', actualizarMaterias);
    yearListbox.addEventListener('change', actualizarMaterias);

    function actualizarMaterias() {
        const selectedCareer = careerListbox.value;
        const selectedYear = yearListbox.value;

        // Actualiza los campos ocultos en el formulario
        document.getElementById('selectedCareer').value = selectedCareer;
        document.getElementById('selectedYear').value = selectedYear;

        // Envía el formulario al servidor sin redireccionar
        form.submit();
    }
});