<?php 
    if(writeDbSettings()) {
        echo "<p style='color: green;'>Datei erfolgreich geschrieben! <i class='bi-shield-check'></i></p>";
        if(chmod("../system/db_settings.php", 0644)) {
            echo "<p style='color: green;'>Datei erfolgreich gesichert! <i class='bi-shield-check'></i></p>";
        } else {
            echo "<p style='color: red;'><abbr title='Wir konnten den Zugriff auf /system/db_settings.php nicht ändern, bitte setze die Dateiberechtigungen manuell auf 0644'>Setzen der Dateiberechtigung fehlerhaft <i class='bi-shield-exclamation'></i></abbr></p>";
        }
    } else {
        echo "Fehler beim schreiben der Datei";
    }

    function writeDbSettings() {
        $file = '../system/db_settings.php';
        $content = '<?php
        $dbpre = "clanms_";
        $dbhost = "'.$_SESSION["installer"]->params[1]["host"].'";
        $dbpw = "'.$_SESSION["installer"]->params[1]["password"].'";
        $dbuser = "'.$_SESSION["installer"]->params[1]["user"].'";
        $db = "'.$_SESSION["installer"]->params[1]["database"].'";
    ?>';
        if(file_put_contents($file, $content)) {
            return true;
        }    else {
            return false;
        }
    }
?>