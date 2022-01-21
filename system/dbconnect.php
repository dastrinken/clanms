<?php
    require("./dbsettings.php");
    $mysqli = new mysqli($dbhost, $dbuser, $dbpw, $db);
    if($mysqli->connect_error) {
        die("Connection to Database failed..." . $mysqli->connect_error);
    } else {
        echo "Connection to Database established!";
    }
?>