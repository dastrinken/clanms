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
    $tableView = getGroupsFromDB();

    include(__DIR__."/content_menu.php");
?>

<div id="mainContent" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <!-- Adminview: Groups -->
    <div id="contentWrapper" class="container">
        <div class="row">
            <div id="groupsTable" class="col">
                <!-- table view of all groups -->
                <?php 
                    foreach($tableView as $group) {
                        $groupTitle = selectOneRow_DB("title", "clanms_groups", "id", $group);
                        echo "<div class='accordion accordion-flush' id='accordion$group'>
                                <div class='accordion-item bg-light rounded-0'>
                                    <h2 class = 'accordion-header' id='heading$group'>
                                        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$group' aria-expanded='true' aria-controls='collapse$group'>
                                            <span>$groupTitle</span>
                                        </button>
                                    </h2>
                                    <div id='collapse$group' class='accordion-collapse collapse' aria-labelledby='heading$group' data-bs-parent='#accordion$group'>
                                        <div class='accordion-body'>";
                        showRightsTable($group);
                        echo "</div>
                                </div>
                            </div>
                        </div>";
                    } 
                ?>
            </div>
        </div>
        <div class="row">
            <!-- footer menu ?? -->
        </div>
    </div>
</div>