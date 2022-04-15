<?php 
    //TODO: errorMsg bisher ohne Funktion?
    $errorMsg = "";
    echo "<h2>Installation abgeschlossen...</h2>
    <p>Bitte beachte, dass dieser Installer (noch) eher ein Prototyp ist. <br>
    Sollte etwas nicht klappen, kann es sein, dass du manuell Veränderungen durchführen musst.<br>
    Solltest du gar nicht weiterkommen, kontaktiere uns doch z.B. über <a href='https://github.com/dastrinken/clanms' target='_blank'>GitHub.</a></p>";
    echo "<div class='col ps-3' style='text-shadow: 1px 1px black;'>";
    if(writeDbSettings()) {
        echo "<p style='color: green;'><i class='bi-shield-check'></i> Datei erfolgreich geschrieben!</p>";
        if(chmod("../system/db_settings.php", 0644)) {
            echo "<p style='color: green;'><i class='bi-shield-check'></i> Datei erfolgreich gesichert!</p>";
        } else {
            echo "<p style='color: red;'><abbr title='Wir konnten den Zugriff auf /system/db_settings.php nicht ändern, bitte setze die Dateiberechtigungen manuell auf 0644'><i class='bi-shield-exclamation'></i> Setzen der Dateiberechtigung fehlerhaft.</abbr></p>";
        }
        if(importSQL()) {
            echo "<p style='color: green;'><i class='bi-shield-check'></i>Datenbank erfolgreich befüllt!</p>";
            if(writeUserSettings()) {
                echo "<p style='color: green;'><i class='bi-shield-check'></i> Benutzereinstellungen erfolgreich eingetragen.</p>";
                echo "<p style='color: green;'><i class='bi-shield-check'></i> Homepagetitel erfolgreich geändert.</p>";
                echo "<p style='color: green;'><i class='bi-shield-check'></i> Installation erfolgreich abgeschlossen. Viel Spaß!</p>";
            } else {
                echo "<p style='color: yellow;'><abbr title='Du wirst dich eventuell nicht einloggen können. Weitere Informationen sind unten aufgeführt.'><i class='bi-shield-exclamation'></i> Deine Benutzereinstellungen wurden nicht eingetragen.</abbr></p>";
            }
        } else {
            echo "<p style='color: red;'><abbr title='Du kannst die Datenbank manuell importieren, die Datei findest du hier: /system/clanms.sql'><i class='bi-shield-exclamation'></i> Datenbank wurde nicht befüllt!</abbr></p>";
        }
        echo "<p>Weitere Fehlermeldungen: $errorMsg </p>";
    } else {
        echo "<p style='color: red;'><abbr title='Wir konnten leider deine Datenbankeinstellungen nicht speichern. Das kann an mangelnden Dateiberechtigungen liegen. Du kannst sie jedoch manuell einspeichern (system/db_settings.php).'><i class='bi-shield-exclamation'></i> Fehler beim schreiben der Datenbank-Einstellungen.</abbr></p>";
        echo "<p>Weitere Fehlermeldungen: $errorMsg </p>";
    }
    echo "<a href='../'><h3><i class='bi-box-arrow-up-left'></i> Hier kommst du zu deiner Seite</h3></a>";
    echo "</div>";

    function writeDbSettings() {
        global $errorMsg;
        $file = '../system/db_settings.php';
        $content = '<?php
        $installFlag = false;
        $dbpre = "clanms_";
        $dbhost = "'.$_SESSION["installer"]->params[1]["host"].'";
        $dbpw = "'.$_SESSION["installer"]->params[1]["password"].'";
        $dbuser = "'.$_SESSION["installer"]->params[1]["user"].'";
        $db = "'.$_SESSION["installer"]->params[1]["database"].'";
    ?>';
        if(file_put_contents($file, $content)) {
            return true;
        }    else {
            $errorMsg .= "<br>Datei ../system/db_settings.php konnte nicht beschrieben werden!";
            return false;
        }
    }

    function importSQL() {
        global $errorMsg;
        $sqlFile = '../system/clanms.sql';
        $multiquery = file_get_contents($sqlFile);
        if($mysqli = mysqli_connect($_SESSION["installer"]->params[1]['host'], $_SESSION["installer"]->params[1]['user'], $_SESSION["installer"]->params[1]['password'], $_SESSION["installer"]->params[1]['database'])) {
            if($mysqli->select_db($_SESSION["installer"]->params[1]['database'])) {
                $templine = '';
                $lines = file($sqlFile);
                foreach ($lines as $line) {
                    if (substr($line, 0, 2) == '--' || $line == '')
                        continue;
                        $templine .= $line;
                        if (substr(trim($line), -1, 1) == ';')
                        {
                            if(!$mysqli->query($templine)){
                                $errorMsg .= "<br>Konnte Zeile $templine nicht in Datenbank schreiben.";
                            }
                            $templine = '';
                        }
                    }
            } else {
                $errorMsg .= "<br>Zugriff auf die angegebene Datenbank nicht möglich (wurde sie eingerichtet?).";
            }


            if($mysqli->multi_query($multiquery)) {
                $mysqli->close();
                return true;
            } else {
                $mysqli->close();
                $errorMsg .= "<br>Datenbankdatei konnte nicht importiert werden. (Für einen manuellen import findest du sie im Ordner system -> clanms.sql";
                return false;
            }
        } else {
            $errorMsg .= "<br>Datenbankverbindung konnte nicht hergestellt werden.";
            return false;
        }
    }

    function writeUserSettings() {
        global $errorMsg;
        $id = 1;
        $getuser = $_SESSION['installer']->params[2]['username'];
        $getpass = $_SESSION['installer']->params[2]['userpw'];
        $getmail = $_SESSION['installer']->params[2]['usermail'];
        $gettitle = $_SESSION['installer']->params[2]['pageTitle'];
        $mysqli = mysqli_connect($_SESSION["installer"]->params[1]['host'], $_SESSION["installer"]->params[1]['user'], $_SESSION["installer"]->params[1]['password'], $_SESSION["installer"]->params[1]['database']);
        
        $getuser = mysqli_escape_string($mysqli, $getuser);
        $getpass = mysqli_escape_string($mysqli, $getpass);
        $getmail = mysqli_escape_string($mysqli, $getmail);
        $gettitle = mysqli_escape_string($mysqli, $gettitle);

        $password = password_hash($getpass, PASSWORD_DEFAULT);
        $activated = 1;
        
        $stmt = $mysqli->prepare("UPDATE clanms_user SET username=?, password=?, activated=?, email=? WHERE id=?");
        $stmt->bind_param("ssisi", $getuser, $password, $activated, $getmail, $id);
        if(!$stmt->execute()) {
            $mysqli->close();
            $errorMsg .= "<br>Zugangsdaten Adminaccount konnten nicht eingetragen werden, das kannst du jedoch auch nachträglich noch tun. Der Standardzugang ist: (email) admin@clanms.de (passwort) 1234";
            return false;
        } else {
            $stmt->close();
            $setting = "title";
            $stmt = $mysqli->prepare("UPDATE `clanms_settings` SET `value` = ? WHERE `clanms_settings`.`property` = ? ");
            $stmt->bind_param("ss", $gettitle, $setting);
            if(!$stmt->execute()) {
                $mysqli->close();
                $errorMsg .= "<br>Homepagetitel konnte nicht geändert werden, das kannst du jedoch auch nachträglich noch tun.";
                return false;
            } else {
                $stmt->close();
                $mysqli->close();
                return true;
            }
        }
    }
?>