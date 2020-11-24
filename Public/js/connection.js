/********************************* CONNECTION *********************************/

class Connection {
    constructor() {
        this.button = document.getElementById("button_connection");
        this.nom = document.getElementById("user_name");
        this.password = document.getElementById("user_pass");
    }

    emptyFields(elt) {
        elt.addEventListener("blur", (e) => {
            if (elt.value.trim() === "") {
                elt.classList.add("bad");
            } else {
                elt.classList.remove("bad");
            }
        });
    }

    checkPasswordLength(password) {
        password.addEventListener("blur", (e) => {
            if (password.value.length <= 5) {
                password.classList.add("bad");
            } else {
                password.classList.remove("bad");
            }
        });
    }


    init() {
        this.emptyFields(this.nom);
        this.emptyFields(this.password);

        this.checkPasswordLength(this.password);
    }

    localStorage() {
        this.button.addEventListener("click", () => {

            localStorage.setItem('nom_connection', this.nom.value.trim());
        });

        if (localStorage.getItem('nom_connection') !== "") {
            this.nom.value = localStorage.getItem('nom_connection');
        };
    };

};

let objetConnection = new Connection();
objetConnection.init();
objetConnection.localStorage();