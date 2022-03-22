<?php
    require_once(__DIR__."/../../system/db_functions.php");
    /* jQuery Anfragen */
    switch ($_POST['command'])
    {
        case 'getSpecificEvent':
            getSpecificEventById($_POST['postId'], true);
            break;
        case 'getCategoryImage':
            getCategoryImage($_POST['postId'], 128, 1);
            break;
        case 'getMonthArray':
            getMonthlyEvents($_POST['postMonth'], $_POST['postYear']);
            break;
        default:
            break;
    }

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

    function getEventsArray() {
        $mysqli = connect_DB();
        $select = "SELECT * FROM clanms_event";
        $result = $mysqli->query($select, MYSQLI_USE_RESULT);
        $resultArray = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        $mysqli->close();
        return $resultArray;
    }

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

    //catId muss aus Eventarray ausgelesen werden, rounded gibt an ob Bild rund sein soll oder Eckig (true/false)
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
            $image = '<img src="data:image/png;base64,'.$content.'" width = "'.$size.'px" height="'.$size.'px" class="rounded-circle" />';
        }
        echo $image;
    }
?>