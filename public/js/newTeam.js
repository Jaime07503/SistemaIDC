document.addEventListener('DOMContentLoaded', function () {
    let minSelected = 2; // Mínimo de checkboxes permitidos
    let maxSelected = 5; // Máximo de checkboxes permitidos
    let selectedStudentIds = []; // Array para almacenar los studentId seleccionados
    let selectedStudentIdsInput = document.getElementById('selectedStudentIds'); // Input oculto
    let submitButton = document.getElementById('submitButton'); // Botón de envío del formulario

    // Función para habilitar/deshabilitar el botón de envío
    function toggleSubmitButton() {
        if (selectedStudentIds.length >= minSelected && selectedStudentIds.length <= maxSelected) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    document.querySelectorAll('.checkbox-input').forEach(function (input) {
        input.addEventListener('change', function () {
            let checkedCheckboxes = document.querySelectorAll('.checkbox-input:checked');

            if (input.checked) {
                if (checkedCheckboxes.length > maxSelected) {
                    input.checked = false;
                } else {
                    selectedStudentIds.push(input.value);
                }
            } else {
                // Eliminar el studentId deseleccionado del array
                selectedStudentIds = selectedStudentIds.filter(id => id !== input.value);
            }

            // Actualizar el valor del campo oculto con los valores seleccionados
            selectedStudentIdsInput.value = selectedStudentIds.join(',');

            // Verificar y actualizar la habilitación del botón de envío
            toggleSubmitButton();
        });
    });

    // Inicialmente, deshabilitar el botón de envío
    toggleSubmitButton();
});