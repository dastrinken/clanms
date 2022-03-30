<?php
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../../system/db_functions.php");
    /* jQuery Anfragen */
    switch ($_POST['command'])
    {
        case 'getSpecificEvent':
            getSpecificEventById($_POST['postId'], true);
            break;
        case 'getMonthArray':
            getMonthlyEvents($_POST['postMonth'], $_POST['postYear']);
            break;
        default:
            break;
    }

    /**
     * Selects num_rows from given event for display (eventid has to be set as a global)
     */
    function getEnrollCount(){
        global $eventId;
        $mysqli = connect_DB();
        $select = "SELECT * FROM clanms_event_enrolls WHERE id_event =$eventId";
        $result = $mysqli->query($select);
        return $result->num_rows;
    }

    /** SELECTS all events in the given month from the db. As this is usually called via AJAX-Request, it echoes a json_encode(Array)
     * @param int $month Numeric representation of the month you want to select (e.g. 1 for January)
     * @param int $year The full yearnumber as an integer (e.g. 2022)
     */
    function getMonthlyEvents($month, $year) {
        $mysqli = connect_DB();
        $select = $mysqli->prepare("SELECT id, DAY(start) AS eventDay FROM clanms_event WHERE MONTH(start)=? AND YEAR(start)=?");
        $select->bind_param("ss",$month,$year);
        $select->execute();
        $result = $select->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $select->close();
        $mysqli->close();

        echo json_encode($data);
    }

    /* Calendar und alles Zugehörige */
    /**
     * Selects the event from database which is closest to the current date and returns its id
     * @return String The id of the selected event
     */
    function getClosestEventId() {
        $mysqli = connect_DB();
        $select = "SELECT id, MIN(DATEDIFF(start, NOW())) AS diff FROM clanms_event WHERE start > NOW() GROUP BY id ORDER BY diff ASC LIMIT 1;";
        $result = $mysqli->query($select);
        while($row = $result->fetch_row()) {
            $id = $row[0];
        }
        $result->close();
        $mysqli->close();
        return $id;
    }

    /**
     * Selects all Events from database
     * @return Array returns an associative mysqli result array with all data from clanms_event
     */
    function getEventsArray() {
        $mysqli = connect_DB();
        $select = "SELECT * FROM clanms_event";
        $result = $mysqli->query($select, MYSQLI_USE_RESULT);
        $resultArray = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        $mysqli->close();
        return $resultArray;
    }

    /**
     * Selects one specific event from a given id, returns an Array or echoes it as json_encode for JavaScript use
     * @param int $id The id of the event
     * @param bool $jquery if true, the return value is a json_encode(array), otherwise it will return the php-Array
     * @return Array Given the boolean param $jquery, either returns json_encode or php array
     */
    function getSpecificEventById($id, $jquery) {
        $mysqli = connect_DB();
        $select = "SELECT * FROM clanms_event WHERE id=$id";
        $result = $mysqli->query($select, MYSQLI_USE_RESULT);
        $resultArray = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        $mysqli->close();
        if($jquery) {
            echo json_encode($resultArray);
        } else {
            return $resultArray;
        }
    }

    /**
     * Reads and returns an image from the database
     * @param int $catId The id of the category
     * @param int $size The size of the img in px
     * @param int $rounded Decides which css class is displayed. Values range from 0 to 3
     * (0 = not rounded, 1 = rounded, 2 = circle, 3 = pill)
     */
    function getCategoryImage($catId, $size, $rounded) {
        $mysqli = connect_DB();
        $select = $mysqli->prepare("SELECT image FROM clanms_event_category WHERE id=?");
        $select->bind_param("i", $catId);
        $select->execute();
        $result = $select->get_result();
        $data = $result->fetch_assoc();
        foreach($data as $value) {
            $content = base64_encode($value);
        }
        if($rounded == 0) {
            $image = '<img src="data:image/png;base64,'.$content.'" width = "'.$size.'px" height= "'.$size.'px" />';
        } elseif($rounded == 1) {
            $image = '<img src="data:image/png;base64,'.$content.'" width = "'.$size.'px" height="'.$size.'px" class="rounded" />';
        } elseif($rounded == 2) {
            $image = '<img src="data:image/png;base64,'.$content.'" width = "'.$size.'px" height="'.$size.'px" class="rounded-circle" />';
        } elseif($rounded == 3) {
            $image = '<img src="data:image/png;base64,'.$content.'" width = "'.$size.'px" height="'.$size.'px" class="rounded-pill" />';
        }
        echo $image;
    }
?>