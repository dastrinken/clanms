<?php
    require("./system/dbsettings.php");
    $mysqli = new mysqli($dbhost, $dbuser, $dbpw, $db);
    if($mysqli->connect_error) {
        die("Connection to Database failed..." . $mysqli->connect_error);
    }
?>