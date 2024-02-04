document.addEventListener('DOMContentLoaded', function () {
    let buttons = document.querySelectorAll('.lt-button--click-faculty, .lt-button--click-career, .lt-button--click-subject');

    function toggleSection(button) {
        let arrowIcon = button.querySelector('.lt-arrow');
        let section = button.nextElementSibling;

        let siblingSections = button.parentElement.querySelectorAll('.lt-show-careers, .lt-show-subjects, .lt-show-researchTopics');
        siblingSections.forEach(sibling => {
            if (sibling !== section) {
                sibling.style.height = "0";
            }
        });

        if (section.style.height === "0px" || section.style.height === "") {
            section.style.height = 'auto'
            arrowIcon.classList.add('arrow');
        } else {
            section.style.height = "0";
            arrowIcon.classList.remove('arrow');
        }
    }

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            toggleSection(button);
        });
    });
});