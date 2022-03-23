<?php
    include_once(__DIR__."/../../system/db_functions.php");
    
    switch($_POST['command']) {
        case "dashboardLink":
            include(__DIR__."/landingPage.php");
            break;
        case "settingsLink":
            showSettings();
            break;
    }

    function showSettings() {
        $mysqli = connect_DB();
        echo "Erfolg! Datenbankverbindung klappt...";
        $mysqli->close();
    }
?>