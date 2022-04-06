<header class="p-3 d-flex flex-wrap align-items-center justify-content-center justify-content-md-between mb-4 border-bottom border-dark shadow-sm">

    <a href="./" class="d-flex align-items-center mb-2 mb-md-0 text-dark text-decoration-none">
        <!-- Logo TODO: select logo name/location from database -->
        <img class="bi" src="./ressources/icons/clanms_logo.svg" width="70" height="50" alt="Logo"></img>
    </a>
    
    <!-- Hauptnavigation (oben) -->
    <ul class="nav justify-content-center">
        <li><a href="./" class="nav-link px-2 link-dark nav-darkmode">Home</a></li>
        <li><a href="./?nav=news&page=1" class="nav-link px-2 link-dark nav-darkmode">Blog</a></li>
        <li><a href="./?nav=info" class="nav-link px-2 link-dark nav-darkmode">About us</a></li>
        <li><a href="./?nav=calendar" class="nav-link px-2 link-dark nav-darkmode">Events</a></li>
        <li><a href="./?nav=gallery" class="nav-link px-2 link-dark nav-darkmode">Gallery</a></li>
        <li><a href="./?nav=faq" class="nav-link px-2 link-dark nav-darkmode">FAQ</a></li>
    </ul>
    <?php
        if(empty($_SESSION['userid']) || empty($_SESSION['username'])) {
            echo '<div class="col-md-2 text-end">
                        <button type="button" id="loginBtn" class="btn btn-darkmode-outline me-2" data-bs-toggle="modal" data-bs-target="#loginRegisterModal" onclick="openLoginRegisterModal(this.id)">Login</button>
                        <button type="button" id="signupBtn" class="btn btn-darkmode" data-bs-toggle="modal" data-bs-target="#loginRegisterModal" onclick="openLoginRegisterModal(this.id)">Sign-up</button>
                    </div>';
        } else {
            echo "<div class='dropdown border-dark'>
                    <a href='#' class='d-flex align-items-center justify-content-center pe-3 link-dark text-decoration-none dropdown-toggle' id='dropdownUser3' data-bs-toggle='dropdown' aria-expanded='false'>
                        ".getProfilePic(52, 1)."
                    </a>
                    <ul class='dropdown-menu dropdown-menu-dark text-small shadow' aria-labelledby='dropdownUser3'>
                        <li><a class='dropdown-item' href='./?nav=profile'>Profil</a></li>";
            if(checkPermission("admindashboard", false)) {
                echo "<li>
                        <a href='./admin' class='dropdown-item'>
                            Adminbereich
                        </a>
                    </li>";
            }
            echo "<li><hr class='dropdown-divider'></li>
                        <li><a class='dropdown-item' href='https://github.com/dastrinken/clanms/issues' target='_blank'>Problem melden</a></li>
                        <li><a class='dropdown-item' href='#' onclick='destroy_session();return false;'>Sign out</a></li>
                    </ul>
                    </div>";
        }
    ?>
</header>
