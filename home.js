document.addEventListener('DOMContentLoaded', function () {
    const themes = [
        "\"Stock Smart, Deliver Excellence: Your Inventory, Optimized for Success. Track, Manage, and Thrive with Precision!\"",
        "\"Seamless Integration, Effortless Control. Bring Balance to Your Stock and Sanity to Your Schedule!\"",
        "\"Beyond Storage, Beyond Numbers. Elevating Your Inventory to Strategic Heights!\"",
        "\"Your Products, Your Passion. Our System, Your Peace of Mind. Let's Grow Together!\""
    ];
    const themeElement = document.querySelector('.theme');

    let currentThemeIndex = 0;

    function changeTheme() {
        themeElement.innerText = themes[currentThemeIndex];
        currentThemeIndex = (currentThemeIndex + 1) % themes.length;
    }

    
    setInterval(changeTheme, 4000);
});
