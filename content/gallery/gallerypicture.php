<div id="container">
    <div class="row" id="gallery" class="gallery">
        <script>   
        let srclist = [];
        </script>
        <?php getImagesFromDB(); ?>
    </div>
</div>




<script>
    let galleryImages = document.querySelectorAll(".img-thumbnail");
    let getLatestOpenImg;
    let windowWidth = window.innerWidth;
    let imgpos;


    if(galleryImages) {
        galleryImages.forEach(function(image, index) {
            image.onclick = function() {
                let getElementXss = document.getElementsByClassName("img-thumbnail");
                let Imagesrc = this.getAttribute("src");

                imgpos = (srclist.indexOf(Imagesrc));

                getLatestOpenImg = index +1;
                
                let container = document.getElementById("container");
                let newImageWindow = document.createElement("div");
                container.appendChild(newImageWindow);
                newImageWindow.setAttribute("class", "img-window ");
                newImageWindow.classList.add("d-flex");
                newImageWindow.setAttribute("onclick", "closeImg()");

                let newImg = document.createElement("img");
                newImageWindow.appendChild(newImg);
                newImg.setAttribute("src", Imagesrc);
                newImg.setAttribute("id", "current-img");


                newImg.onload = function() {
                    let imgWidth = this.width;
                    let calcImgToEdge = Math.abs(((windowWidth - imgWidth) / 2) - 50);

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
                    newPrevBtn.style.cssText ="left: " + calcImgToEdge + "px;";

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

    if(changeDir === 1) {
        imgpos = imgpos +1;
        if(imgpos > srclist.length - 1) {
            imgpos = 0;
        }
    }
    else if (changeDir === 0) {
        imgpos = imgpos -1;
        if(imgpos < 0) {
            imgpos = srclist.length - 1;
        }
    }
    console.log(imgpos);
    console.log(srclist[imgpos]);
    console.log(srclist.length);

    newImg.setAttribute("src", srclist[imgpos]);
    newImg.setAttribute("id", "current-img");

    newImg.onload = function() {

        let imgWidth = this.width;
        let calcImgToEdge = Math.abs(((windowWidth - imgWidth) / 2) - 50);

        let nextBtn = document.querySelector(".img-btn-next");
        nextBtn.style.cssText = "right: " + calcImgToEdge + "px;";

        let PrevBtn = document.querySelector(".img-btn-prev");
        PrevBtn.style.cssText = "left: " + calcImgToEdge + "px;";
        
    }
}





</script>
