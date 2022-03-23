<?php 
require_once(__DIR__."/../scripts/adminfunctions.php");

$selectOption = getEventCatsFromDB();
$gameOption = getGameFromDB();

if($editing) {
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
} else {
    echo "<h2 class='text-center mt-2'>Neues Event</h2>";
}
?>
<form action="./dashboard.php" method="post">
    <div class="d-flex mb-3">
        <div class="input-group me-2">
            <span class="input-group-text" id="ariaLabelTitle">Titel</span>
            <input id="eventTitle" class="form-control" type="text" aria-describedby="ariaLabelTitle" name="eventTitle" value="<?php echo $eventTitle; ?>" placeholder="Bitte Titel eingeben">
        </div>
    </div>
    <div class="d-flex mb-3">
        <select name="eventCat" class="form-select me-2" aria-label="select event category">
            <option selected>Eventkategorie</option>
            <?php 
            // editing-Teil fehlt
                foreach($selectOption as $row) {
                    printf("<option value='%s'>%s</option>", $row['id'], $row['title']);
                }
            ?>
        </select>
        <select name="game" class="form-select me-2" aria-label="select game">
            <option selected>Spiel</option>
            <?php 
            // editing-Teil fehlt
                foreach($gameOption as $row) {
                    printf("<option value='%s'>%s</option>", $row['id'], $row['title']);
                }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="eventDescription" class="form-label">Beschreibung</label>
        <textarea class="form-control" id="eventDescription" name="eventDescription" rows="15" placeholder="Beschreibe dein Event..."><?php echo $description; ?></textarea>
    </div>
    <div class="d-flex mb-3">
        <div class="input-group w-auto me-2">
            <span class="input-group-text" id="ariaLabelAuthor">Author</span>
            <input class="form-control" type="text" name="author" value="<?php echo empty($author_name) ? $_GET['author'] : $author_name; ?>" aria-describedby="ariaLabelAuthor" readonly>
        </div>

        <div class="input-group w-auto me-2">
            <span class="input-group-text" id="ariaLabelPublish">Event Start</span>
            <input class="form-control" type="datetime-local" name="date_start" value="<?php echo empty($date_start_w3c) ? date('Y-m-d\TH:i:s') : $date_start_w3c; ?>" aria-describedby="ariaLabelPublish">
        </div>
        <div class="input-group w-auto me-2">
            <span class="input-group-text" id="ariaLabelPublish">Event Ende</span>
            <input class="form-control" type="datetime-local" name="date_end" value="<?php echo empty($date_end_w3c) ? date('Y-m-d\TH:i:s') : $date_end_w3c; ?>" aria-describedby="ariaLabelPublish">
        </div>


        <input type="hidden" name="userid" value="<?php echo $_GET['userid']; ?>">
        <input type="hidden" name="date_created" value="<?php echo empty($date_created) ? date('Y-m-d H:i:s') : $date_created; ?>" aria-describedby="ariaLabelDate">
        <?php 
            if($editing) {
                echo '<input type="hidden" name="updateEvent" value="true">';
                echo '<input type="hidden" name="eventId" value="'.$eventId.'">';
                $editing = false;
            } else {
                echo '<input type="hidden" name="updateEvent" value="false">';
            }
        ?>
        <button id="saveEvent" class="form-control submit w-25" name="saveEvent" value="save">Speichern</button>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
    var simplemde = new SimpleMDE();
</script>