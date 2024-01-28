document.addEventListener('DOMContentLoaded', function () {
    let minSelected = 2
    let maxSelected = 5
    let selectedStudentIds = []
    let selectedStudentIdsInput = document.getElementById('selectedStudentIds')
    let submitButton = document.getElementById('submitButton')
    const notification = document.getElementById('notification');

    submitButton.addEventListener('click', function (event) {
        if (selectedStudentIds.length < minSelected || selectedStudentIds.length > maxSelected) {
            event.preventDefault()
            console.log('click')
            showNotification('Debes seleccionar entre 2 a 5 alumnos máximo.', true)
        }
    })

    function showNotification(message, isError = false) {
        notification.textContent = message
        notification.className = isError ? 'notification error' : 'notification'
        notification.style.display = 'block'

        setTimeout(function () {
            notification.style.display = 'none'
        }, 3000)
    }

    document.querySelectorAll('.checkbox-input').forEach(function (input) {
        input.addEventListener('change', function () {
            let checkedCheckboxes = document.querySelectorAll('.checkbox-input:checked')

            if (input.checked) {
                if (checkedCheckboxes.length > maxSelected) {
                    input.checked = false
                } else {
                    selectedStudentIds.push(input.value)
                }
            } else {
                selectedStudentIds = selectedStudentIds.filter(id => id !== input.value)
            }

            selectedStudentIdsInput.value = selectedStudentIds.join(',')
        })
    })
})