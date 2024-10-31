document.addEventListener("DOMContentLoaded", function () {
    const headerLogo = document.querySelector(".header-logo");

    if (headerLogo) {
        window.addEventListener("scroll", function () {
            console.log("Scrolling..."); // Vérification du défilement

            if (window.scrollY > 50) {
                headerLogo.classList.add("scrolled");
                console.log("Class 'scrolled' ajoutée");
            } else {
                headerLogo.classList.remove("scrolled");
                console.log("Class 'scrolled' retirée");
            }
        });
    } else {
        console.error("L'élément .header-logo est introuvable");
    }
});