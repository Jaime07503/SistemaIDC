document.addEventListener("DOMContentLoaded", function () {
    const listboxes = document.querySelectorAll(".custom-listbox")
    let openListbox = null

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
                optionsList.style.display = "none"
                arrowDown.style.transform = "rotate(0deg)"
                listboxHeader.classList.remove("active")

                markSelectedOption(event.target)
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

    const inputSubject = document.getElementById("input-subject")
    const cardsCourses = document.querySelectorAll(".card-courses")

    if(inputSubject && cardsCourses) {
        inputSubject.addEventListener("input", function() {
            const inputValue = inputSubject.value.toLowerCase().trim()
            filterCardsSubjectByInput(inputValue)
        })
    
        function filterCardsSubjectByInput(inputValue) {
            cardsCourses.forEach(function(card) {
                const cardLink = card.querySelector(".card-link").textContent.toLowerCase()
                if (cardLink.includes(inputValue.toLowerCase().trim())) {
                    card.style.display = "block"
                } else {
                    card.style.display = "none"
                }
            })
        }
    }

    const inputTeam = document.getElementById("input-team")
    const cardsTeams = document.querySelectorAll(".card-teams")

    if(inputTeam && cardsTeams){  
        inputTeam.addEventListener("input", function() {
            const inputValue = inputTeam.value.toLowerCase().trim()
            filterCardsTeamsByInput(inputValue)
        })

        function filterCardsTeamsByInput(inputValue) {
            cardsTeams.forEach(function(card) {
                const cardLink = card.querySelector(".card-link").textContent.toLowerCase()
                if (cardLink.includes(inputValue.toLowerCase().trim())) {
                    card.style.display = "block"
                } else {
                    card.style.display = "none"
                }
            })
        }
    }
})