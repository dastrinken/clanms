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
        console.log(this.responseText);
    }
    xhr.send(formData);
}
  
function reloadContent()
{
     document.getElementById("image-preview").oUp.reload();
     return true;
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