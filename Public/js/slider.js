/********************************* Slider ****************************************/

class Slider {
    constructor(tabImages) {
        this.imageArray = tabImages;
        this.image = document.getElementById("mainImage");
        this.imageIndex = 0;

        this.diapoAuto = null;
    }

    diapo() {
        this.image.setAttribute("src", this.imageArray[this.imageIndex]);
    };


    nextBlock() {
        this.diapo();
        this.imageIndex++;
        if (this.imageIndex > this.imageArray.length - 1) {
            this.imageIndex = 0;
        }
    };


    init(ms) {
        this.diapoAuto = setInterval(() => this.nextBlock(), ms);
    };


};

let objetSlider = new Slider(["Public/img/cover.png", "Public/img/cover2.png", "Public/img/cover3.png"]);
objetSlider.init(5000);