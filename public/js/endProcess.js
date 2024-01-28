document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formNTRC')
    const fileInput = document.getElementById('btn-file-NTRC')
    
    if (form && fileInput) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                form.submit();
            }
        });
    }

    const formCO = document.getElementById('formNTRCO')
    const fileInputCO = document.getElementById('btn-file-NTRCO')
    
    if (formCO && fileInputCO) {
        fileInputCO.addEventListener('change', function() {
            if (fileInputCO.files.length > 0) {
                formCO.submit();
            }
        });
    }
})