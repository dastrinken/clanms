<?php
    require(__DIR__."/../../system/dbconnect.php");
    require(__DIR__."/../../system/functions.php");
    require(__DIR__."/../scripts/adminfunctions.php");
    require(__DIR__."/../../parsedown/parsedown.php");
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 id="headlineDashboardContent" class="h2"></h1>
    <!-- Headline elements of specific menu -->
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="writeArticle(); return false;">Neu</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Backup</button>
        </div>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="displayArticlesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi-calendar"></i>
                Anzeige
            </button>
            <ul class="dropdown-menu" aria-labelledby="displayArticlesDropdown">
                <li><a id="thisWeeksArticles" class="dropdown-item" href="#" onclick="getNewsBlog('all'); return false;">Alle Artikel</a></li>
                <li><a id="thisWeeksArticles" class="dropdown-item" href="#" onclick="getNewsBlog('week'); return false;">Diese Woche</a></li>
                <li><a id="thisMonthsArticles" class="dropdown-item" href="#" onclick="getNewsBlog('month'); return false;">Dieser Monat</a></li>
                <li><a id="articlesComments" class="dropdown-item" href="#" onclick="getNewsBlog('commented'); return false;">Kommentare</a></li>
            </ul>
        </div>

    </div>
    </div>

    <div id="mainContent" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <!-- Content of specific menu -->
    <div id="newsBlogContainer" class="container">
        <div class="row border-bottom">
            <h3 id="displayArticlesHeadline"></h3>
        </div>
        <div class="row">
            <div id="newsTable" class="col">
                <!-- table view of all articles -->
                <?php
                    switch($_GET['articles']) {
                        case "all":
                            getArticlesFromDB("all");
                            break;
                        case "week":
                            getArticlesFromDB("week");
                            break;
                        case "month":
                            getArticlesFromDB("month");
                            break;
                        case "commented":
                            getArticlesFromDB("comment");
                            break;
                        default:
                            getArticlesFromDB("all");
                            break;
                    }
                ?>
            </div>
        </div>
        <div class="row">
            <!-- footer menu ?? -->
        </div>
    </div>
    </div>