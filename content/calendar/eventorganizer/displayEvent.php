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
?>
<div class ='col calendar-event mb-2 p-2 bg-lightdark rounded'>
    <!-- HEAD -->
    <div class='row d-flex align-content-center text-center bg-blackened m-1 p-1 rounded'>
        <h4><?php echo $optionalText, $row['title']; ?></h4>
    </div>
    <!-- CONTENT -->
    <div class='row'>
        <div class='col d-flex justify-content-center align-items-center'>
            <?php getCategoryImage($row['event_cat'], 128, 2); ?>
        </div>
        <div class='col flex-grow-1'>
            <hr/>
            <div class='row p-2'>
                <?php echo $row['start']; ?>
            </div>
            <div class='row p-2'>
                <?php echo $row['description']; ?>
            </div>
        </div>
    </div>
    <hr />
    <!-- FOOTER -->
    <?php if($_SESSION['userid'] && $_SESSION['username']) {
        include(__DIR__."/displayFooter.php");
    } ?>
</div>