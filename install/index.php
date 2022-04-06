<?php
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
                                <div class="row">
                                    <?php
                                    if($_SESSION['installer']->step == 1 || $_SESSION['installer']->step == $_SESSION['installer']->allsteps) {
                                        echo '<div class="col d-flex justify-content-center">';
                                    } else {
                                        echo '<div class="col d-flex justify-content-between">';
                                    }
                                    if ($_SESSION['installer']->showReturnButton()) {
                                        echo '<input id="btnBack" class="btn btn-primary w-25" type="submit" name="back" value="Zurück" />';
                                    }
                                    if ($_SESSION['installer']->showFwdButton()) {
                                        echo '<input id="btnNext" class="btn btn-primary w-25" type="submit" name="next" value="Weiter" />';
                                    }
                                    if ($_SESSION['installer']->showFinalButton()) {
                                        echo '<input id="btnFinish" class="btn btn-primary w-25" type="submit" name="finish" value="Abschlie&szlig;en" />';
                                    }
                                    ?>
                                    </div>
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