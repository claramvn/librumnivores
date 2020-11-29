/********************************* UPDATE INFOS BOOK *********************************/

class UpdateInfosBook {
    constructor() {
        this.buttonUpdatesBook = document.getElementById("btn_update_infos_book");
        this.blockUpdatesBook = document.getElementById("block_updates");
        this.buttonCloseUpdate = document.getElementById("button_close_block_updates");
    }

    displayBlockUpdate() {
        this.buttonUpdatesBook.addEventListener("click", () => {
            this.blockUpdatesBook.style.display = "block";
        });
    }

    hideBlockUpdate() {
        this.buttonCloseUpdate.addEventListener("click", () => {
            this.blockUpdatesBook.style.display = "none";
        });
    }

}

let objetUpdateInfosBook = new UpdateInfosBook();
objetUpdateInfosBook.displayBlockUpdate();
objetUpdateInfosBook.hideBlockUpdate();