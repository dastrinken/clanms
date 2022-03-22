<?php
    require(__DIR__."/db_settings.php");
    /* Datenbankverbindung */
    function connect_DB() {
        global $dbhost, $dbuser, $dbpw, $db;
        $mysqli = new mysqli($dbhost, $dbuser, $dbpw, $db);
        if($mysqli->connect_error) {
            die("Connection to Database failed..." . $mysqli->connect_error);
        } else {
            return $mysqli;
        }
    }

    /* Daten aus DB auslesen */
    $title = getSetting("title");
    
    /* Settings aus DB auslesen */
    function getSetting($property) {
        global $dbpre;
        $mysqli = connect_DB();
        $query = "SELECT value FROM ".$dbpre."settings WHERE  
        property = '".$property."';";
        $result = $mysqli->query($query);
        while($row = $result->fetch_row()) {
            $setting = $row[0];
        }
        $mysqli->close();
        return $setting;
    }
    //selectOneRow_DB: use if you expect exactly one result (row). For example looking up a user id (or any other id)
    function selectOneRow_DB($column, $tablename, $condition, $value) {
        $mysqli = connect_DB();

        $column = mysqli_escape_string($mysqli, $column);
        $tablename = mysqli_escape_string($mysqli, $tablename);
        $condition = mysqli_escape_string($mysqli, $condition);
        $value = mysqli_escape_string($mysqli, $value);
        
        $query = "SELECT $column FROM $tablename WHERE $condition=$value";
        $select = $mysqli->query($query);
        while($row = $select->fetch_row()) {
            $return = $row[0];
        }
        $select->close();
        $mysqli->close();
        return $return;
    }
?>