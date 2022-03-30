<form action="./dashboard.php" method="post" enctype='multipart/form-data'>
    <div class="d-flex mb-3">
        <div class="input-group me-2">
            <span class="input-group-text" id="ariaLabelTitle">Titel</span>
            <input id="eventCatTitle" class="form-control" type="text" aria-describedby="ariaLabelTitle" name="eventCatTitle" value="<?php echo $eventCatTitle; ?>" placeholder="Bitte Titel eingeben">
            
        </div>
        <div class="me-2">
            <?php
            if($editing){
                getCategoryImage($eventCatId, 128, 1);
            }else{
                echo '<img src=".././ressources/images/empty.png" class="rounded" width="128px" height="128px">';
            }
            ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="eventCatDescription" class="form-label">Beschreibung</label>
        <textarea class="form-control" id="eventCatDescription" name="eventCatDescription" rows="15" placeholder="Beschreibe deine Eventkategorie..."><?php echo $eventCatDesc; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="eventCatImage" class="form-label">Kategorie Bild</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="64000">
        <input class="form-control" type="file" id="eventCatImg" name="eventCatImg">
    </div>
        <?php 
            if($editing) {
                echo '<input type="hidden" name="updateEventCat" value="true">';
                echo '<input type="hidden" name="eventCatId" value="'.$eventCatId.'">';
                $editing = false;
            } else {
                echo '<input type="hidden" name="updateEventCat" value="false">';
            }
        ?>
        <button id="saveEventCat" class="form-control submit w-25" name="saveEventCat" value="save">Speichern</button>
    </div>
</form>
