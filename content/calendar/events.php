<?php
require(__DIR__."/../../system/dbconnect.php");

/* AJAX-Requests: Inhalt von GET[f] entscheidet, welche Funktion ausgeführt wird */
$f = $_REQUEST['f'];
if($f == 'monthArray') {
    $m = $_REQUEST['m'];
    $y = $_REQUEST['y'];
    getMonthlyEvents($m, $y);
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

/*
    GET -> index.php -> bindet alle Dateien ein, auch die dbconnect.php.

    GET -> events.php -> connect_DB();

*/

?>