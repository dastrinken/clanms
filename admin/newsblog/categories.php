<?php 
    require(__DIR__."/../scripts/adminfunctions.php");

    include(__DIR__."/categories_menu.php");
    $tableView = getNewsCatsFromDB();
?>
<div id="mainContent" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <!-- Adminview: Newsblog -->
    <div id="contentWrapper" class="container">
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