<?php

?>
<section class="container">
    <div class="row" id="gallery">
        <div class="col-md-3">
            <img src="./content/gallery/images/img1.jpg" alt="" class="img-thumbnail"> </img>
        </div>
        <div class="col-md-3">
            <img src="./content/gallery/images/img2.jpg" alt="" class="img-thumbnail"> </img>
        </div>
        <div class="col-md-3">
            <img src="./content/gallery/images/img3.jpg" alt="" class="img-thumbnail"> </img>
        </div>
        <div class="col-md-3">
            <img src="./content/gallery/images/img4.jpg" alt="" class="img-thumbnail"> </img>
        </div>
        <div class="col-md-3">
            <img src="./content/gallery/images/img5.jpg" alt="" class="img-thumbnail"> </img>
        </div>
    </div>
</section>

<script>
    let galleryImages = document.querySelectorAll(".img-thumbnail");
    let getLatestOpenImg;
    let windowWith = window.innerw;

    if(galleryImages) {
        galleryImages.forEach(function(image, index) {
            image.onclick = function() {
                let getElementXss = document.getElementsByClassName("img-thumbnail");
                let Imagesrc = this.getAttribute("src");

                getLatestOpenImg = index +1;
                
                let container = document.getElementById("gallery");
                let newImageWindow = document.createElement("div");
                container.appendChild(newImageWindow);
                newImageWindow.setAttribute("class", "img-window ");
                newImageWindow.setAttribute("onclick", "closeImg()");

                let newImg = document.createElement("img");
                newImageWindow.appendChild(newImg);
                newImg.setAttribute("src", Imagesrc);
                newImg.setAttribute("id", "current-img");


                newImg.onload = function() {
                    let imgWidth = this.width;
                    let calcImgToEdge = ((windowWith - imgWidth) / 2) -80;

                    let newNextBtn =  document.createElement("a");
                    let btnNextText = document.createTextNode("Next");
                    newNextBtn.appendChild(btnNextText);
                    container.appendChild(newNextBtn);
                    newNextBtn.setAttribute("class", "img-btn-next");
                    newNextBtn.setAttribute("onclick", "changeImg(1)");
                    newNextBtn.style.cssText ="right: " + calcImgToEdge + "px;";

                    let newPrevBtn =  document.createElement("a");
                    let btnPrevText = document.createTextNode("Previous");
                    newPrevBtn.appendChild(btnPrevText);
                    container.appendChild(newPrevBtn);
                    newPrevBtn.setAttribute("class", "img-btn-prev");
                    newPrevBtn.setAttribute("onclick", "changeImg(0)");
                    newPrevBtn.style.cssText ="left: " + calcImgtoEdge + "px;";

                }

            }
        });
    };

function closeImg() {
    document.querySelector(".img-window").remove();
    document.querySelector(".img-btn-next").remove();
    document.querySelector(".img-btn-prev").remove();
}

function changeImg(changeDir) {
    document.querySelector("#current-img").remove();

    let getImgWindow = document.querySelector(".img-window");
    let newImg = document.createElement("img");
    getImgWindow.appendChild(newImg);

    let calcNewImg;
    if(changeDir === 1) {
        calcNewImg = getLatestOpenImg +1;
        if(calcNewImg > galleryImages.length) {
            calcNewImg = 1;
        }
    }
    else if (changeDir === 0) {
        calcNewImg = getLatestOpenImg -1;
        if(calcNewImg < 1) {
            calcNewImg = galleryImages.length;
        }
    }

    newImg.setAttribute("src", "./content/gallery/images/img" + calcNewImg + ".jpg");
    newImg.setAttribute("id", "current-img");

    getLatestOpenImg = calcNewImg;

    newImg.onload = function() {

        let imgWidth = this.width;
        let calcImgToEdge = ((windowWith - imgWidth) / 2) -80;

        let nextBtn = document.querySelector(".img-btn-next");
        nextBtn.style.cssText = "right: " + calcImgtoEdge + "px;";

        let PrevBtn = document.querySelector(".img-btn-prev");
        PrevBtn.style.cssText = "left: " + calcImgtoEdge + "px;";
        
    }
}


</script>