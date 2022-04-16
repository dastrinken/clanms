<?php
    session_start();
    require(__DIR__."/admin/scripts/rights_system.php");
    require(__DIR__."/system/db_functions.php");
    require(__DIR__."/system/helper_functions.php");
    require(__DIR__."/system/account/account_functions.php");
    require(__DIR__."/parsedown/parsedown.php");
    if($_POST['nav']){
        header('Location: ./index.php?nav='.$_POST['nav'].'&page='.$_POST['page']);
    }
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
    <link rel="stylesheet" href="./simplemde/simplemde.min.css">
    <script src="./bootstrap/js/bootstrap.bundle.js"></script>
    <script src="./system/js/constants.js"></script>
    <script src="./system/js/jquery.js"></script>
    <script src="./simplemde/simplemde.min.js"></script>
    <!-- Newsblog -->
    <script src="./content/newsblog/newsblog.js"></script>
    <!-- Gallery -->
    <script src="./content/gallery/gallery.js"></script>
    <?php echo "<title>$title</title>" ?>
</head>
<body class="bg-dark text-white">
    <main>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div id="stickyHeader" class="row">
                        <?php require("./header.php"); ?>
                    </div>                    
                    <!-- Content -->
                    <div id="mainContent" class="row p-3 bg-blackened shadow overflow-auto">
                        <?php 
                            require(__DIR__."/sitemenu.php");
                        ?>
                    </div>
                </div>
            </div>
            <div class="row"><!-- Footer -->
                <?php include("./footer.php"); ?>
            </div>
        </div>
    </main>

    <!-- Modal triggered by login button -->
    <div class="modal fade" id="loginRegisterModal" tabindex="-1" aria-labelledby="loginRegisterModalLabel" aria-hidden="true">
        <div class="modal-dialog text-light">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginRegisterModalLabel">Login to your account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="loginSignupModalBody" class="modal-body">
                <!-- Login / Register form -->
            </div>
            </div>
        </div>
    </div>
    <script src="./system/js/script.js"></script>
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
