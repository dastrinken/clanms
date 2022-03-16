<?php 
/*
 include beide dateien
 hübsch machen
*/
    $events = getEventsArray();
?>

<div class="container">
    <div class="row">
        <div class="col d-flex flex-column"><?php include(__DIR__."/../calendar/calendar.php"); ?></div>
        <div id="eventDisplaySwitchable" class="col bg-lightdark rounded"><?php include(__DIR__."/welcome.php"); ?></div>
    </div>
</div>