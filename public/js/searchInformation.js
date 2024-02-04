document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formTSRC')
    const fileInput = document.getElementById('btn-file-TSRC')
    
    if (form && fileInput) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                form.submit()
            }
        })
    }

    const formTSRCC = document.getElementById('formTSRCC')
    const fileInputTSRCC = document.getElementById('btn-file-TSRCC')
    
    if (formTSRCC && fileInputTSRCC) {
        fileInputTSRCC.addEventListener('change', function() {
            if (fileInputTSRCC.files.length > 0) {
                formTSRCC.submit()
            }
        })
    }

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