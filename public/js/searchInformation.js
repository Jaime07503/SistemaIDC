document.addEventListener('DOMContentLoaded', function() {
    const formTSRCCO = document.getElementById('formTSRCCO')
    const fileInputTSRCCO = document.getElementById('btn-file-TSRCCO')
    
    if (formTSRCCO && fileInputTSRCCO) {
        fileInputTSRCCO.addEventListener('change', function() {
            if (fileInputTSRCCO.files.length > 0) {
                formTSRCCO.submit()
            }
        })
    }

    const formCO = document.getElementById('formTSRCO')
    const fileInputCO = document.getElementById('btn-file-TSRCO')
    
    if (formCO && fileInputCO) {
        fileInputCO.addEventListener('change', function() {
            if (fileInputCO.files.length > 0) {
                formCO.submit()
            }
        })
    }
})