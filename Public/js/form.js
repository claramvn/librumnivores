/********************************* FORM *********************************/

class Form {
    constructor() {
        // REGISTER
        this.nomRegister = document.getElementById("user_name_register");
        this.emailRegister = document.getElementById("user_email_register");
        this.passwordRegister = document.getElementById("user_pass_register");
        this.confirmPasswordRegister = document.getElementById("user_confirm_pass");
        this.regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        // CONNECTION
        this.buttonConnection = document.getElementById("button_connection");
        this.nomConnection = document.getElementById("user_name_connection");
        this.passwordConnection = document.getElementById("user_pass_connection");

        // CONTACT
        this.buttonContact = document.getElementById("button_contact");
        this.nomContact = document.getElementById("user_name_contact");
        this.emailContact = document.getElementById("user_email_contact");
        this.messageContact = document.getElementById("user_message");

        // PROFIL
        this.nomProfil = document.getElementById("user_name_profil");
        this.emailProfil = document.getElementById("user_email_profil");

        // UPDATE INFOS BOOK
        this.titleBook = document.getElementById("title_book");
        this.authorBook = document.getElementById("author_book");
        this.descriptionBook = document.getElementById("description_book");

        // SEARCH BOOK
        this.isbnSearch = document.getElementById("input_search");


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

    checkEmail(email) {
        email.addEventListener("blur", (e) => {
            if (!this.regex.test(email.value)) {
                email.classList.add("bad");
            } else {
                email.classList.remove("bad");
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

    checkMessageLength(message) {
        message.addEventListener("blur", (e) => {
            if (message.value.length <= 25) {
                message.classList.add("bad");
            } else {
                message.classList.remove("bad");
            }
        });
    }

    localStorageConnection() {
        this.buttonConnection.addEventListener("click", () => {

            localStorage.setItem('nom_connection', this.nomConnection.value.trim());
        });

        if (localStorage.getItem('nom_connection') !== "") {
            this.nomConnection.value = localStorage.getItem('nom_connection');
        };
    };

    localStorageContact() {
        this.buttonContact.addEventListener("click", () => {

            localStorage.setItem('nom_contact', this.nomContact.value.trim());
            localStorage.setItem('email_contact', this.emailContact.value.trim());

        });

        if (localStorage.getItem('nom_contact') !== "") {
            this.nomContact.value = localStorage.getItem('nom_contact');
        };
        if (localStorage.getItem('email_contact') !== "") {
            this.emailContact.value = localStorage.getItem('email_contact');
        }
    };

    initRegister() {
        this.emptyFields(this.nomRegister);
        this.emptyFields(this.emailRegister);
        this.emptyFields(this.passwordRegister);
        this.emptyFields(this.confirmPasswordRegister);

        this.checkEmail(this.emailRegister);

        this.checkPasswordLength(this.passwordRegister);
        this.checkPasswordLength(this.confirmPasswordRegister);

    }

    initConnection() {
        this.emptyFields(this.nomConnection);
        this.emptyFields(this.passwordConnection);
        this.checkPasswordLength(this.passwordConnection);
        this.localStorageConnection();
    }

    initContact() {
        this.emptyFields(this.nomContact);
        this.emptyFields(this.emailContact);
        this.emptyFields(this.messageContact);
        this.checkEmail(this.emailContact);
        this.checkMessageLength(this.messageContact);
        this.localStorageContact();
    }

    initProfil() {
        this.emptyFields(this.nomProfil);
        this.emptyFields(this.emailProfil);
        this.checkEmail(this.emailProfil);
    }

    initUpdateInfosBook() {
        this.emptyFields(this.titleBook);
        this.emptyFields(this.authorBook);
        this.emptyFields(this.descriptionBook);
    }

    initSearchBook() {
        this.emptyFields(this.isbnSearch);
    }

}

let objetForm = new Form();