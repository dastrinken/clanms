<?php 
    $events = getEventsArray();
?>

<div class="container">
    <div class="row">
        <div class="col d-flex flex-column">
            <?php include(__DIR__."/../calendar_nav.php"); ?>
            <script src="./content/calendar/calendar_basic.js"></script>
        </div>
        <div id="eventDisplaySwitchable" class="col d-flex"><?php include(__DIR__."/welcome.php"); ?></div>
    </div>
</div>