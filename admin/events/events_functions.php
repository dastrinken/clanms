<?php
function writeEventToDB($editExisting) {
    $title = $_POST['eventTitle'];
    $description = $_POST['eventDescription'];
    $id_author = $_POST['userid'];
    $date_created = $_POST['date_created'];
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];
    $event_cat = $_POST['eventCat'];
    $gameId = $_POST['game'];
    
    $mysqli = connect_DB();
    if($editExisting === 'true') {
        $eventId = $_POST['eventId'];
        $stmt = $mysqli->prepare("UPDATE clanms_event SET title = ?, description = ?, created = ?, start = ?, end = ?, event_cat = ?, id_user = ?, id_game = ? WHERE id = ?");
        $stmt->bind_param("sssssiiii",$title, $description, $date_created, $date_start, $date_end, $event_cat, $id_author,$gameId, $eventId);
    } else {
        $stmt = $mysqli->prepare("INSERT INTO clanms_event(title, description, created, start, end, event_cat, id_game, id_user) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssiii", $title, $description, $date_created, $date_start, $date_end, $event_cat, $gameId, $id_author);
    }
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

function getEventCatsFromDB() {
    $mysqli = connect_DB();
    $select = "SELECT * FROM clanms_event_category";
    $result = $mysqli->query($select, MYSQLI_USE_RESULT);
    $resultArray = $result->fetch_all(MYSQLI_ASSOC);
    $result->close();
    $mysqli->close();
    return $resultArray;
}
function getGameFromDB(){
    $mysqli = connect_DB();
    $select = "SELECT * FROM clanms_game";
    $result = $mysqli->query($select, MYSQLI_USE_RESULT);
    $resultArray = $result->fetch_all(MYSQLI_ASSOC);
    $result->close();
    $mysqli->close();
    return $resultArray;
}

function deleteEventFromDB($eventId) {
    $mysqli = connect_DB();
    $stmt = $mysqli->prepare("DELETE FROM clanms_event WHERE clanms_event.id = ?");
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

// store total no of pages in global for javascript use
$totalPages;
function getEventsFromDB($displayOption) {
    if (session_status() === PHP_SESSION_NONE){session_start();}
    global $totalPages;

    $displayAmount = 10;
    $page = $_GET['page'];
    $offset = ($page - 1) * $displayAmount;

    $mysqli = connect_DB();
    switch($displayOption) {
        case "all":
            $where = "WHERE 1=1";
            break;
        case "week":
            $where = "WHERE YEARWEEK(start, 1) = YEARWEEK(CURDATE(), 1)";
            break;
        case "month":
            $where = "WHERE MONTH(start) = MONTH(CURRENT_DATE())
            AND YEAR(start) = YEAR(CURRENT_DATE())";
            break;
        default:
            $where = "WHERE 1=1";
            break;
    }
    $totalPagesDB = "SELECT * FROM clanms_event AS events $where";
    $pagesResult = $mysqli->query($totalPagesDB);
    $rowCount = $pagesResult->num_rows;
    $totalPages = ceil($rowCount / $displayAmount);
    $pagesResult->close();

    $select = "SELECT ce.id AS eventId, 
                ce.id_user AS userId,
                ce.title AS eventTitle, 
                ce.description AS eventDesc, 
                start,
                end,
                ce.event_Cat AS eventCat,
                cec.title AS catTitle,
                ce.id_game AS gameId,
                cg.title AS gameTitle,
                timediff(end, start) AS diff
                FROM clanms_event ce
                JOIN clanms_event_category cec ON ce.event_cat = cec.id
                JOIN clanms_game cg ON ce.id_game = cg.id ".$where." 
                LIMIT $offset, $displayAmount;";

    $result = $mysqli->query($select, MYSQLI_USE_RESULT);
    $table = "<div class='table'>
    <div class='thead'>
        <div class='tr mb-2'>
            <span class='td border-bottom border-dark'>#</span>
            <span class='td border-bottom border-dark'>Datum</span>
            <span class='td border-bottom border-dark'>Titel</span>
            <span class='td border-bottom border-dark'>Start</span>
            <span class='td border-bottom border-dark'>Ende</span>
            <span class='td border-bottom border-dark'>Dauer</span>
            <span class='td border-bottom border-dark'>Kategorie</span>
            <span class='td border-bottom border-dark'>Spiel</span>
            <span class='td border-bottom border-dark'>Verantwortlich</span>
            <span class='td border-bottom border-dark'></span>
            <span class='td border-bottom border-dark'></span>
        </div>
    </div><div class='tbody'>";
    $count = 0;
    while($row = $result->fetch_assoc()) {
    ++$count;
    $event_id = $row['eventId'];
    $event_author = $row['userId'];
    $event_title = $row['eventTitle'];
    $event_desc = $row['eventDesc'];

    $event_start = $row['start'];
    $event_start_display = explode(" ", $row['start']);
    $event_end = $row['end'];
    $timediff = $row['diff'];

    foreach($event_start_display as $datetime) {
        $date = $event_start_display[0];
        $time = $event_start_display[1];
    }

    $event_cat = $row['eventCat'];
    $cat_title = $row['catTitle'];
    $game_id = $row['gameId'];
    $game_title = $row['gameTitle'];
    $table .= '<form class="tr activeTable">
                <span class="td border-end border-activeTable">
                '.(/*$offset+*/$count).'
                    <input type="hidden" name="eventId" value="'.$event_id.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$date.'
                    <input type="hidden" name="eventStart" value="'.$event_start.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$event_title.'
                    <input type="hidden" name="eventTitle" value="'.$event_title.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$time.'
                    <input type="hidden" name="eventStart" value="'.$event_start.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$event_end.'
                    <input type="hidden" name="eventEnd" value="'.$event_end.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$timediff.'
                </span>
                <span class="td border-end border-activeTable">
                    '.$cat_title.'
                    <input type="hidden" name="eventCat" value="'.$event_cat.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$game_title.'
                    <input type="hidden" name="gameId" value="'.$game_id.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$event_author.'
                    <input type="hidden" name="author_id" value="'.$event_author.'">
                </span>

                <input type="hidden" name="description" value="'.$event_desc.'">
                <span class="td border-end border-activeTable">
                    <button name="editEvent" value="true" class="btn btn-secondary submit">Bearbeiten</button>
                </span>
                <span class="td border-end border-activeTable">
                    <button name="deleteEvent" value="true" class="btn btn-danger submit" onclick="return confirm(\'Das Event wird endgültig aus der Datenbank gelöscht, bist du dir sicher?\');">Löschen</button>
                </span>
            </form>';
    }
    $table .= "</div>";
    $result->close();
    $mysqli->close();
    return $table;
}

?>