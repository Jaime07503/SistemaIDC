document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formTSRC')
    const fileInput = document.getElementById('btn-file-TSRC')
    
    if (form && fileInput) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                form.submit();
            }
        });
    }

    const formCO = document.getElementById('formTSRCO')
    const fileInputCO = document.getElementById('btn-file-TSRCO')
    
    if (formCO && fileInputCO) {
        fileInputCO.addEventListener('change', function() {
            if (fileInputCO.files.length > 0) {
                formCO.submit();
            }
        });
    }
})