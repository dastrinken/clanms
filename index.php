<?php
    /* TODO: Include all important files 
    ** - Start session, set all cookies
    */
    session_start();

    if($_SESSION['userid'] && $_SESSION['username']) {
        /* setze cookie -> lade seite neu */
        setcookie("login", "true");
    } else {
        setcookie("login", "false");
    }
    require("./system/dbconnect.php");
    require("./system/functions.php");
    //markdown parser
    require("./parsedown/parsedown.php");
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="./ressources/icons/clanms_logo.svg" sizes="any">
    <link rel="icon" href="./ressources/icons/clanms_logo.png" type="image/png">
    <link href="./bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="./bootstrap/icons/bootstrap-icons.css"> 
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
                    <!-- Content -->
                    <div id="mainContent" class="row p-3 bg-blackened overflow-auto">
                        <?php 
                            require("./system/sitemenu.php");
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