document.addEventListener('DOMContentLoaded', function() {
    const formTS = document.getElementById('formTSRC')
    const fileInputTS = document.getElementById('btn-file-TSRC')
    
    if (formTS && fileInputTS) {
        fileInputTS.addEventListener('change', function() {
            if (fileInputTS.files.length > 0) {
                formTS.submit()
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

    const form = document.getElementById('formSARC')
    const fileInput = document.getElementById('btn-file-SARC')
    
    if (form && fileInput) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                form.submit()
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

    const formNTRCO = document.getElementById('formNTRCO')
    const fileInputNTRCO = document.getElementById('btn-file-NTRCO')
    
    if (formNTRCO && fileInputNTRCO) {
        fileInputNTRCO.addEventListener('change', function() {
            if (fileInputNTRCO.files.length > 0) {
                formNTRCO.submit();
            }
        });
    }


    const formNRE = document.getElementById('formNTRC')
    const fileInputNRE = document.getElementById('btn-file-NTRC')
    
    if (formNRE && fileInputNRE) {
        fileInputNRE.addEventListener('change', function() {
            if (fileInputNRE.files.length > 0) {
                formNRE.submit();
            }
        });
    }
})