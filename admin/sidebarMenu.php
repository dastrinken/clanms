<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Homepage</span>
    </h6>
    <ul class="nav flex-column">
        <li class="nav-item">
        <!-- TODO: klasse active per js umsetzen auf den richtigen (angeklickten) Menüpunkt -->
        <a id="dashboardLink" class="nav-link active" aria-current="page" href="./" onclick="setActive(this.id);">
            Dashboard
        </a>
        </li>
        <li class="nav-item">
        <a id="newsLink" class="nav-link" href="#" onclick="getTableView('newsblog', 'all'); setActive(this.id); return false;">
            Newsblog
        </a>
        </li>
        <li class="nav-item">
        <a id="galleryLink" class="nav-link" href="#"  onclick="getTableView('gallery', 'all'); setActive(this.id); return false;">
            Gallerie
        </a>
        </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Events</span>
    </h6>
    <ul class="nav flex-column">
        <li class="nav-item">
        <!-- TODO: klasse active per js umsetzen auf den richtigen (angeklickten) Menüpunkt -->
        <a id="eventLink" class="nav-link" aria-current="page" href="#" onclick="getTableView('events', 'all'), setActive(this.id); return false;">
            Eventorganizer
        </a>
        </li>
        <li class="nav-item">
        <a id="eventSettingsLink" class="nav-link" href="#" onclick="setActive(this.id); return false;">
            Einstellungen
        </a>
        </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Accounts</span>
    </h6>
    <ul class="nav flex-column">
        <li class="nav-item">
        <!-- TODO: klasse active per js umsetzen auf den richtigen (angeklickten) Menüpunkt -->
        <a id="userLink" class="nav-link" aria-current="page" href="#" onclick="setActive(this.id); return false;">
            Benutzer
        </a>
        </li>
        <li class="nav-item">
        <a id="groupsLink" class="nav-link" href="#" onclick="setActive(this.id); return false;">
            Gruppen
        </a>
        </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Statistiken</span>
    </h6>
    <ul class="nav flex-column">
        <li class="nav-item">
        <!-- TODO: klasse active per js umsetzen auf den richtigen (angeklickten) Menüpunkt -->
        <a id="statHomepage" class="nav-link" aria-current="page" href="#" onclick="setActive(this.id); return false;">
            Homepage
        </a>
        </li>
        <li class="nav-item">
        <a id="statUser" class="nav-link" href="#" onclick="setActive(this.id); return false;">
            User
        </a>
        </li>
    </ul>

    </div>
</nav>