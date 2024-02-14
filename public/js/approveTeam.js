document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("searchInput")
    const cardsTeams = document.querySelectorAll(".team-content")

    if(input && cardsTeams) {
        input.addEventListener("input", function() {
            const inputValue = input.value.toLowerCase().trim()
            filterCardsSubjectByInput(inputValue)
        })
    
        function filterCardsSubjectByInput(inputValue) {
            cardsTeams.forEach(function(card) {
                const subject = card.querySelector(".subject").textContent.toLowerCase()
                const themeName = card.querySelector(".themeName").textContent.toLowerCase()
                if (subject.includes(inputValue.toLowerCase().trim()) ||
                themeName.includes(inputValue.toLowerCase().trim())) {
                    card.style.display = "flex"
                } else {
                    card.style.display = "none"
                }
            })
        }
    }
})