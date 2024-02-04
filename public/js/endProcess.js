document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll(".textarea");
    textareas.forEach(textarea => {
        textarea.addEventListener('keyup', e => {
            textarea.style.height = "2.95rem"; 
            let scHeight = e.target.scrollHeight;
            textarea.style.height = `${scHeight}px`;
        });
    });

    const formNTRCO = document.getElementById('formNTRCO')
    const fileInputNTRCO = document.getElementById('btn-file-NTRCO')
    
    if (formNTRCO && fileInputNTRCO) {
        fileInputNTRCO.addEventListener('change', function() {
            if (fileInputNTRCO.files.length > 0) {
                formNTRCO.submit();
            }
        });
    }

    const formNTRCOC = document.getElementById('formNTRCOC')
    const fileInputNTRCOC = document.getElementById('btn-file-NTRCOC')
    
    if (formNTRCOC && fileInputNTRCOC) {
        fileInputNTRCOC.addEventListener('change', function() {
            if (fileInputNTRCOC.files.length > 0) {
                formNTRCOC.submit();
            }
        });
    }

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

    const formCommentStudent = document.getElementById('formCommentStudent');
    if (formCommentStudent) {
        formCommentStudent.addEventListener('submit', function (event) {
            event.preventDefault();

            const textareas = document.querySelectorAll("#formCommentStudent .textareaC");
            for (const textarea of textareas) {
                if (textarea.value.trim() === '') {
                    showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationCS');
                    return;
                }
            }

            formCommentStudent.submit();
        });
    }

    const formCommentTeacher = document.getElementById('formCommentTeacher');
    if (formCommentTeacher) {
        formCommentTeacher.addEventListener('submit', function (event) {
            event.preventDefault();

            const textareas = document.querySelectorAll("#formCommentTeacher .textareaC");
            for (const textarea of textareas) {
                if (textarea.value.trim() === '') {
                    showNotification(`Por favor, completa el campo "${textarea.placeholder}"`, true, '#notificationCT');
                    return;
                }
            }

            formCommentTeacher.submit();
        });
    }

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