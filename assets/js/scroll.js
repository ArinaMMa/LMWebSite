document.addEventListener("DOMContentLoaded", function () {
    const headerLogo = document.querySelector(".header-logo");
    const headerTitle = document.querySelector(".header-title");

    if (headerLogo) {
        window.addEventListener("scroll", function () {
            console.log("Scrolling..."); // Vérification du défilement

            if (window.scrollY > 50) {
                headerLogo.classList.add("scrolled");
                console.log("Class 'scrolled' ajoutée logo");
            } else {
                headerLogo.classList.remove("scrolled");
                console.log("Class 'scrolled' retirée logo");
            }
        });
    } else {
        console.error("L'élément .header-logo est introuvable");
    }

    if (headerTitle) {
        window.addEventListener("scroll", function () {
            console.log("Scrolling..."); // Vérification du défilement

            if (window.scrollY > 50) {
                headerTitle.classList.add("scrolled");
                console.log("Class 'scrolled' ajoutée title");
            } else {
                headerTitle.classList.remove("scrolled");
                console.log("Class 'scrolled' retirée title");
            }
        });
    } else {
        console.error("L'élément .header-title est introuvable");
    }
});