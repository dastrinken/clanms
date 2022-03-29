<?php
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../../../system/db_functions.php");
    require_once(__DIR__."/../../../system/account/account_functions.php");

getEnrolls();

function getEnrolls(){
    $eventId = $_GET['eventId'];
    $mysqli = connect_DB();
    $select = "SELECT cup.name AS username, 
            cup.avatar AS avatar,
            cup.id_user AS userid,
            cee.enrolled AS since
            FROM clanms_event_enrolls cee 
            LEFT JOIN clanms_user_profile cup ON cup.id_user = cee.id_user
            WHERE cee.id_event = $eventId";
    $result = $mysqli->query($select);
    $list ='<ul class="list-group list-group-flush">';
    while($row = $result->fetch_assoc()){
        $date = date_create_from_format("Y-m-d H:i:s", $row["since"])->format("d.m.Y");
        $list .= '<li class="list-group-item list-group-item-action list-group-item-secondary">
                    <div class="row m-1">
                        <div class="col">
                            <div class="fw-bold">'.$row["username"].'</div>
                            Angemeldet: '.$date.'
                            </div><div class="col d-flex justify-content-end">'.getProfilePic(64, 1, $row["userid"]).'</div>
                    </li></div>';
    }
    $list .= '</ul>';
    $result->close();
    $mysqli->close();
    echo $list;
}
?>