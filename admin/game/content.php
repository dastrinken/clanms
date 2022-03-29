<?php
    require(__DIR__."/../scripts/adminfunctions.php");

    switch($_GET['displayOption']) {
        case "all":
            $displayOption = "all";
            break;
        case "admin":
            $displayOption = "admin";
            break;
        case "moderator":
            $displayOption = "moderator";
            break;
        case "member":
            $displayOption = "member";
            break;
        case "registered":
            $displayOption = "registered";
            break;
        default:
            $displayOption = "all";
            break;
    }
    $tableView = getGamesFromDB($displayOption);

    include(__DIR__."/content_menu.php");
?>

<div id="mainContent" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <!-- Adminview: Newsblog -->
    <div id="contentWrapper" class="container">
        <div class="row">
            <div id="usersTable" class="col">
                <!-- table view of all articles -->
                <?php 
                include(__DIR__."/navTableView.php");
                echo $tableView; 
                ?>
            </div>
        </div>
        <div class="row">
            <!-- footer menu ?? -->
        </div>
    </div>
</div>