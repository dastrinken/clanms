<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 id="headlineDashboardContent" class="h2"></h2>
    <!-- Headline elements of specific menu -->
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="newEntry('user'); return false;">Neu</button>
        </div>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="displayArticlesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi-person"></i>
                Anzeige
            </button>
            <ul class="dropdown-menu" aria-labelledby="displayArticlesDropdown">
                <li><a id="allUsers" class="dropdown-item" href="#" onclick="page = 1; getTableView(saveFolder, saveFile, 'all'); return false;">Alle Nutzer</a></li>
                <li><a id="adminUsers" class="dropdown-item" href="#" onclick="page = 1; getTableView(saveFolder, saveFile, 'admin'); return false;">Admins</a></li>
                <li><a id="modUsers" class="dropdown-item" href="#" onclick="page = 1; getTableView(saveFolder, saveFile, 'moderator'); return false;">Moderatoren</a></li>
                <li><a id="memberUsers" class="dropdown-item" href="#" onclick="page = 1; getTableView(saveFolder, saveFile, 'member'); return false;">Mitglieder</a></li>
                <li><a id="registeredUsers" class="dropdown-item" href="#" onclick="page = 1; getTableView(saveFolder, saveFile, 'registered'); return false;">Registrierte Nutzer</a></li>
            </ul>
        </div>
    </div>
</div>