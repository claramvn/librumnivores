/********************************* SEARCH BOOK *********************************/

class SearchBook {
    constructor() {
        this.buttonOpenSearch = document.getElementById("button_open_search");
        this.blockSearch = document.getElementById("block_search");
        this.inputSearch = document.getElementById("input_search");
        this.buttonClose = document.getElementById("button_close");
        this.buttonSearch = document.getElementById("button_search");
        this.blockResult = document.getElementById("block_result");
        this.blockNoResult = document.getElementById("no_result");

        this.image = document.getElementById("result_img");
        this.title = document.getElementById("result_title");
        this.author = document.getElementById("result_author");
        this.description = document.getElementById("result_description");

        this.imageInput = document.getElementById("image_book");
        this.titleInput = document.getElementById("title_book");
        this.authorInput = document.getElementById("author_book");
        this.isbnInput = document.getElementById("isbn_book");
        this.publisherInput = document.getElementById("publisher_book");
        this.pageCountInput = document.getElementById("page_count_book");
        this.publishedDateInput = document.getElementById("published_date_book");
        this.shortDescriptionInput = document.getElementById("short_description_book");
        this.descriptionInput = document.getElementById("description_book");

        this.buttonAdd = document.getElementById("button_add");
    }

    displayBlockSearch() {
        this.buttonOpenSearch.addEventListener("click", () => {
            this.blockSearch.style.display = "block";
            this.inputSearch.value = "";
        });
    }

    hideBlockSearch() {
        this.buttonClose.addEventListener("click", () => {
            this.blockSearch.style.display = "none";
            this.blockResult.style.display = "none";
            this.blockNoResult.style.display = "none";
            this.inputSearch.value = "";
        });
    }

    displayResult(book) {
        this.blockResult.style.display = "block";
        this.blockNoResult.style.display = "none";

        if (book.volumeInfo.imageLinks !== undefined) {
            this.image.setAttribute("src", book.volumeInfo.imageLinks.thumbnail);
            this.imageInput.value = book.volumeInfo.imageLinks.thumbnail;
        } else {
            this.image.setAttribute("src", "Public/img/noimg.png");
            this.imageInput.value = "noimg.png";
        }

        if (book.volumeInfo.title !== undefined) {
            this.title.innerHTML = book.volumeInfo.title;
            this.titleInput.value = book.volumeInfo.title;
        } else {
            this.title.innerHTML = "Titre inconnu";
            this.titleInput.value = "Titre inconnu";
        }

        if (book.volumeInfo.authors !== undefined) {
            this.author.innerHTML = book.volumeInfo.authors;
            this.authorInput.value = book.volumeInfo.authors;
        } else {
            this.author.innerHTML = "Auteur inconnu(e)";
            this.authorInput.value = "Auteur inconnu(e)";
        }

        if (book.volumeInfo.description !== undefined) {
            this.descriptionInput.value = book.volumeInfo.description;
            let lastPos = book.volumeInfo.description.indexOf(" ", 140);
            this.description.innerHTML = book.volumeInfo.description.slice(0, lastPos) + "[...]";
            this.shortDescriptionInput.value = book.volumeInfo.description.slice(0, lastPos) + "[...]";
        } else {
            this.descriptionInput.value = "[pas de description]";
            this.shortDescriptionInput.value = "[pas de description]";
        }

        this.isbnInput.value = book.volumeInfo.industryIdentifiers[1].identifier;

        if (book.volumeInfo.publisher !== undefined) {
            this.publisherInput.value = book.volumeInfo.publisher;
        } else {
            this.publisherInput.value = "Éditeur inconnu";
        }

        if (book.volumeInfo.pageCount !== undefined) {
            this.pageCountInput.value = book.volumeInfo.pageCount;
        } else {
            this.pageCountInput.value = "/";
        }

        if (book.volumeInfo.publishedDate !== undefined) {
            this.publishedDateInput.value = book.volumeInfo.publishedDate;
        } else {
            this.publishedDateInput.value.value = "/";
        }
    }

    noResult() {
        this.blockResult.style.display = "none";
        this.blockNoResult.style.display = "block";
    }

    init() {
        this.buttonSearch.addEventListener("click", () => {
            let search = this.inputSearch.value.trim();
            search = search.replace(/(-)/g, "");

            if (search !== "" && /[0-9]/g.test(search)) {
                let url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + search;

                ajaxGet(url, (response) => {
                    let result = JSON.parse(response);
                    console.log(result);

                    if (result.totalItems > "0") {

                        var book = result.items[0];

                        this.displayResult(book);

                    } else {
                        this.noResult();
                    }
                });
            } else {
                this.noResult();
            }
        });
    };



}

let objetSearchBook = new SearchBook();
objetSearchBook.displayBlockSearch();
objetSearchBook.hideBlockSearch();
objetSearchBook.init();