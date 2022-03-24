<div id="uploadModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Bild hinzufügen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="image">Datei auswählen</label>
                        <input id="image" class="form-control" type="file" id="image" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="image">Bildtitel</label>
                        <input class="form-control" type="text" id="imageTitle" name="imageTitle">
                    </div>
                    <div class="mb-3">
                        <label for="image">Beschreibung</label>
                        <textarea></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image">Tags</label>
                        <input class="form-control" type="text" id="imageTags" name="imageTags">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary submit" onclick="uploadImage();">Speichern</button>
                    <button type="button" class="btn btn-secondary" onclick="reloadContent();" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    /* TODO: post funktioniert noch nicht, keine Ahnung warum, command wird nicht ausgelöst */
    function uploadImage() {
        var fd = new FormData();
        var files = $('#image')[0].files[0];
        fd.append('file', files);

        $.ajax({
            url: './gallery/gallery_functions.php',
            type: 'post',
            command: "uploadImage",
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    alert('file uploaded');
                }
                else{
                    alert('file not uploaded');
                }
            },
        });
    }
</script>