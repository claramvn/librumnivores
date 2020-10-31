/********************************* Slider ****************************************/

class Theme {
    constructor() {
        this.darkMode = sessionStorage.getItem("darkMode");
        this.header = document.getElementById('header');
        this.links = document.querySelectorAll("a");
        this.btnToggle = document.getElementById("btn_toggle_theme");
    }

    // Dark mode activé
    enableDarkMode() {
        document.body.classList.add("darkMode");
        document.body.classList.remove("lightMode");
        this.header.classList.add("darkMode");
        this.header.classList.remove("lightMode");

        for (let i = 0; i < this.links.length; i++) {
            this.links[i].style.color = "white";
        };

        sessionStorage.setItem("darkMode", "enabled");
    }

    // Dark mode désactivé
    disableDarkMode() {
        document.body.classList.add("lightMode");
        document.body.classList.remove("darkMode");
        this.header.classList.add("lightMode");
        this.header.classList.remove("darkMode");

        for (let i = 0; i < this.links.length; i++) {
            this.links[i].style.color = "black";
        };

        sessionStorage.clear();
    }

    // Choix thème
    init() {

        if (this.darkMode === "enabled") {
            this.enableDarkMode();
        }

        this.btnToggle.addEventListener("click", () => {
            this.darkMode = sessionStorage.getItem("darkMode");
            if (this.darkMode !== "enabled") {
                this.enableDarkMode();
            } else {
                this.disableDarkMode();
            }
        })
    }
};

let objetTheme = new Theme();
objetTheme.init();