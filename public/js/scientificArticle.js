document.addEventListener('DOMContentLoaded', function() {
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