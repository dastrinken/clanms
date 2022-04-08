<?php 
    require_once(__DIR__."/../scripts/adminfunctions.php");

    if($editing) {
        $galleryTitle = $_GET['galleryTitle'];
        $galleryDescription = $_GET['galleryDescription'];
        $galleryThumbnail = $_GET['galleryThumbnail'];
        $galleryId = $_GET['galleryId'];
        echo "<h2 class='text-center mt-2'>Bilder verwalten</h2>";
        echo '<div class="row d-flex flex-column">
                    <div class="col d-flex flex-wrap my-5" id="image-preview">
                        <button class="btn collapsebutton pt-3 border-0" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <h4>
                            <i class="bi-plus-square">
                            </i>
                            Bild hinzufügen</h4>
                        </button>';
        getImagesFromDB();
        echo '</div>
            </div><hr/>';
        echo '<button class="btn w-100 mb-3 collapsed d-flex justify-content-evenly align-items-end collapsebutton" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGallery" aria-expanded="false" aria-controls="collapseGallery">
                <i class="bi-arrow-down h3"></i><h2 class="text-center mt-2">Gallerie bearbeiten</h2><i class="bi-arrow-down h3"></i>
            </button>
                <div class="collapse" id="collapseGallery">';

        
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
            <div class="mb-3">
                <label for="image" class="form-label">Gallerie - Thumbnail</label>
                <input id="image" type="file" class="form-control" name="image" placeholder="Datei Hochladen hier...">
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
</div>
<?php
if($editing){
    echo '</div>';
}
?>