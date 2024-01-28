document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formSARC')
    const fileInput = document.getElementById('btn-file-SARC')
    
    if (form && fileInput) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                form.submit()
            }
        })
    }

    const formDI = document.getElementById('formSARDI')
    const fileInputDI = document.getElementById('btn-file-SARDI')
    
    if (formDI && fileInputDI) {
        fileInputDI.addEventListener('change', function() {
            if (fileInputDI.files.length > 0) {
                formDI.submit()
            }
        })
    }

    const formSC = document.getElementById('formSARCO')
    const fileInputSC = document.getElementById('btn-file-SARCO')
    
    if (formSC && fileInputSC) {
        fileInputSC.addEventListener('change', function() {
            if (fileInputSC.files.length > 0) {
                formSC.submit()
            }
        })
    }
})