<?php
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../../../system/db_functions.php");

    /* TODO: Anmeldeformular. Anmeldung je nach Benutzerstatus/Benutzergruppe.
    Rollen vom Spiel abhängig machen usw. Vorerst würde eine einfache Anmeldung reichen. */
    enroll();
    
    function enroll() {
        $userId = $_SESSION['userid'];
        $eventId = $_GET['eventId'];

        $mysqli = connect_DB();
        /* check usergroup & rights */
        $select = "SELECT cug.id_group AS groupId, 
                    cghr.id_right AS rightId, 
                    cghr.value AS value
                    FROM clanms_user_groups AS cug
                    LEFT JOIN clanms_group_has_rights AS cghr
                    ON cug.id_group = cghr.id_group
                    WHERE cug.id_user = $userId AND cghr.id_right = 5;";
        $result = $mysqli->query($select);
        while($row = $result->fetch_assoc()) {
            $rightsValue = $row['value'];
        }
        $result->close();
        var_dump($userId, $eventId, $rightsValue);
        if(intval($rightsValue) >= 50){
            $insert = "INSERT INTO clanms_event_enrolls (id_event,id_user) VALUES ($eventId, $userId)";
            if($mysqli->query($insert)) {
                echo "<p>Du hast dich erfolgreich angemeldet!</p>";
            } else {
                echo "<p>Es ist etwas schief gelaufen, versuche es bitte erneut.</p>";
            }
        }else{
            echo "<p><strong>SIE HABEN NICHT DAS RECHT!!</strong></p>";
        }
        $mysqli->close();
    }

?>
