document.addEventListener('DOMContentLoaded', function () {
    let facultyButtons = document.querySelectorAll('.lt-button--click-faculty');
    let careerButtons = document.querySelectorAll('.lt-button--click-career');
    let subjectButtons = document.querySelectorAll('.lt-button--click-subject');

    function toggleSection(button) {
        let arrowIcon = button.querySelector('.lt-arrow');
        let section = button.nextElementSibling;

        // Cierra todos los elementos padres
        let parentSection = button.closest('.lt-show-careers, .lt-show-subjects, .lt-show-researchTopics');
        let parentSections = document.querySelectorAll('.lt-show-careers, .lt-show-subjects, .lt-show-researchTopics');
        parentSections.forEach(parent => {
            if (parent !== parentSection) {
                parent.style.height = "0";
            }
        });

        // Abre o cierra la sección actual
        if (section.style.height === "0px" || section.style.height === "") {
            section.style.height = `${section.scrollHeight}px`;
            arrowIcon.classList.add('arrow');
        } else {
            section.style.height = "0";
            arrowIcon.classList.remove('arrow');
        }
    }

    facultyButtons.forEach(button => {
        button.addEventListener('click', () => {
            toggleSection(button);
        });
    });

    careerButtons.forEach(button => {
        button.addEventListener('click', () => {
            toggleSection(button);
        });
    });

    subjectButtons.forEach(button => {
        button.addEventListener('click', () => {
            toggleSection(button);
        });
    });
});