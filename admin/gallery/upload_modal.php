<div id="uploadModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Bild hinzufügen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="imageUpload" name="imageUpload" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="image">Datei auswählen</label>
                        <input id="image" class="form-control" type="file" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="imageTitle">Bildtitel</label>
                        <input class="form-control" type="text" id="imageTitle" name="imageTitle">
                    </div>
                    <div class="mb-3">
                        <label for="description">Beschreibung</label>
                        <textarea name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tags">Tags</label>
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
