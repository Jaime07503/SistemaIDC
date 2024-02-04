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

    const inputResearchTopic = document.getElementById("input-researchTopic")
    const cardsResearchTopics = document.querySelectorAll(".cards-researchTopics")

    inputResearchTopic.addEventListener("input", function() {
        const inputValue = inputResearchTopic.value.toLowerCase().trim()
        filterCardsSubjectByInput(inputValue)
    })

    function filterCardsSubjectByInput(inputValue) {
        cardsResearchTopics.forEach(function(card) {
            const cardLink = card.querySelector(".card-link").textContent.toLowerCase()
            if (cardLink.includes(inputValue.toLowerCase().trim())) {
                card.style.display = "block"
            } else {
                card.style.display = "none"
            }
        })
    }
})