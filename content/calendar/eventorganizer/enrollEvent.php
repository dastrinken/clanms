<?php
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../../../system/db_functions.php");
    require_once(__DIR__."/../../../admin/scripts/rights_system.php");

    /* TODO: Anmeldeformular. Anmeldung je nach Benutzerstatus/Benutzergruppe.
    Rollen vom Spiel abhängig machen usw. Vorerst würde eine einfache Anmeldung reichen. */
    enroll();
    
    function enroll() {
        $userId = $_SESSION['userid'];
        $eventId = $_GET['eventId'];

        $mysqli = connect_DB();
        /* check if user is already enrolled */
        $select = "SELECT id FROM clanms_event_enrolls WHERE id_user = $userId AND id_event = $eventId";
        $result = $mysqli->query($select);
        if($result->num_rows != 0) {
            echo "<p>Du bist bereits für dieses Event angemeldet!</p>";
        } else {
            if(checkPermission("enrollEvents", false)){
                $insert = "INSERT INTO clanms_event_enrolls (id_event,id_user) VALUES ($eventId, $userId)";
                if($mysqli->query($insert)) {
                    echo "<p>Du hast dich erfolgreich angemeldet!</p>";
                } else {
                    echo "<p>Es ist etwas schief gelaufen, versuche es bitte erneut.</p>";
                }
            }else{
                echo "<p>Dir fehlt hierfür die nötige Berechtigung!</p>";
            }
        }
        $result->close();
        $mysqli->close();
    }

?>
