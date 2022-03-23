<?php
    $events = getEventsArray();
    if(!empty($events)){
        $closestEvent = getSpecificEventById(getClosestEventId(), false);
    }
?>
<div class='row mb-3'>
    <div class='col bg-blackened'>
        <?php include(__DIR__ . "/calendar_basic.php"); ?>
    </div>
    <div id='eventDisplaySwitchable' class='col d-flex'>
        <!-- Inhalt wird durch klick auf ein Event ausgetauscht (default-wert: nächstes anstehendes Event) -->
        <?php
            if(empty($events)) {
                include(__DIR__."/eventorganizer/emptyDisplay.php");
            } else {
                $optionalText = "Upcoming: ";
                foreach ($closestEvent as $row) {
                    include(__DIR__."/eventorganizer/displayEvent.php");
                }
            }
        ?>
    </div>
</div>
<hr/>
<div class='col'>
    <!-- iterate through next 3-4 upcoming events and display them, each in a div-row -->
    <?php
    $optionalText = "";
    foreach ($events as $row) {
        include(__DIR__."/eventorganizer/displayEvent.php");
    }
    ?>
</div>