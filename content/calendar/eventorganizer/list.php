<?php
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../../../system/db_functions.php");

getEnrolls();

function getEnrolls(){
    $eventId = $_GET['eventId'];
    $mysqli = connect_DB();
    $select = "SELECT cup.name AS username, 
            cup.avatar AS avatar 
            FROM clanms_event_enrolls cee 
            LEFT JOIN clanms_user_profile cup ON cup.id_user = cee.id_user
            WHERE cee.id_event = $eventId";
    $result = $mysqli->query($select);
    $list ='<div class="list-group">';
    while($row = $result->fetch_assoc()){
        $list .= '<button type="button" class="list-group-item list-group-item-action">
                        '.$row["username"].'
                    </button>';
    }
    $list .= '</div>';
    $result->close();
    $mysqli->close();
    echo $list;
}
?>