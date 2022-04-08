<?php
    $allEvents = getEventsArray();
    $nextEvent = getClosestEventId();
    if(!empty($allEvents) && !empty($nextEvent)){
        $upcomingEvent = getSpecificEventById($nextEvent, false);
    }
?>
<div id="calendarContent">
    <div class='row mb-3'>
        <div class='col bg-blackened'>
            <?php include(__DIR__."/calendar_nav.php"); ?>
            <script src="./content/calendar/calendar_basic.js"></script>
        </div>
        <div id='eventDisplaySwitchable' class='col d-flex'>
            <!-- Inhalt wird durch klick auf ein Event ausgetauscht (default-wert: nächstes anstehendes Event) -->
            <?php
                if(empty($nextEvent)) {
                    include(__DIR__."/eventorganizer/emptyDisplay.php");
                } else {
                    $optionalText = "Upcoming: ";
                    foreach ($upcomingEvent as $row) {
                        include(__DIR__."/eventorganizer/displayEvent.php");
                    }
                }
            ?>
        </div>
    </div>
    <hr/>
    <div class='col'>
        <!-- iterate through next 3-4 upcoming allEvents and display them, each in a div-row -->
        <?php
        $optionalText = "";
        foreach ($allEvents as $row) {
            include(__DIR__."/eventorganizer/displayEvent.php");
        }
        ?>
    </div>
</div>