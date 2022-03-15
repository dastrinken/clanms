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
<!--


ClanMS - A free Content Management System for gaming communities and everyone else.
Copyright (C) 2022  Armin Prinz, Silas Waldschmidt, Angela Rutkowski, Irina Imranov, Rayan Ahmed Bhatti, Sven Kwiatkowski

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.


 -->
</html>