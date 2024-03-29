document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('menu-btn')
    const dropdownMenu = document.getElementById('dropdown-menu')

    if(menuBtn){
        menuBtn.addEventListener('click', function() {
            dropdownMenu.style.display = (dropdownMenu.style.display === 'flex') ? 'none' : 'flex'
        })
    }

    let listElements = document.querySelectorAll('.list-button--click')

    listElements.forEach(listElement => {
        listElement.addEventListener('click', ()=>{
            let height = 0
            let menu = listElement.nextElementSibling
            
            if(menu.clientHeight == "0") {
                height = menu.scrollHeight
            }

            menu.style.height = `${height}px`
        })
    })
})