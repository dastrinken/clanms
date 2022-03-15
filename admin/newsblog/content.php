<?php
    require(__DIR__."/../../system/dbconnect.php");
    require(__DIR__."/../../system/functions.php");
    require(__DIR__."/../scripts/adminfunctions.php");
    require(__DIR__."/../../parsedown/parsedown.php");

    switch($_GET['articles']) {
        case "all":
            $displayOption = "all";
            break;
        case "week":
            $displayOption = "week";
            break;
        case "month":
            $displayOption = "month";
            break;
        case "commented":
            $displayOption = "comment";
            break;
        default:
            $displayOption = "all";
            break;
    }
    $tableView = getArticlesFromDB($displayOption);

    include(__DIR__."/contentMenu.php");
?>

<div id="mainContent" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <!-- Adminview: Newsblog -->
    <div id="newsBlogContainer" class="container">
        <div class="row">
            <div id="newsTable" class="col">
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