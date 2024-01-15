document.addEventListener("DOMContentLoaded", function () {
    // Variables
 const listboxes = document.querySelectorAll(".custom-listbox");
 let openListbox = null;

 // Custom Listbox
 listboxes.forEach(function (listbox) {
     handleListbox(listbox);
 });

 function handleListbox(listbox) {
     const listboxHeader = listbox.querySelector(".listbox-header");
     const optionsList = listbox.querySelector(".options");
     const arrowDown = listbox.querySelector(".arrow-down");
     const selectedOptionSpan = listbox.querySelector(".selected-option");

     listboxHeader.addEventListener("click", function () {
         if (openListbox && openListbox !== listbox) {
             openListbox.querySelector(".options").style.display = "none";
             openListbox.querySelector(".arrow-down").style.transform = "rotate(0deg)";
             openListbox.querySelector(".listbox-header").classList.remove("active");
         }

         listboxHeader.classList.toggle("active");
         optionsList.style.display = optionsList.style.display === "block" ? "none" : "block";
         arrowDown.style.transform = optionsList.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)";
         openListbox = listbox;
     });

     optionsList.addEventListener("click", function (event) {
         if (event.target.tagName === "LI") {
             const selectedOption = event.target.textContent;
             selectedOptionSpan.textContent = selectedOption;
             optionsList.style.display = "none";
             arrowDown.style.transform = "rotate(0deg)";
             listboxHeader.classList.remove("active");

             markSelectedOption(event.target);
         }
     });

     // Función para agregar o quitar el ícono de verificación a la opción seleccionada
     function markSelectedOption(selectedListItem) {
         const options = optionsList.querySelectorAll("li");
         options.forEach(function (option) {
             option.classList.remove("selected");
             option.innerHTML = option.textContent; // Limpiar el contenido HTML
         });

         selectedListItem.classList.add("selected");
         selectedListItem.innerHTML = '<i class="fa-solid fa-check"></i> ' + selectedListItem.textContent;
     }
 }
 
    const textareas = document.querySelectorAll(".textarea");
    textareas.forEach(textarea => {
        textarea.addEventListener('keyup', e => {
            textarea.style.height = "2.95rem"; // Establece una altura mínima
            let scHeight = e.target.scrollHeight;
            console.log(scHeight);
            textarea.style.height = `${scHeight}px`;
        });
    });

    const fileContainers = document.querySelectorAll('.file-container');

    fileContainers.forEach(function(fileContainer) {
        fileContainer.addEventListener('click', function () {
            const inputFile = this.querySelector('.file-input');
            const imgArea = this.querySelector('.img-area');
    
            inputFile.click(); // Hacer clic directamente en el input file
    
            inputFile.addEventListener('change', function () {
                const image = this.files[0];
    
                if (image && image.size < 2000000) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        const allImgs = imgArea.querySelectorAll('img');
                        allImgs.forEach(item => item.remove());
    
                        const imgUrl = reader.result;
                        const img = document.createElement('img');
                        img.src = imgUrl;
                        imgArea.appendChild(img);
                        imgArea.classList.add('active');
                        imgArea.dataset.img = image.name;
                    };
                    reader.readAsDataURL(image);
                } else {
                    alert("La imagen debe ser menor que 2MB");
                }
            });
        });
    });

    var textarea = document.getElementById("miTextarea");

    textarea.addEventListener("input", function () {
        ajustarAltura(textarea);
    });

    // Ajusta la altura inicial
    //ajustarAltura(textarea);

    function ajustarAltura(elemento) {
        elemento.style.height = "auto"; // Restablece la altura a auto para obtener la altura total
        elemento.style.height = Math.min(elemento.scrollHeight, 120) + "px"; // Limita la altura al máximo de 120px
    }

    // Función para mostrar un modal
    function showModal(modal) {
        modal.style.display = 'block';
    }

    // Función para cerrar un modal
    function closeModal(modal) {
        modal.style.display = 'none';
    }

    // Obtén referencias a los elementos relevantes
    var modals = {
        info: document.getElementById('myModalInfo'),
        objetivoGeneral: document.getElementById('myModalObjetivoGeneral'),
        objetivoEspecifico: document.getElementById('myModalObjetivoEspecifico')
    };

    var btns = {
        addInfo: document.getElementById('btnAddInfo'),
        addObjetivoGeneral: document.getElementById('btnAddObjetivoGeneral'),
        addObjetivoEspecifico: document.getElementById('btnAddObjetivoEspecifico')
    };

    var closeBtns = {
        info: document.getElementById('cerrarModalInfo'),
        objetivoGeneral: document.getElementById('cerrarModalObjetivoGeneral'),
        objetivoEspecifico: document.getElementById('cerrarModalObjetivoEspecifico')
    };

    // Funciones para mostrar y cerrar modales al hacer clic
    function handleModalClick(event, modal) {
        if (event.target === modal) {
            closeModal(modal);
        }
    }

    function handleAddButtonClick(modal) {
        return function () {
            showModal(modal);
        };
    }

    function handleCloseButtonClick(modal) {
        return function () {
            closeModal(modal);
        };
    } 

    // Asignar eventos
    btns.addInfo.addEventListener('click', handleAddButtonClick(modals.info));
    btns.addObjetivoGeneral.addEventListener('click', handleAddButtonClick(modals.objetivoGeneral));
    btns.addObjetivoEspecifico.addEventListener('click', handleAddButtonClick(modals.objetivoEspecifico));

    closeBtns.info.addEventListener('click', handleCloseButtonClick(modals.info));
    closeBtns.objetivoGeneral.addEventListener('click', handleCloseButtonClick(modals.objetivoGeneral));
    closeBtns.objetivoEspecifico.addEventListener('click', handleCloseButtonClick(modals.objetivoEspecifico));

    // Cierra el modal si se hace clic fuera de él
    window.addEventListener('click', function (event) {
        if (event.target === modals.info) {
            closeModal(modals.info);
        } else if (event.target === modals.objetivoGeneral) {
            closeModal(modals.objetivoGeneral);
        } else if (event.target === modals.objetivoEspecifico) {
            closeModal(modals.objetivoEspecifico);
        }
    });
});