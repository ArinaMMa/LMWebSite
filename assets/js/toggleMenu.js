document.addEventListener('DOMContentLoaded', () => {
    function toggleMenu() {
        document.querySelector('.nav-menu-content').classList.toggle('active');
    }
    
    document.querySelector('.nav-menu').addEventListener('click', toggleMenu);
});
