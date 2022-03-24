<?php 
    require_once(__DIR__."/../scripts/adminfunctions.php");

    if($editing) {

        $galleryTitle = $_GET['galleryTitle'];
        $galleryDescription = $_GET['galleryDescription'];
        $galleryThumbnail = $_GET['galleryThumbnail'];
        $galleryId = $_GET['galleryId'];

        echo "<h2 class='text-center mt-2'>Gallerie bearbeiten</h2>";
    } else {
        echo "<h2 class='text-center mt-2'>Neue Gallerie</h2>";
    }

    $imageTitle = $_GET['imageTitle'];
    $imageDescription = $_GET['imageDescription'];
    $imageFilename = $_GET['filename'];
    $imageId = $_GET['imageId'];

?>
<div class="row d-flex flex-column">
    <div class="col mb-3">
        <form action="./dashboard.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="galleryTitle" class="form-label">Titel</label>
                <input type="text" class="form-control" id="galleryTitle" name="galleryTitle" value="<?php echo $galleryTitle; ?>"placeholder="Titel der Gallerie...">
            </div>
            <div class="mb-3">
                <label for="galleryDescription" class="form-label">Beschreibung</label>
                <textarea class="form-control" id="galleryDescription" name="galleryDescription" placeholder="Beschreibe die Gallerie..."><?php echo $galleryDescription; ?></textarea>
            </div>
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="image" placeholder="Datei Hochladen hier...">
            </div>
            <?php 
                    if($editing) {
                        echo '<input type="hidden" name="updateGallery" value="true">';
                        echo '<input type="hidden" name="galleryId" value="'.$galleryId.'">';
                        $editing = false;
                    } else {
                        echo '<input type="hidden" name="updateGallery" value="false">';
                    }
            ?>
            <button id="saveGallery" class="form-control submit w-25" name="saveGallery" value="save">Speichern</button>
        </form>
    </div>
    <hr />
    <div class="col" id="image-preview">
        <button class="btn" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <h4>
            <i class="bi-plus-square">
            </i>
            Bild hinzufügen</h4>
        </button>
        <?php getImagesFromDB(); ?>
    </div>
</div>

<script>
        function reloadContent() {
        getElement("image-preview").oUp.reload();

        return true;
    }
</script>