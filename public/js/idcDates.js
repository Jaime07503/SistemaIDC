document.addEventListener('DOMContentLoaded', function(){
    const formDatesIdc = document.getElementById('formDatesIdc')
    formDatesIdc.addEventListener('submit', function(event) {
        const datepickers = document.querySelectorAll(".datepicker")
        for(const datepicker of datepickers) {
            if (datepicker.value.trim() === '') {
                showNotification(`Por favor, selecciona una fecha "${datepicker.placeholder}"`, true, '#notificationD')
                event.preventDefault()
                return
            }
        }
    })

    function showNotification(message, isError = false, notificationId) {
        const notification = document.querySelector(notificationId)
    
        if (notification) {
            notification.textContent = message
            notification.className = isError ? 'notificationM error' : 'notificationM'
            notification.style.display = 'block'
    
            setTimeout(function () {
                notification.style.display = 'none'
            }, 3000)
        }
    }
})