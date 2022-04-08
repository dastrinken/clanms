<?php
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../../../system/db_functions.php");
    require_once(__DIR__."/../../../admin/scripts/rights_system.php");

    withdraw();

    function withdraw() {
        $userId = $_SESSION['userid'];
        $eventId = $_GET['eventId'];
        $mysqli = connect_DB();
        $delete = "DELETE FROM clanms_event_enrolls WHERE id_user = $userId AND id_event = $eventId";
        if($mysqli->query($delete)) {
            echo "Du hast dich erfolgreich von diesem Event abgemeldet.";
        } else {
            echo "Das hat nicht geklappt, versuche es erneut oder kontaktiere einen Administrator.";
        }
    }
?>