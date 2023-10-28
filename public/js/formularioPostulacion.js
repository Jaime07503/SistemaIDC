document.addEventListener("DOMContentLoaded", function () {
    // Variables
    const yesRadioButton = document.getElementById("option-yes");
    const noRadioButton = document.getElementById("option-no");
    const inputBox = document.getElementById("input-box");
    const listboxes = document.querySelectorAll(".custom-listbox");
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

    // Custom Listbox
    listboxes.forEach(function (listbox) {
        handleListbox(listbox);
    });

    // Add an event to detect the change in the radio button
    yesRadioButton.addEventListener("change", function() {
        if (yesRadioButton.checked) {
            inputBox.style.display = "block"; // Show radio-button
            toggleInputRequired(true);
        } else {
            inputBox.style.display = "none"; // Hidden radio-button
        }
    });

    noRadioButton.addEventListener("change", function() {
        if (noRadioButton.checked) {
            inputBox.style.display = "none"; // Hidden radio-button
            toggleInputRequired(false);
        }
    });

    // Add or remove the require property to the participated-idc-input
    function toggleInputRequired(isRequired) {
        const inputElement = document.getElementById("participated-idc-input");
    
        if (isRequired) {
            inputElement.setAttribute("required", "required");
        } else {
            inputElement.removeAttribute("required");
            inputElement.value = "";
        }
    }

    // Features
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
            if(event.target.tagName === "LI"){
                const selectedOption = event.target.textContent;
                listbox.querySelector(".selected-option").textContent = selectedOption;
                optionsList.style.display = "none";
                arrowDown.style.transform = "rotate(0deg)";
                if (listbox.className === "custom-listbox career" && (document.getElementById("career").textContent !== "Carrera" && document.getElementById("year").textContent !== "Año")
                || listbox.className === "custom-listbox year" && (document.getElementById("career").textContent !== "Carrera" && document.getElementById("year").textContent !== "Año")) {
                    getSubjects();
                }
            }
        });
    }
    
    function getSubjects() {
        careerSelect = document.querySelector('#career');
        yearSelect = document.querySelector('#year');

        let career = careerSelect.textContent;
        let year = yearSelect.textContent;

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
        jsonSubjects.forEach(function (subject, index) {
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

            // Create the div element with class "checkbox-box"
            let checkboxBox = document.createElement('div');
            checkboxBox.className = 'checkbox-box';

            // Set the name of the subject
            let textNode = document.createTextNode(subject.nameSubject);

            // Add input, div and text to label
            label.appendChild(input);
            label.appendChild(checkboxBox);
            label.appendChild(textNode);

            // Add label to listbox
            enrolledSubjectsSelect.append(label);

             // Add a change event (when checked/unchecked)
            input.addEventListener('change', function () {
                if (input.checked) {
                    // Add the selected matter to the array
                    selectedSubjects.push(subject);
                } else {
                    // Remove deselected matter from the array
                    const index = selectedSubjects.indexOf(subject);
                    if (index !== -1) {
                        selectedSubjects.splice(index, 1);
                    }
                }

                updateSubjectList(selectedSubjects);
            });
        });
    }

    function updateSubjectList(selectedSubjects) {
        let subjectList = document.getElementById('subject-pos');
        // Clean the list of subjects before updating it
        while (subjectList.firstChild) {
            subjectList.removeChild(subjectList.firstChild);
        }

        // Add selected subjects as <li> elements
        selectedSubjects.forEach(function (subject) {
            let li = document.createElement('li');
            li.textContent = subject.nameSubject;
            subjectList.appendChild(li);
        });
    }

    function clearSelect(enrolledSubjectsSelect) {
        while (enrolledSubjectsSelect.firstChild) {
            enrolledSubjectsSelect.removeChild(enrolledSubjectsSelect.firstChild);
        }
    }
});