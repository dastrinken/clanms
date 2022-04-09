<?php
    /* SESSION setzen, falls noch nicht geschehen */
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../scripts/adminfunctions.php");
    
    echo '<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 id="headlineDashboardContent" class="h2"></h1>
            </div>';

    function showEnrollsOverview() {
        $eventId = $_GET['eventId'];
        $mysqli = connect_DB();
        $select = "SELECT cee.id AS enrollId, 
                    cee.enrolled AS dateEnrolled,
                    cee.id_user AS userId, 
                    cup.name AS userName,
                    cup.avatar AS ppic  
                    FROM clanms_event_enrolls cee 
                    JOIN clanms_user_profile cup ON cee.id_user = cup.id_user
                    WHERE cee.id_event = $eventId";
        $result = $mysqli->query($select);
        $table = '<div class="table">
                    <div class="thead">
                        <div class="tr mb-2">
                            <span class="td border-bottom border-dark">#</span>
                            <span class="td border-bottom border-dark">Profilbild</span>
                            <span class="td border-bottom border-dark">Nutzer</span>
                            <span class="td border-bottom border-dark">Datum</span>
                            <span class="td border-bottom border-dark"></span>
                        </div>
                    </div>
                    <div class="tbody">';
        $count = 1;
  
        foreach($result as $row){
            $enrollid = $row['enrollId'];
            $userid = $row['userId'];
            $enrollPpic = base64_encode($row['ppic']);
            $username = $row['userName'];
            $date = $row['dateEnrolled'];
            $table .= '<form method="post" class="tr activeTable">
                            <span class="td border-end border-activeTable" name="count">'.$count.'
                                <input type="hidden" name="enrollid" value="'.$enrollid.'">
                            </span>
                            <span class="td border-end border-activeTable" name="eventPic">
                                <img src="data:image/png;base64,'.$enrollPpic.'" width="64px" height="64px" class="rounded-circle">
                            </span>
                            <span class="td border-end border-activeTable" name="username">'.$username.'</span>
                            <span class="td border-end border-activeTable" name="date">'.$date.'</span>
                            <span class="td border-end border-activeTable">';
            if(checkPermission("enrollEvents", true, $userid)){
                $table .= '<button class="btn btn-danger submit" name="deleteEnroll" value="true">Löschen</button>';
            }
            $table .= '</span></form>';
                        
            $count++;
        }
        $table .= '</div>';
        $mysqli->close();
        echo $table;
    }
    showEnrollsOverview();
?>