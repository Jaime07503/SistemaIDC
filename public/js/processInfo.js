document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formAditionalDocument')
    const fileInput = document.getElementById('btn-file-ad')
    
    if (form && fileInput) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                form.submit()
            }
        })
    }
})