document.addEventListener("DOMContentLoaded", function () {
    const textareas = document.querySelectorAll(".textarea");
    textareas.forEach(textarea => {
        textarea.addEventListener('keyup', e => {
            textarea.style.height = "2.95rem"; // Establece una altura mínima
            let scHeight = e.target.scrollHeight;
            textarea.style.height = `${scHeight}px`;
        });
    });

    // document.getElementById('myForm').addEventListener('submit', function() {
    //     var tableData = [];
    //     var tableRows = document.querySelectorAll('.export-table tbody tr');

    //     tableRows.forEach(function(row) {
    //         var rowData = {
    //             bibliographicSourceId: row.cells[0].innerText,
    //             year: row.cells[1].innerText,
    //             author: row.cells[2].innerText,
    //             bibliographicSourceType: row.cells[3].innerText,
    //             averageType: row.cells[4].innerText,
    //             link: row.cells[5].innerText,
    //         };

    //         tableData.push(rowData);
    //     });

    //     // Agregar los datos al campo de formulario
    //     var input = document.createElement('input');
    //     input.type = 'hidden';
    //     input.name = 'datos';
    //     input.value = JSON.stringify(tableData);

    //     document.getElementById('myForm').appendChild(input);
    // });

    // btnAdd = document.getElementById("btnAdd");
    // btnAddInfo = document.getElementById("btnAddInfo");

    // btnAdd.addEventListener('click', function (){
    //     agregarFila();
    // });

    // btnAddInfo.addEventListener('click', function (){
    //     agregarFilaInfo();
    // });

    // function agregarFila() {
    //     // Obtén el valor del input de objetivo específico
    //     var objetivoEspecifico = document.getElementById("objetivoEspecifico").value;

    //     // Obtén la referencia de la tabla
    //     var tabla = document.getElementById("data-table").getElementsByTagName('tbody')[0];

    //     // Crea una nueva fila
    //     var fila = tabla.insertRow();

    //     // Crea celdas en la nueva fila
    //     var celdaNumero = fila.insertCell(0);
    //     var celdaEstudiante = fila.insertCell(1);
    //     var celdaObjetivo = fila.insertCell(2);

    //     // Asigna valores a las celdas
    //     celdaNumero.innerHTML = tabla.rows.length; // Número de la nueva fila
    //     celdaEstudiante.innerHTML = "Nombre del estudiante";
    //     celdaObjetivo.innerHTML = objetivoEspecifico;

    //     // Crear un nuevo elemento <textarea>
    //     // var textarea = document.createElement("textarea");
    //     // textarea.className = "textarea";
    //     // textarea.name = "objetivoEspecifico" + tabla.rows.length;
    //     // textarea.value = objetivoEspecifico;  // Asigna el valor al contenido del textarea

    //     // Agrega el <textarea> a la celda
    //     // celdaObjetivo.appendChild(textarea);

    //     // Limpia el valor del input después de agregar la fila
    //     document.getElementById("objetivoEspecifico").value = "";
    // }

    // function agregarFilaInfo() {
    //     // Obtén los valores de los inputs
    //     var fuente = document.getElementById("fuente").value;
    //     var autor = document.getElementById("autor").value;
    //     var ano = document.getElementById("año").value;
    //     var tipoMedio = document.getElementById("tipoMedio").value;
    //     var enlace = document.getElementById("enlace").value;
    
    //     // Obtén la referencia de la tabla
    //     var tabla = document.getElementById("data-table-2").getElementsByTagName('tbody')[0];
    
    //     // Crea una nueva fila
    //     var fila = tabla.insertRow();
    
    //     // Crea celdas en la nueva fila
    //     var celdaNumero = fila.insertCell(0);
    //     var celdaFuente = fila.insertCell(1);
    //     var celdaAutor = fila.insertCell(2);
    //     var celdaAno = fila.insertCell(3);
    //     var celdaTipoMedio = fila.insertCell(4);
    //     var celdaEnlace = fila.insertCell(5);
    
    //     // Asigna valores a las celdas
    //     celdaNumero.innerHTML = tabla.rows.length;
    //     celdaFuente.innerHTML = fuente;
    //     celdaAutor.innerHTML = autor;
    //     celdaAno.innerHTML = ano;
    //     celdaTipoMedio.innerHTML = tipoMedio;
    
    //     // Crea un elemento de enlace y asigna los atributos al enlace
    //     var enlaceElemento = document.createElement("a");
    //     enlaceElemento.href = enlace;
    //     enlaceElemento.textContent = enlace;
    
    //     // Agrega los atributos al enlace
    //     enlaceElemento.target = "_blank"; // Puedes cambiar "_blank" según tus necesidades
    //     enlaceElemento.rel = "noreferrer"; // Puedes ajustar esto según tus necesidades
    //     enlaceElemento.className = "link"; // Puedes ajustar la clase según tus necesidades
    
    //     // Agrega el elemento de enlace como hijo de la celda
    //     celdaEnlace.appendChild(enlaceElemento);
    
    //     // Limpia los valores de los inputs después de agregar la fila
    //     document.getElementById("fuente").value = "";
    //     document.getElementById("autor").value = "";
    //     document.getElementById("año").value = "";
    //     document.getElementById("tipoMedio").value = "";
    //     document.getElementById("enlace").value = "";
    // }

    document.getElementById('myForm').addEventListener('submit', function (event) {
        // Evitar que el formulario se envíe automáticamente
        event.preventDefault();

        // Obtener los datos de la tabla
        var datosTabla = obtenerDatosDeLaTabla();

        // Agregar los datos como un campo oculto al formulario
        var inputDatos = document.createElement('input');
        inputDatos.type = 'hidden';
        inputDatos.name = 'datos';
        inputDatos.value = JSON.stringify(datosTabla);
        this.appendChild(inputDatos);

        // Enviar el formulario
        this.submit();
    });

    function obtenerDatosDeLaTabla() {
        var datosTabla = [];

        // Iterar sobre las filas de la tabla
        var filas = document.getElementById('data-table-2').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        for (var i = 0; i < filas.length; i++) {
            var celdas = filas[i].getElementsByTagName('td');
            var filaDatos = {
                sourceId: celdas[0].innerText,
                year: celdas[1].innerText,
                author: celdas[2].innerText,
                source: celdas[3].innerText,
                mediaType: celdas[4].innerText,
                link: celdas[5].innerText
            };
            datosTabla.push(filaDatos);
        }

        return datosTabla;
    }

    // function sortTableByColumn(table, column, asc = true) {
    //     const dirModifier = asc ? 1 : -1;
    //     const tBody = table.tBodies[0];
    //     const rows = Array.from(tBody.querySelectorAll("tr"));
    
    //     // Sort each row
    //     const sortedRows = rows.sort((a, b) => {
    //         const aColText = a.querySelector(`td:nth-child(${column + 1})`).textContent.trim();
    //         const bColText = b.querySelector(`td:nth-child(${column + 1})`).textContent.trim();
    
    //         return aColText > bColText ? (1 * dirModifier) : (-1 * dirModifier);
    //     });
    
    //     // Remove all existing TRs from the table
    //     while (tBody.firstChild) {
    //         tBody.removeChild(tBody.firstChild);
    //     }
    
    //     // Re-add the newly sorted rows
    //     tBody.append(...sortedRows);
    
    //     // Remember how the column is currently sorted
    //     table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
    //     table.querySelector(`th:nth-child(${column + 1})`).classList.toggle("th-sort-asc", asc);
    //     table.querySelector(`th:nth-child(${column + 1})`).classList.toggle("th-sort-desc", !asc);
    // }
    
    // document.querySelectorAll(".content-table th").forEach(headerCell => {
    //     headerCell.addEventListener("click", () => {
    //         const tableElement = headerCell.parentElement.parentElement.parentElement;
    //         const headerIndex = Array.prototype.indexOf.call(headerCell.parentElement.children, headerCell);
    //         const currentIsAscending = headerCell.classList.contains("th-sort-asc");
    
    //         sortTableByColumn(tableElement, headerIndex, !currentIsAscending);
    //     });
    // });

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