/********************************* REGISTER *********************************/

class Register {
    constructor() {
        this.nom = document.getElementById("user_name");
        this.email = document.getElementById("user_email");
        this.password = document.getElementById("user_pass");
        this.confirmPassword = document.getElementById("user_confirm_pass");
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
        this.emptyFields(this.email);
        this.emptyFields(this.password);
        this.emptyFields(this.confirmPassword);

        this.checkEmail(this.email);

        this.checkPasswordLength(this.password);
        this.checkPasswordLength(this.confirmPassword);

    }

};

let objetRegister = new Register();
objetRegister.init();