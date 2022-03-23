<?php
    require(__DIR__."/../scripts/adminfunctions.php");

    //TODO: richtige Anzeigeoptionen für Gallerien überlegen und einfügen

    include(__DIR__."/contentMenu.php");
?>

<div id="mainContent" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <!-- Adminview: Newsblog -->
    <div id="contentWrapper" class="container">
        <div class="row d-flex">
            <!-- table view of all articles -->
            <?php 
            getGalleriesFromDB();
            
            //include(__DIR__."/gallery.php");
            //echo $tableView;
            ?>
        </div>
        <div class="row">
            <!-- footer menu ?? -->
        </div>
    </div>
</div>