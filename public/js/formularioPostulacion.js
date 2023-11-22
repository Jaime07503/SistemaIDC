document.addEventListener("DOMContentLoaded", function () {
    // Variables
    const yesRadioButton = document.getElementById("option-yes");
    const noRadioButton = document.getElementById("option-no");
    const inputBox = document.getElementById("input-box");
    const listboxes = document.querySelectorAll(".custom-listbox");
    const form = document.querySelector("form");
    const errorInputs = document.querySelectorAll(".error-input");
    const preIDC = document.getElementById("subjectPostulated");
    let openListbox = null;

    // Inputs validation
    document.getElementById("nameInput").addEventListener("input", function () {
        let inputValue = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚüÜ\s]/g, ''); // Allows letters, spaces and accented vowels
        this.value = inputValue;
    });

    document.getElementById("carnetInput").addEventListener("input", function () {
        let inputValue = this.value.replace(/[^a-zA-Z0-9]/g, ''); // Remove unwanted characters
        let formattedValue = "";
    
        for (let i = 0; i < inputValue.length; i++) {
          if (i < 4) {
            // The first four characters must be numbers
            formattedValue += inputValue[i].replace(/[^0-9]/g, '');
          } else if (i < 6) {
            // The next two characters must be letters
            formattedValue += inputValue[i].replace(/[^a-zA-Z]/g, '');
          } else {
            // The last three characters must be numbers
            formattedValue += inputValue[i].replace(/[^0-9]/g, '');
          }
    
          if ((i === 3 || i === 5) && inputValue.length > (i + 1)) {
            formattedValue += "-";
          }
        }
    
        this.value = formattedValue;
    });

    document.getElementById("participated-idc-input").addEventListener("input", function () {
        let inputValue = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚüÜ\s]/g, ''); // Permite letras, espacios y vocales acentuadas
        this.value = inputValue;
    });

    // Add a listener event for the form submission
    form.addEventListener("submit", function (event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });

    errorInputs.forEach(function (input) {
        input.addEventListener("input", function () {
            const errorId = input.getAttribute("id") + "Error";
            const errorElement = document.getElementById(errorId);
            errorElement.style.display = "none";
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

    // Custom Listbox
    listboxes.forEach(function (listbox) {
        handleListbox(listbox);
    });

    // Validate the form fields
    function validateForm() {
        const name = document.getElementById("nameInput").value;
        const carnet = document.getElementById("carnetInput").value;
        const career = document.getElementById("career").value;
        const year = document.getElementById("year").value;
        const subjectPostulated = document.getElementById("subjectPostulated").value;
        const previousIDC = document.getElementById("participated-idc-input").value;

        const nameError = document.getElementById("nameInputError");
        const carnetError = document.getElementById("carnetInputError");
        const careerError = document.getElementById("careerInputError");
        const yearError = document.getElementById("yearInputError");
        const subjectPostulatedError = document.getElementById("subjectPostulatedError");
        const previousIDCError = document.getElementById("previousIDCInputError");
    
        // Restablecer los mensajes de error
        nameError.style.display = "none";
        carnetError.style.display = "none";
        careerError.style.display = "none";
        yearError.style.display = "none";
        subjectPostulatedError.style.display = "none";
        previousIDCError.style.display = "none";
    
        let isValid = true;
    
        if (name === "") {
            nameError.style.display = "block";
            isValid = false;
        }
    
        if (carnet === "" || carnet.length < 11) {
            carnetError.style.display = "block";
            isValid = false;
        }

        if (career === ""){
            careerError.style.display = "block";
            isValid = false;
        }
    
        if (year === ""){
            yearError.style.display = "block";
            isValid = false;
        }
        
        if (subjectPostulated === ""){
            subjectPostulatedError.style.display = "block";
            isValid = false;
        }

        if (yesRadioButton.checked) {
            // Esta validación solo se aplica si el radio button está en "Sí"    
            if (previousIDC === "") {
                previousIDCError.style.display = "block";
                isValid = false;
            }
        }

        // Agregar validaciones para otros campos aquí
        return isValid;
    }

    // Function about Custom Listbox
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
                const input = listbox.querySelector(".selected-option.listbox");
                input.value = selectedOption;
                optionsList.style.display = "none";
                arrowDown.style.transform = "rotate(0deg)";
                const yearError = document.getElementById("yearInputError");
                const careerError = document.getElementById("careerInputError");
                const subjectPostulatedError = document.getElementById("subjectPostulatedError");
        
                if (listbox.classList.contains("career")) {
                    // Estás trabajando en el listbox de Carrera
                    careerError.style.display = "none"; // Oculta el icono de error de Carrera
                } else if (listbox.classList.contains("year")) {
                    // Estás trabajando en el listbox de Año
                    yearError.style.display = "none"; // Oculta el icono de error de Año
                } else if (listbox.classList.contains("subjectPostulated")){
                    subjectPostulatedError.style.display = "none";
                } 
        
                if ((listbox.classList.contains("career") && document.querySelector("#career").value !== "Carrera" && document.querySelector("#year").value) ||
                    (listbox.classList.contains("year") && document.querySelector("#career").value && document.querySelector("#year").value !== "Año")) {
                    getSubjects();
                    preIDC.value = "";
                    let selectedSubjects = [];
                    updateSubjectList(selectedSubjects);
                }
            }
        });
    }
    
    function getSubjects() {
        let careerSelect = document.querySelector('#career');
        let yearSelect = document.querySelector('#year');

        let career = careerSelect.value;
        let year = yearSelect.value;

        fetch(`getSubjects/${career}/${year}`)
            .then(function (response) {
                return response.json();
            })
            .then(function (jsonData){
                buildEnrolledSubjects(jsonData);
            });
    }

    function buildEnrolledSubjects(jsonSubjects) {
        let enrolledSubjectsSelect = document.getElementById('enrolledSubjects');
        clearSelect(enrolledSubjectsSelect);
        let selectedSubjects = [];
        let selectedMaterias = [];
        let maxSelected = 5;
        jsonSubjects.forEach(function (subject, index) {
            if (selectedSubjects.length >= maxSelected) {
                return; // No permitir seleccionar más de 6
            }
    
            // Create the label element
            let label = document.createElement('label');
            label.className = 'checkbox';
            label.htmlFor = 'myCheckboxId' + (index + 1);
    
            // Create the input element
            let input = document.createElement('input');
            input.className = 'checkbox-input';
            input.name = 'myCheckboxName' + (index + 1);
            input.id = 'myCheckboxId' + (index + 1);
            input.type = 'checkbox';
            input.value = subject.nameSubject;
    
            // Create the div element with class "checkbox-box"
            let checkboxBox = document.createElement('div');
            checkboxBox.className = 'checkbox-box';
    
            // Set the name of the subject
            let textNode = document.createTextNode(subject.nameSubject + ' - ' + subject.section + ' - ' + subject.name);
    
            // Add input, div, and text to label
            label.appendChild(input);
            label.appendChild(checkboxBox);
            label.appendChild(textNode);
    
            // Add label to listbox
            enrolledSubjectsSelect.append(label);
    
            let lastChecked = null; // Variable para realizar un seguimiento del último checkbox marcado

            input.addEventListener('change', function () {
                if (input.checked) {
                    if (selectedSubjects.length >= maxSelected) {
                        input.checked = false; // No permitir seleccionar más de 6
                    } else {
                        // Add the selected matter to the array
                        selectedMaterias.push(subject.subjectId);
                        selectedSubjects.push(subject.nameSubject + ' - ' + subject.section + ' - ' + subject.name);
                        lastChecked = subject.nameSubject; // Actualiza el último checkbox marcado
                    }
                } else {
                    // Remove deselected matter from the array
                    const subjectIndex = selectedSubjects.indexOf(subject.nameSubject + ' - ' + subject.section + ' - ' + subject.name);
                    if (subjectIndex !== -1) {
                        selectedSubjects.splice(subjectIndex, 1);
                        selectedMaterias.splice(subjectIndex, 1);
                        lastChecked = subject.nameSubject + ' - ' + subject.section + ' - ' + subject.name;
                    }
                }
                
                document.getElementById('selectedMaterias').value = selectedMaterias.join(',');
                updateSubjectList(selectedSubjects, lastChecked);
            });
        });
    }
    
    function updateSubjectList(selectedSubjects, lastChecked) {
        let subjectList = document.getElementById('subject-pos');
        // Clean the list of subjects before updating it
        while (subjectList.firstChild) {
            subjectList.removeChild(subjectList.firstChild);
        }
    
        // Add selected subjects as <li> elements
        selectedSubjects.forEach(function (subject) {
            let li = document.createElement('li');
            li.textContent = subject;
            subjectList.appendChild(li);
        });
    
        if (selectedSubjects.length === 0) {
            // No se ha seleccionado ningún checkbox, así que borramos el valor de preIDC
            preIDC.value = "";
        } else {
            if (!preIDC.value === true && !selectedSubjects.includes(preIDC.value) === true) {
                preIDC.value = "";
            } else if (!preIDC.value === false && !selectedSubjects.includes(preIDC.value) === true) {
                preIDC.value = "";
            }
        }
    }

    function clearSelect(enrolledSubjectsSelect) {
        while (enrolledSubjectsSelect.firstChild) {
            enrolledSubjectsSelect.removeChild(enrolledSubjectsSelect.firstChild);
        }
    }
});