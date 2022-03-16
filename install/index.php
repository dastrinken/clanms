<?php
/* Ideen:
** 1. Siehe Ablaufmodellierung
** 2. Diese Datei soll die erste sein, die der Nutzer nach Upload des gesamten Verzeichnisses sieht!
**    - Dazu soll sie zu Beginn im "Hauptordner" liegen und die eigentliche index.php ersetzen
** 3. Diese Datei soll nach gelungener Installation automatisch "inaktiviert" und in den Ordner "install" verschoben werden.

*/
if(isset($_POST['destroy'])) {
    session_start();
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
       $params = session_get_cookie_params();
       setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
       );
    }
    session_destroy();
    echo 'Session was destroyed';
}
/* den hierüber liegenden codeblock vor release entfernen! */
session_start();
$progress = $_GET['progress'];
if(isset($_POST['start'])) {
    $progress = 1;
} elseif(isset($_POST['admin'])) {
    $progress = 2;
    $_SESSION['dbuser'] = $_POST['dbuser'];
    $_SESSION['dbpw'] = $_POST['dbpw'];
    $_SESSION['dbhost'] = $_POST['dbhost'];
} elseif(isset($_POST['install'])) {
    $progress = 3;
    $_SESSION['pageTitle'] = $_POST['pageTitle'];
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['userpw'] = $_POST['userpw'];
}

$dbuser = $_SESSION['dbuser'];
$dbpw = $_SESSION['dbpw'];
$dbhost = $_SESSION['dbhost'];

$title = $_SESSION['pageTitle'];
$username = $_SESSION['username'];
$userpw = $_SESSION['userpw'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css"> 
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="../bootstrap/icons/bootstrap-icons.css"> 
    <script src="../system/js/script.js"></script>
    <title>ClanMS - Installation</title>
</head>
<body class="bg-blackened text-white">
    <main>
        <div class="container-fluid">
            <div class="row">
                <?php include("./header.php"); ?>
            </div>
            <div class="row">
                <div class="container">
                    <div id="mainContent" class="row p-3 bg-blackened overflow-auto justify-content-md-center">
                        <div class="content mb-4 p-3 bg-lightdark col-md-auto shadow-sm rounded">
                            <?php 
                            /* Idee: Bei erstem Aufruf wird welcome.php aufgerufen, hier kann man sich durch die installation klicken
                                    Man kann jedoch jederzeit über den Header die einzelnen Formulare mit den bisher eingefüllten Daten aufrufen.
                            */
                            switch ($progress) {
                                case 0:
                                    if(include("./contents/welcome.php")) {
        
                                    } else {
                                        echo "<p class='lead'>
                                        Wenn du diese Nachricht siehst, hat etwas nicht geklappt.
                                        Versuche die Dateien erneut auf den Server zu laden.<br/>
                                        Sollte das nicht klappen, kontaktiere uns gerne auf <a href='https://github.com/dastrinken/clanms' target='_blank'><img class='bi' src='../bootstrap/bootstrap-icons-1.8.0/github.svg' width='24' height='24'></img>GitHub</a>
                                        </p>";
                                    }
                                    break;
                                case 1:
                                    /* database.php einbinden */
                                    if(include("./contents/database.php")) {
        
                                    } else {
                                        echo "<p class='lead'>
                                        Wenn du diese Nachricht siehst, hat etwas nicht geklappt.
                                        Versuche den vorherigen Schritt zu wiederholen und prüfe deine Eingaben.<br/>
                                        Notfalls lade die Dateien erneut auf deinen Webserver.<br/>
                                        Sollte das nicht klappen, kontaktiere uns gerne auf <a href='https://github.com/dastrinken/clanms' target='_blank'><img class='bi' src='../bootstrap/bootstrap-icons-1.8.0/github.svg' width='24' height='24'></img>GitHub</a>
                                        </p>";
                                    }
                                    break;
                                case 2:
                                    /* settings.php einbinden */
                                    if(include("./contents/settings.php")) {
        
                                    } else {
                                        echo "<p class='lead'>
                                        Wenn du diese Nachricht siehst, hat etwas nicht geklappt.
                                        Versuche den vorherigen Schritt zu wiederholen und prüfe deine Eingaben.<br/>
                                        Notfalls lade die Dateien erneut auf deinen Webserver.<br/>
                                        Sollte das nicht klappen, kontaktiere uns gerne auf <a href='https://github.com/dastrinken/clanms' target='_blank'><img class='bi' src='../bootstrap/bootstrap-icons-1.8.0/github.svg' width='24' height='24'></img>GitHub</a>
                                        </p>";
                                    }
                                    break;
                                case 3:
                                    /* installation ausführen, progress anzeigen? */
                                    if(include("./contents/confirm.php")) {
        
                                    } else {
                                        echo "<p class='lead'>
                                        Wenn du diese Nachricht siehst, hat etwas nicht geklappt.
                                        Versuche den vorherigen Schritt zu wiederholen und prüfe deine Eingaben.<br/>
                                        Notfalls lade die Dateien erneut auf deinen Webserver.<br/>
                                        Sollte das nicht klappen, kontaktiere uns gerne auf <a href='https://github.com/dastrinken/clanms' target='_blank'><img class='bi' src='../bootstrap/bootstrap-icons-1.8.0/github.svg' width='24' height='24'></img>GitHub</a>
                                        </p>";
                                    }
                                    break;
                                default:
                                    if(include("./contents/welcome.php")) {
        
                                    } else {
                                        echo "<p class='lead'>
                                        Wenn du diese Nachricht siehst, hat etwas nicht geklappt.
                                        Versuche die Dateien erneut auf den Server zu laden.<br/>
                                        Sollte das nicht klappen, kontaktiere uns gerne auf <a href='https://github.com/dastrinken/clanms' target='_blank'><img class='bi' src='../bootstrap/bootstrap-icons-1.8.0/github.svg' width='24' height='24'></img>GitHub</a>
                                        </p>";
                                    }
                                    break;
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php include("./footer.php"); ?>
            </div>
        </div>
    </main>
</body>
</html>

