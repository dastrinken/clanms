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
        //TODO: 1. read all settings from db, 2. echo them in a form, 3. do form stuff and magic, 4. ???, 5. profit!
        include(__DIR__."/settings/settings_form.php");
        include(__DIR__."/social_media_form.php");
        $mysqli->close();
    }
?>