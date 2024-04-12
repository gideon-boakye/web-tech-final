document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.querySelectorAll('.dashboard_sidebar_menus ul li');

    menuItems.forEach(function (menuItem) {
        menuItem.querySelector('a').addEventListener('click', function (event) {
            const subMenu = menuItem.querySelector('.subMenus');
            
            
            menuItems.forEach(function(item) {
                item.classList.remove('menuActive');
            });

             
            if (subMenu) {
                event.preventDefault();  
                const isActive = menuItem.classList.contains('menuActive');

                if (!isActive) {
                    closeAllSubmenusExcept(menuItem);
                    subMenu.style.display = 'block';
                    this.querySelector('i.nest').classList.add('fa-angle-up');
                    this.querySelector('i.nest').classList.remove('fa-angle-down');
                    menuItem.classList.add('menuActive');  
                } else {
                    subMenu.style.display = subMenu.style.display === 'block' ? 'none' : 'block';
                    this.querySelector('i.nest').classList.toggle('fa-angle-up');
                    this.querySelector('i.nest').classList.toggle('fa-angle-down');
                     
                }
            } else {
                 
                menuItem.classList.add('menuActive');
            }
        });
    });

    function closeAllSubmenusExcept(activeItem) {
        menuItems.forEach(function(item) {
            if (item !== activeItem) {
                const otherSubMenu = item.querySelector('.subMenus');
                if (otherSubMenu) {
                    otherSubMenu.style.display = 'none';
                }
                const nestIcon = item.querySelector('i.nest');
                if (nestIcon) {
                    nestIcon.classList.remove('fa-angle-up');
                    nestIcon.classList.add('fa-angle-down');
                }
                 
            }
        });
    }
});
