<?php
function getSetting($property) {
    global $dbpre;
    global $mysqli;
    $query = "SELECT value FROM ".$dbpre."settings WHERE  
    property = '".$property."';";
    $result = $mysqli->query($query);
    while($row = $result->fetch_row()) {
        return $row[0];
    }
}
?>