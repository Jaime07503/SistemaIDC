document.addEventListener("DOMContentLoaded", function () {
    const inputIdc = document.getElementById("input-idc")
    const cardsIdcs = document.querySelectorAll(".card-idcs")

    if(inputIdc && cardsIdcs) {
        inputIdc.addEventListener("input", function() {
            const inputValue = inputIdc.value.toLowerCase().trim()
            filterCardsSubjectByInput(inputValue)
        })
    
        function filterCardsSubjectByInput(inputValue) {
            cardsIdcs.forEach(function(card) {
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