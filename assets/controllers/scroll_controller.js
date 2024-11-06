import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        const headerLogo = document.querySelector(".header-logo");
        const headerTitle = document.querySelector(".header-title");

        if (headerLogo) {
            window.addEventListener("scroll", function () {
                if (window.scrollY > 50) {
                    headerLogo.classList.add("scrolled");
                } else {
                    headerLogo.classList.remove("scrolled");
                }
            });
        } else {
            console.error("L'élément .header-logo est introuvable");
        }

        if (headerTitle) {
            window.addEventListener("scroll", function () {

                if (window.scrollY > 50) {
                    headerTitle.classList.add("scrolled");
                } else {
                    headerTitle.classList.remove("scrolled");
                }
            });
        } else {
            console.error("L'élément .header-title est introuvable");
        }
    }
}
