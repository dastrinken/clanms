/* open gallery */
var galleryImages;
var getLatestOpenImg;
var windowWidth;
var windowHeight;
var imgpos;

function getGallery(id) {
    $("#mainContent").load("./content/gallery/gallery_functions.php?getImages="+id, 
    function() {
        startGalleryView();
    });
}

function startGalleryView() {
    galleryImages = document.querySelectorAll(".gallery-thumb");
    getLatestOpenImg;
    windowWidth = window.innerWidth;
    windowHeight = window.innerHeight;

    if(galleryImages) {
        galleryImages.forEach(function(image, index) {
            image.onclick = function() {
                let Imagesrc = this.getAttribute("src");

                imgpos = (srclist.indexOf(Imagesrc));

                getLatestOpenImg = index +1;
                
                let container = document.getElementById("imageContainer");
                let newImageWindow = document.createElement("div");
                container.appendChild(newImageWindow);
                newImageWindow.setAttribute("class", "img-window ");
                newImageWindow.classList.add("d-flex");
                newImageWindow.classList.add("animate-open-img");

                let newImg = document.createElement("img");
                newImageWindow.appendChild(newImg);
                newImg.setAttribute("src", Imagesrc);
                newImg.setAttribute("id", "current-img");
                newImg.addEventListener("click", function() {closeImg();});


                newImg.onload = function() {
                    let imgWidth = this.width;
                    let imgHeight = this.height;
                    let distanceTop = Math.abs((windowHeight - imgHeight) / 2);
                    let calcImgToEdge = Math.abs(((windowWidth - imgWidth) / 2));

                    let newNextBtn =  document.createElement("a");
                    let btnNextIcon = document.createElement("i");
                    btnNextIcon.setAttribute("class", "bi-arrow-right");
                    newNextBtn.appendChild(btnNextIcon);
                    container.appendChild(newNextBtn);
                    newNextBtn.setAttribute("class", "img-btn-next");
                    newNextBtn.setAttribute("onclick", "changeImg(1)");
                    newNextBtn.classList.add("switch-img-btn");
                    newNextBtn.classList.add("h1");
                    newNextBtn.classList.add("d-flex");
                    newNextBtn.classList.add("align-items-center");
                    //newNextBtn.style.cssText ="right: " + calcImgToEdge + "px;";
                    newNextBtn.style.cssText ="top: "+(distanceTop+3)+"px; right: "+(calcImgToEdge-newNextBtn.offsetWidth-2)+"px; height: "+(imgHeight-6)+"px;";

                    let newPrevBtn =  document.createElement("a");
                    let btnPrevIcon = document.createElement("i");
                    btnPrevIcon.setAttribute("class", "bi-arrow-left");
                    newPrevBtn.appendChild(btnPrevIcon);
                    container.appendChild(newPrevBtn);
                    newPrevBtn.setAttribute("class", "img-btn-prev");
                    newPrevBtn.setAttribute("onclick", "changeImg(0)");
                    newPrevBtn.classList.add("switch-img-btn");
                    newPrevBtn.classList.add("h1");
                    newPrevBtn.classList.add("d-flex");
                    newPrevBtn.classList.add("align-items-center");
                    //newPrevBtn.style.cssText ="left: " + calcImgToEdge + "px;";
                    newPrevBtn.style.cssText ="top: "+(distanceTop+3)+"px; left: "+(calcImgToEdge-newPrevBtn.offsetWidth-2)+"px; height: "+(imgHeight-6)+"px;";

                }

            }
        });
        window.addEventListener("resize", function() {
            let img = document.getElementById("current-img");
            console.log(img.width, img.height);
            calcBtnPos(img.width, img.height);
        });
    };    
}
function closeImg() {
    document.querySelector(".img-window").remove();
    document.querySelector(".img-btn-next").remove();
    document.querySelector(".img-btn-prev").remove();
}

function changeImg(changeDir) {
    document.querySelector("#current-img").remove();

    let getImgWindow = document.querySelector(".img-window");
    let newImg = document.createElement("img");

    if(changeDir === 1) {
        newImg.classList.add("switch-animate-left");
        imgpos = imgpos +1;
        if(imgpos > srclist.length - 1) {
            imgpos = 0;
        }
    }
    else if (changeDir === 0) {
        newImg.classList.add("switch-animate-right");
        imgpos = imgpos -1;
        if(imgpos < 0) {
            imgpos = srclist.length - 1;
        }
    }

    newImg.addEventListener("click", function() {closeImg();});
    getImgWindow.appendChild(newImg);

    newImg.setAttribute("src", srclist[imgpos]);
    newImg.setAttribute("id", "current-img");

    newImg.onload = function() {
        let imgWidth = this.width;
        let imgHeight = this.height;

        calcBtnPos(imgWidth, imgHeight);
    }
}

function calcBtnPos(imgWidth, imgHeight) {
    let distanceTop = Math.abs((windowHeight - imgHeight) / 2);
    let calcImgToEdge = Math.abs(((windowWidth - imgWidth) / 2));

    let nextBtn = document.querySelector(".img-btn-next");
    nextBtn.style.cssText ="top: "+(distanceTop+3)+"px; right: "+(calcImgToEdge-nextBtn.offsetWidth-2)+"px; height: "+(imgHeight-6)+"px;";

    let PrevBtn = document.querySelector(".img-btn-prev");
    PrevBtn.style.cssText ="top: "+(distanceTop+3)+"px; left: "+(calcImgToEdge-PrevBtn.offsetWidth-2)+"px; height: "+(imgHeight-6)+"px;";
}
