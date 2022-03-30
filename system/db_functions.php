<?php
    require(__DIR__."/db_settings.php");
    
    /** Establish a database-connection and return the mysqli-object
     * @return Object The mysqli-object
     */
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
    
    /** Reads a single setting from the db
     * @param String $property The name of the property you want to select
     * @return String The value of selected property
     */
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

    /** Selects something from the db. Only use if you just expect one single result!
     * @param String $column The single column you want to select
     * @param String $tablename The name of the table you want to select FROM
     * @param String $condition Left side of the WHERE-statement
     * @param String $value right side of the WHERE-statement
     * @return String The selected result from the database
     */
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