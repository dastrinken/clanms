<?php
/* Ideen:
** 1. Siehe Ablaufmodellierung
** 2. Diese Datei soll die erste sein, die der Nutzer nach Upload des gesamten Verzeichnisses sieht!
**    - Dazu soll sie zu Beginn im "Hauptordner" liegen und die eigentliche index.php ersetzen
** 3. Diese Datei soll nach gelungener Installation automatisch "inaktiviert" und in den Ordner "install" verschoben werden.

*/
if ($_GET['destroy'] == 1) {
    session_start();
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    echo 'Session was destroyed';
}
/* den hierüber liegenden codeblock vor release entfernen! */
include(__DIR__ . "/installer.php");
session_start();
if (!isset($_SESSION['installer'])) {
    $_SESSION['installer'] = new Installer();
}
if ($_SESSION['installer']->validateCurrentStep()) {
    if ($_POST['next'] or $_POST['finish']) {
        $_SESSION['installer']->params[$_SESSION['installer']->step - 1] = $_POST;
        $_SESSION['installer']->step++;
    }
    if ($_POST['back']) {
        $_SESSION['installer']->step--;
    }
}

/*
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
*/
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
    <link rel="stylesheet" href="./install.css">
    <title>ClanMS - Installation</title>
</head>

<body class="bg-blackened text-white">
    <main>
        <div class="container-fluid">
            <div class="row">
                <?php include(__DIR__ . "/header.php"); ?>
            </div>
            <div class="row">
                <div class="container">
                    <div id="mainContent" class="row p-3 bg-blackened overflow-auto justify-content-md-center">
                        <div class="content mb-4 p-3 bg-lightdark col-md-auto shadow-sm rounded">
                            <form action="./" method="post">
                                <?php
                                    echo $_SESSION['installer']->getContent();
                                ?>
                                <div id="navigation">
                                    <?php
                                    if ($_SESSION['installer']->showReturnButton()) {
                                        echo '<input id="btnBack" type="submit" name="back" value="Zurück" />';
                                    }
                                    if ($_SESSION['installer']->showFwdButton()) {
                                        echo '<input id="btnNext" type="submit" name="next" value="Weiter" />';
                                    }
                                    if ($_SESSION['installer']->showFinalButton()) {
                                        echo '<input id="btnFinish" type="submit" name="finish" value="Abschlie&szlig;en" />';
                                    }
                                    ?>
                                </div>
                            </form>
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