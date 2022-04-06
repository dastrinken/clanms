<?php 
require_once(__DIR__."/../scripts/adminfunctions.php");

$selectOption = getEventCatsFromDB();
$gameOption = getGameFromDB();

if($editing) {
    if(checkPermission("eventorganizer",true,$_GET['userid'])){
        $eventTitle = $_GET['eventTitle'];
        $eventId = $_GET['eventId'];
        $date_start = $_GET['eventStart'];
        $date_end = $_GET['eventEnd'];
        $author_name = $_GET['author_name'];
        $date_created = $_GET['date_created'];
        $event_cat = $_GET['eventCat'];
        $description = $_GET['description'];
        $date_end_array = explode(" ",$date_end);
        $date_end_w3c = $date_end_array[0]."T".$date_end_array[1];
        
        $date_start_array = explode(" ", $date_start);
        $date_start_w3c = $date_start_array[0]."T".$date_start_array[1];

        echo "<h2 class='text-center mt-2'>Event bearbeiten</h2>";
        include(__DIR__."/createEventForm.php");
}else{
    echo "<p>Dir fehlen die nötigen Berechtigungen hierfür...</p>";
}
} else {
    if(checkPermission("eventorganizer",false)){
        echo "<h2 class='text-center mt-2'>Neues Event</h2>";
        include(__DIR__."/createEventForm.php");
    }else{
        echo "<p>Dir fehlen die nötigen Berechtigungen hierfür...</p>";
    }
    
}
?>
