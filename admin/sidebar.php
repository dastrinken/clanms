<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse overflow-auto">
    <div class="position-sticky pt-3">
        <!-- Homepage -->
        <div class="accordion accordion-flush" id="accordionSidebar">
            <div class="accordion-item bg-light rounded-0">
                <h6 id="headingOne" class="sidebar-heading accordion-header d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
                    <span>Homepage</span>
                    <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="bi-list"></i>
                    </button>
                </h6>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionSidebar">
                    <div class="accordion-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a id="dashboardLink" class="nav-link active" aria-current="page" href="#" onclick="showDashboard(this.id); setActive(this.id); return false;">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="settingsLink" class="nav-link" aria-current="page" href="#" onclick="showDashboard(this.id); setActive(this.id); return false;">
                                    Einstellungen
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Newsblog -->
        <div class="accordion accordion-flush" id="accordionSidebarTwo">
            <div class="accordion-item bg-light rounded-0">
                <h6 id="headingTwo" class="sidebar-heading accordion-header d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
                    <span>Newsblog</span>
                    <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="bi-list"></i>
                    </button>
                </h6>
                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebarTwo">
                    <div class="accordion-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a id="newsLink" class="nav-link" href="#" onclick="getTableView('newsblog', 'content', 'all'); setActive(this.id); return false;">
                                    Übersicht
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="newsCatLink" class="nav-link" aria-current="page" href="" onclick="getTableView('newsblog', 'categories', 'all'); setActive(this.id); return false;">
                                    Kategorien
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="newsTagsLink" class="nav-link" aria-current="page" href="#" onclick="setActive(this.id); return false;">
                                    Tags
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Events -->
        <div class="accordion accordion-flush" id="accordionSidebarThree">
            <div class="accordion-item bg-light rounded-0">
                <h6 id="headingThree" class="sidebar-heading accordion-header d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
                    <span>Eventorganizer</span>
                    <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        <i class="bi-list"></i>
                    </button>
                </h6>
                <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionSidebarThree">
                    <div class="accordion-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a id="eventLink" class="nav-link" aria-current="page" href="#" onclick="getTableView('events', 'content', 'all'); setActive(this.id); return false;">
                                    Übersicht
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="eventCatLink" class="nav-link" aria-current="page" href="" onclick="getTableView('events', 'categories', 'all'); setActive(this.id); return false;">
                                    Kategorien
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="gamesLink" class="nav-link" aria-current="page" href="" onclick="getTableView('game', 'content','all');setActive(this.id); return false;">
                                    Spiele
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallerie -->
        <div class="accordion accordion-flush" id="accordionSidebarFive">
            <div class="accordion-item bg-light rounded-0">
                <h6 id="headingFive" class="sidebar-heading accordion-header d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
                    <span>Gallerie</span>
                    <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                        <i class="bi-list"></i>
                    </button>
                </h6>
                <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive" data-bs-parent="#accordionSidebarFive">
                    <div class="accordion-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a id="gallLink" class="nav-link" href="#" onclick="getTableView('gallery', 'content', 'all'); setActive(this.id); return false;">
                                    Übersicht
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="gallSettingsLink" class="nav-link" aria-current="page" href="#" onclick="setActive(this.id); return false;">
                                    Einstellungen
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Accounts -->
        <div class="accordion accordion-flush" id="accordionSidebarFour">
            <div class="accordion-item bg-light rounded-0">    
                <h6 id="headingFour" class="sidebar-heading accordion-header d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
                    <span>Accounts</span>
                    <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                        <i class="bi-list"></i>
                    </button>
                </h6>
                <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFour" data-bs-parent="#accordionSidebarFour">
                    <div class="accordion-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a id="userLink" class="nav-link" aria-current="page" href="#" onclick="getTableView('user', 'content', 'all'); setActive(this.id); return false;">
                                    Benutzer
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="groupsLink" class="nav-link" href="#" onclick="getTableView('groups', 'content', 'all'); setActive(this.id); return false;">
                                    Gruppen
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- Statistiken (vorerst nicht für Release geplant)
        <div class="accordion accordion-flush" id="accordionSidebarSix">
            <div class="accordion-item bg-light rounded-0">
                <h6 id="headingSix" class="sidebar-heading accordion-header d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
                    <span>Statistiken</span>
                    <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                        <i class="bi-list"></i>
                    </button>
                </h6>
                <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix" data-bs-parent="#accordionSidebarSix">
                    <div class="accordion-body">    
                        <ul class="nav flex-column">
                            <li class="nav-item">
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
                </div>
            </div>
        </div>
        -->
    </div>
</nav>