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

    const formSARDC = document.getElementById('formSARDC')
    const fileInputSARDC = document.getElementById('btn-file-SARDC')
    
    if (formSARDC && fileInputSARDC) {
        fileInputSARDC.addEventListener('change', function() {
            if (fileInputSARDC.files.length > 0) {
                formSARDC.submit()
            }
        })
    }

    const formSARDCO = document.getElementById('formSARDCO')
    const fileInputSARDCO = document.getElementById('btn-file-SARDCO')
    
    if (formSARDCO && fileInputSARDCO) {
        fileInputSARDCO.addEventListener('change', function() {
            if (fileInputSARDCO.files.length > 0) {
                formSARDCO.submit()
            }
        })
    }
})