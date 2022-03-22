<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 id="headlineDashboardContent" class="h2"></h1>
    <!-- Headline elements of specific menu -->
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="newEntry('event'); return false;">Neu</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Backup</button>
        </div>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="displayArticlesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi-calendar-week"></i>
                Anzeige
            </button>
            <ul class="dropdown-menu" aria-labelledby="displayArticlesDropdown">
                <li><a id="thisWeeksArticles" class="dropdown-item" href="#" onclick="page = 1; getTableView('events', 'all'); return false;">Alle Events</a></li>
                <li><a id="thisWeeksArticles" class="dropdown-item" href="#" onclick="page = 1; getTableView('events', 'week'); return false;">Diese Woche</a></li>
                <li><a id="thisMonthsArticles" class="dropdown-item" href="#" onclick="page = 1; getTableView('events', 'month'); return false;">Dieser Monat</a></li>
            </ul>
        </div>
    </div>
</div>