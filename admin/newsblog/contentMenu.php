<?php
    //Displaying all news

?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 id="headlineDashboardContent" class="h2">Newsblog - Artikelübersicht</h1>
    <!-- Headline elements of specific menu -->
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="writeArticle(); return false;">Neu</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Backup</button>
        </div>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="displayArticlesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi-calendar"></i>
                Alle Artikel
            </button>
            <ul class="dropdown-menu" aria-labelledby="displayArticlesDropdown">
                <li><a id="thisWeeksArticles" class="dropdown-item" href="#" onclick="newsDisplayOption(this.id); return false;">Diese Woche</a></li>
                <li><a id="thisMonthsArticles" class="dropdown-item" href="#" onclick="newsDisplayOption(this.id); return false;">Dieser Monat</a></li>
                <li><a id="articlesComments" class="dropdown-item" href="#" onclick="newsDisplayOption(this.id); return false;">Kommentare</a></li>
            </ul>
        </div>

    </div>
    </div>

    <div id="mainContent" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <!-- Content of specific menu -->
    <div id="newsBlogContainer" class="container">
        <div class="row">
            <h3 id="displayArticlesHeadline">Alle Artikel</h3>
        </div>
        <div class="row">
            <div class="col">
                <!-- table view of all articles -->
            </div>
        </div>
        <div class="row">
            <!-- footer menu ?? -->
        </div>
    </div>
    </div>