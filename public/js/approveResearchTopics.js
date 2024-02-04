document.addEventListener("DOMContentLoaded", function () {
    const listboxes = document.querySelectorAll(".custom-listbox")
    let openListbox = null
    const nameFacultyInput = document.querySelector('.nameFaculty')

    listboxes.forEach(function (listbox) {
        handleListbox(listbox)
    })

    function handleListbox(listbox) {
        const listboxHeader = listbox.querySelector(".listbox-header")
        const optionsList = listbox.querySelector(".options")
        const arrowDown = listbox.querySelector(".arrow-down")
        const selectedOptionSpan = listbox.querySelector(".selected-option")

        listboxHeader.addEventListener("click", function () {
            if (openListbox && openListbox !== listbox) {
                openListbox.querySelector(".options").style.display = "none"
                openListbox.querySelector(".arrow-down").style.transform = "rotate(0deg)"
                openListbox.querySelector(".listbox-header").classList.remove("active")
            }

            listboxHeader.classList.toggle("active")
            optionsList.style.display = optionsList.style.display === "block" ? "none" : "block"
            arrowDown.style.transform = optionsList.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)"
            openListbox = listbox
        })

        optionsList.addEventListener("click", function (event) {
            if (event.target.tagName === "LI") {
                const selectedOption = event.target.textContent
                selectedOptionSpan.textContent = selectedOption
                selectedOptionSpan.setAttribute('data-value', selectedOptionSpan.textContent)
                optionsList.style.display = "none"
                arrowDown.style.transform = "rotate(0deg)"
                listboxHeader.classList.remove("active")
                var facultyId = event.target.getAttribute('data-value')
                nameFacultyInput.value = facultyId
                markSelectedOption(event.target)

                if(listbox.classList.contains("faculty-lst")){
                    const idFaculty = document.querySelector('.idFaculty')
                    idFaculty.value = facultyId
                }
            }
        })

        function markSelectedOption(selectedListItem) {
            const options = optionsList.querySelectorAll("li")
            options.forEach(function (option) {
                option.classList.remove("selected")
                option.innerHTML = option.textContent
            })

            selectedListItem.classList.add("selected")
            selectedListItem.innerHTML = '<i class="fa-solid fa-check"></i> ' + selectedListItem.textContent
        }
    }

    const searchInput = document.getElementById('searchInput')
    const topicsListbox = document.getElementById('topicsListbox')
    const tableRows = document.querySelectorAll('#data-table-topics tbody tr')

    searchInput.addEventListener('input', filterTable)

    const optionsList = document.querySelector('.custom-listbox .options');
    if (optionsList) {
        optionsList.addEventListener('click', function(event) {
            if (event.target.tagName === 'LI') {
                const selectedOption = event.target.textContent.trim();
                topicsListbox.querySelector('.selected-option').textContent = selectedOption;
                filterTable();
            }
        });
    }
    
    function filterTable() {
        const searchText = searchInput.value.trim().toLowerCase();
        const selectedSubject = topicsListbox.querySelector('.selected-option').textContent.trim().toLowerCase();
    
        tableRows.forEach(function(row) {
            const subjectText = row.querySelector('td[data-values="Materia"]').textContent.trim().toLowerCase();
            const topicText = row.querySelector('td[data-values="Tema"]').textContent.trim().toLowerCase();
    
            const containsSearchText = subjectText.includes(searchText) || topicText.includes(searchText);
            const matchesSelectedSubject = selectedSubject === 'todos' || subjectText === selectedSubject;
    
            if (matchesSelectedSubject && containsSearchText) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
})