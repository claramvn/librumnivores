/********************************* CONFIRMATION *********************************/

class Confirmation {
    constructor() {
        this.buttonDeleteBook = document.getElementById("btn_delete_book");
        this.buttonDeleteAccount = document.getElementById("btn_delete_account");
    }

    confirmDelete(event) {
        if (!confirm("Êtes-vous sûr de vouloir procéder à la suppression ?")) {
            event.preventDefault();
            event.stopPropagation();
        }
    }

    deleteBook() {
        this.buttonDeleteBook.addEventListener("click", () => this.confirmDelete(event));
    }

    deleteAccountUser() {
        this.buttonDeleteAccount.addEventListener("click", () => this.confirmDelete(event));
    }

};

let objetConfirmation = new Confirmation();