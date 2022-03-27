<?php
    require_once(__DIR__."/../calendar_functions.php");
    if(empty($row)) {
        $event = getSpecificEventById($_GET['eventId'], false);
        $eventId = $_GET['eventId'];
        $row['title'] = $event[0]['title'];
        $row['event_cat'] = $event[0]['event_cat'];
        $row['start'] = $event[0]['start'];
        $row['description'] = $event[0]['description'];
    } else {
        $eventId = $row['id'];
    }
    $displayDate = date_create_from_format("Y-m-d H:i:s", $row['start'])->format("d.m.Y");
    $displayTime = date_create_from_format("Y-m-d H:i:s", $row['start'])->format("H:i");
?>
<div class ='col mb-2 p-2 bg-lightdark rounded'>
    <!-- HEAD -->
    <div class='row d-flex align-content-center text-center bg-blackened m-1 p-1 rounded'>
        <h4 class='m-1'><?php echo $optionalText, $row['title']; ?></h4>
    </div>
    <!-- CONTENT -->
    <div class='row'>
        <div class='col d-flex justify-content-center align-items-center p-1'>
            <?php getCategoryImage($row['event_cat'], 128, 2); ?>
        </div>
        <div class='col flex-grow-1'>
            <hr/>
            <div class='row p-1'>
                <pre>Datum: <?php echo $displayDate; ?> | Uhrzeit: <?php echo $displayTime; ?></pre>
            </div>
            <div class='row p-1'>
                <p><?php echo $row['description']; ?></p>
            </div>
        </div>
    </div>
    <hr />
    <!-- FOOTER -->
    <?php if($_SESSION['userid'] && $_SESSION['username']) {
        include(__DIR__."/displayFooter.php");
    } ?>
</div>