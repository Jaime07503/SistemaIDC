document.addEventListener('DOMContentLoaded', function () {
    let minSelected = 2; // Mínimo de checkboxes permitidos
    let maxSelected = 5; // Máximo de checkboxes permitidos
    let selectedStudentIds = []; // Array para almacenar los studentId seleccionados
    let selectedStudentIdsInput = document.getElementById('selectedStudentIds'); // Input oculto

    document.querySelectorAll('.checkbox-input').forEach(function (input) {
        input.addEventListener('change', function () {
            let checkedCheckboxes = document.querySelectorAll('.checkbox-input:checked');

            if (input.checked) {
                if (checkedCheckboxes.length > maxSelected) {
                    input.checked = false; // No permitir seleccionar más de 5
                } else {
                    // Agregar el studentId seleccionado al array
                    selectedStudentIds.push(input.value);
                }
            } else {
                // Eliminar el studentId deseleccionado del array
                selectedStudentIds = selectedStudentIds.filter(id => id !== input.value);
            }

            // Actualizar el valor del campo oculto con los valores seleccionados
            selectedStudentIdsInput.value = selectedStudentIds.join(',');

            // Puedes hacer algo con el array selectedStudentIds si es necesario
            console.log(selectedStudentIds);
        });
    });
});
