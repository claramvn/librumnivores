/********************************* CONFIRMATION *********************************/

class Confirmation {
    constructor() {
        this.buttonDeleteBook = document.getElementById("btn_delete_book");
    }

    confirmDeleteBook(event) {
        if (!confirm("Êtes-vous sûr de vouloir procéder à la suppression du livre ?")) {
            event.preventDefault();
            event.stopPropagation();
        }
    }

    init() {
        this.buttonDeleteBook.addEventListener("click", () => this.confirmDeleteBook(event));
    };



};

let objetConfirmation = new Confirmation();
objetConfirmation.init();