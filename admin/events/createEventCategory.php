<?php
require_once(__DIR__."/../scripts/adminfunctions.php");
if($editing){
    $eventCatId = $_GET['eventCatId'];
    $eventCatTitle = $_GET['eventCatTitle'];
    $eventCatDesc = $_GET['eventCatDesc'];

    echo "<h2 class='text-center mt-2'>Eventkategorie bearbeiten</h2>";
}else{
    echo "<h2 class='text-center mt-2'>Neue Eventkategorie</h2>";
}
?>

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

array(7) { 
    ["eventCatTitle"]=> string(8) "asdqwewe" 
    ["eventCatDescription"]=> string(12) "asdqweqweasd" 
    ["MAX_FILE_SIZE"]=> string(5) "64000" 
    ["eventCatImg"]=> string(13) "i-102 (1).jpg" 
    ["updateEventCat"]=> string(4) "true" 
    ["eventCatId"]=> string(1) "1" 
    ["saveEventCat"]=> string(4) "save" }
