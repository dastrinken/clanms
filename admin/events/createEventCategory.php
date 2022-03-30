<?php
require_once(__DIR__."/../scripts/adminfunctions.php");
if(checkPermission("eventCategory", false)){
    if($editing){
        
        $eventCatId = $_GET['eventCatId'];
        $eventCatTitle = $_GET['eventCatTitle'];
        $eventCatDesc = $_GET['eventCatDesc'];

        echo "<h2 class='text-center mt-2'>Eventkategorie bearbeiten</h2>";
    } else {
        echo "<h2 class='text-center mt-2'>Neue Eventkategorie</h2>";
    }
    include(__DIR__."/createEventCategoryForm.php");
} else {
    echo "<p>Dir fehlen die nötigen Berechtigungen hierfür...</p>";
}
?>

