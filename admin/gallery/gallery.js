function uploadImage() {
    var galleryId = findGetParameter("galleryId");
    var imageForm = document.getElementById('imageUpload');
    var fileSelect = document.getElementById('image');
    var file = fileSelect.files;
    formData = new FormData(imageForm);
    formData.append('image', file[0]);
    formData.append('galleryId', galleryId);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./gallery/upload_image.php", true);
    xhr.onload = function() {
        console.log("Bild hochgeladen!");
    }
    xhr.send(formData);
}

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

function deleteImageFromDB(imageId) {
    /* image id -> übermitteln an PHP-Script -> Bild aus Datenbank löschen -> anschließend div neu laden */
    $.post("./gallery/gallery_functions.php", 
    {
        command: "deleteImage",
        postId: imageId
    },
    function(data) {
        console.log(data);
    });
}

function reloadImages(){

    $('#image-preview').load(document.URL +  ' #image-preview');
}
