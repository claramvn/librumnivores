/********************************* CONTACT *********************************/

class Contact {
    constructor() {
        this.button = document.getElementById("button_contact");
        this.nom = document.getElementById("user_name");
        this.email = document.getElementById("user_email");
        this.message = document.getElementById("user_message");
        this.regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
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

    checkEmail(emailContact) {
        emailContact.addEventListener("blur", (e) => {
            if (!this.regex.test(emailContact.value)) {
                emailContact.classList.add("bad");
            } else {
                emailContact.classList.remove("bad");
            }
        });
    }

    checkMessageLength(message) {
        message.addEventListener("blur", (e) => {
            if (message.value.length <= 25) {
                message.classList.add("bad");
            } else {
                message.classList.remove("bad");
            }
        });
    }

    init() {
        this.emptyFields(this.nom);
        this.emptyFields(this.email);
        this.emptyFields(this.message);

        this.checkEmail(this.email);

        this.checkMessageLength(this.message);
    }

    localStorage() {
        this.button.addEventListener("click", () => {

            localStorage.setItem('nom_contact', this.nom.value.trim());
            localStorage.setItem('email_contact', this.email.value.trim());

        });

        if (localStorage.getItem('nom_contact') !== "") {
            this.nom.value = localStorage.getItem('nom_contact');
        };
        if (localStorage.getItem('email_contact') !== "") {
            this.email.value = localStorage.getItem('email_contact');
        }
    };

};

let objetContact = new Contact();
objetContact.init();
objetContact.localStorage();