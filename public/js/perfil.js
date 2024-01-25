document.addEventListener("DOMContentLoaded", function () {
    const fileContainers = document.querySelectorAll('.file-container');
    fileContainers.forEach(function(fileContainer) {
        fileContainer.addEventListener('click', function () {
            const inputFile = this.querySelector('.file-input');
            const imgArea = this.querySelector('.img-area');
    
            inputFile.click();
    
            inputFile.addEventListener('change', function () {
                const image = this.files[0];
    
                if (image && image.size < 2000000) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        const allImgs = imgArea.querySelectorAll('img');
                        allImgs.forEach(item => item.remove());
    
                        const imgUrl = reader.result;
                        const img = document.createElement('img');
                        img.src = imgUrl;
                        imgArea.appendChild(img);
                        imgArea.classList.add('active');
                        imgArea.dataset.img = image.name;
                    };
                    reader.readAsDataURL(image);
                } else {
                    alert("La imagen debe ser menor que 2MB");
                }
            });
        });
    });

    function showModal(modal) {
        modal.style.display = 'block';
    }

    function closeModal(modal) {
        modal.style.display = 'none';
    }

    var modals = {
        user: document.getElementById('myModalEditUser')
    };

    var btns = {
        addAvatar: document.getElementById('btnChangeAvatar')
    };

    var closeBtns = {
        user: document.getElementById('cerrarModalEditUser')
    };

    function handleModalClick(event, modal) {
        if (event.target === modal) {
            closeModal(modal);
            console.log('cierre');                            
        }
    }

    function handleAddButtonClick(modal) {
        return function () {
            showModal(modal);
            console.log('abrir');
        };
    }

    function handleCloseButtonClick(modal) {
        return function () {
            closeModal(modal);
            console.log('cierre');
        };
    } 

    btns.addAvatar.addEventListener('click', handleAddButtonClick(modals.user));

    closeBtns.user.addEventListener('click', handleCloseButtonClick(modals.user));

    window.addEventListener('click', function (event) {
        if (event.target === modals.user) {
            closeModal(modals.user);
        }
    });
});