<?php
    /* TODO: Include all important files 
    ** - Start session, set all cookies
    */
    if(session_start()) {
        $userid = $_SESSION['userid'];
        $username = $_SESSION['username'];
    }
    require("./system/dbconnect.php");
    require("./system/functions.php");
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/style.css"> 
    <script src="./bootstrap/js/bootstrap.bundle.js"></script>
    <script src="./system/js/script.js"></script>
    <?php echo "<title>$title</title>" ?>
</head>
<body class="bg-dark text-white">
    <main>
    <?php require("./sidebar.php"); ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <?php require("./header.php"); ?>
                    </div>
                    <!-- This extra row is for optional sub-pages. Can be enabled and disabled by admin-backend
                    <div class="row">
                        <?php //require("./nav.php"); ?>
                    </div> 
                    -->
                    <!-- Content -->
                    <div id="mainContent" class="row p-3 bg-blackened overflow-auto">
                        <?php 
                        /* 
                            Hier wird der eigentliche Inhalt geladen, das könnte wie folgt aussehen...
                            in der Datei header.php wird ein GET-Parameter mittels link (a-tag) übergeben, z.B. so:
                                <li><a href="./?nav=info" class="nav-link px-2 link-dark">About us</a></li>
                            hier in index.php wird eine Kontrollstruktur angelegt, die nach GET-Parametern entscheidet, was angezeigt wird.
                            Mit gegebenem Beispiellink etwa so:
                            if($_GET['nav'] === info) {
                                include('./content/info.php');
                            } elseif( - anderer GET-Parameter - ) {
                                include('./andere/seite.php');
                            } elseif ...

                            usw., gefolgt von einem letzten:
                            else {
                                include('./content/landingpage.php');
                            }

                            Der Code sollte anschließend zur besseren Lesbarkeit in eine andere Datei ausgelagert und hier per require(); eingebunden werden.
                        */
                        if($_GET['code']) {
                            include("./system/login/activation.php");
                        } else {
                            for($i = 0; $i < 5; $i++) {
                                include("./content/articles/article_template.php"); 
                            }
                        }
                            /* TODO: 
                            **   - autom. include all articles
                            **   - avoid potential security risk when using get
                            */
                        ?>
                    </div>
                </div>
            </div>
            <div class="row"><!-- Footer -->
                <?php include("./footer.php"); ?>
            </div>
        </div>
    </main>
</body>
</html>