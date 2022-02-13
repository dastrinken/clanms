<?php
    require("./system/dbsettings.php");
    function connect_DB() {
        global $dbhost, $dbuser, $dbpw, $db;
        $mysqli = new mysqli($dbhost, $dbuser, $dbpw, $db);
        if($mysqli->connect_error) {
            die("Connection to Database failed..." . $mysqli->connect_error);
        } else {
            return $mysqli;
        }
    }
?>