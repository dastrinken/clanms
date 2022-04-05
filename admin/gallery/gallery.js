function uploadImage() {
    var imageForm = document.getElementById('imageUpload');
    var fileSelect = document.getElementById('image');
    var file = fileSelect.files;
    /* for(let i = 0; i < file.length; i++) {
        console.log(file[i]);
    } */
    formData = new FormData();
    formData.append('image', file[0]);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./gallery/upload_image.php", true);
    xhr.onload = function() {
        console.log(this.responseText);
    }
    xhr.send(formData);
}
  
function reloadContent()
{
     /*getElement("image-preview").oUp.reload();*/
     return true;
}


