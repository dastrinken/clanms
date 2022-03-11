<?php
    require(__DIR__."/../../system/dbconnect.php");
    require(__DIR__."/../../system/functions.php");
    require(__DIR__."/../scripts/adminfunctions.php");
    require(__DIR__."/../../parsedown/parsedown.php");

    switch($_GET['articles']) {
        case "all":
            $newsblog = getArticlesFromDB("all");
            break;
        case "week":
            $newsblog = getArticlesFromDB("week");
            break;
        case "month":
            $newsblog = getArticlesFromDB("month");
            break;
        case "commented":
            $newsblog = getArticlesFromDB("comment");
            break;
        default:
            $newsblog = getArticlesFromDB("all");
            break;
    }
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
                <li><a id="thisWeeksArticles" class="dropdown-item" href="#" onclick="page = 1; getNewsBlog('all'); return false;">Alle Artikel</a></li>
                <li><a id="thisWeeksArticles" class="dropdown-item" href="#" onclick="page = 1; getNewsBlog('week'); return false;">Diese Woche</a></li>
                <li><a id="thisMonthsArticles" class="dropdown-item" href="#" onclick="page = 1; getNewsBlog('month'); return false;">Dieser Monat</a></li>
                <li><a id="articlesComments" class="dropdown-item" href="#" onclick="page = 1; getNewsBlog('commented'); return false;">Kommentare</a></li>
            </ul>
        </div>

    </div>
    </div>

    <div id="mainContent" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <!-- Content of specific menu -->
        <div id="newsBlogContainer" class="container">
            <div class="row">
                <div id="newsTable" class="col">
                    <!-- table view of all articles -->
                    <ul id="newsTableNav" class="nav d-flex justify-content-between mb-3">
                        <li class="d-flex nav-item justify-content-center align-items-center border border-secondary rounded-start">
                            <a href="#" class="nav-link rounded-start" onclick="page > 1 ? --page : page = 1; getNewsBlog(saveContent); return false;">
                                <i class="bi-arrow-left"></i>
                            </a>
                        </li>
                        <li id="showPageNr" class="d-flex flex-grow-1 nav-item justify-content-center align-items-center border"></li>
                        <li class="d-flex nav-item justify-content-center align-items-center border border-secondary rounded-end">
                            <a href="#" class="nav-link rounded-end" onclick="page < <?php echo $totalPages; ?> ? ++page : page = <?php echo $totalPages; ?>; getNewsBlog(saveContent); return false;">
                                <i class="bi-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                    <?php echo $newsblog; ?>
                </div>
            </div>
            <div class="row">
                <!-- footer menu ?? -->
            </div>
        </div>
    </div>