<!-- First off, general div and nav items for the sidebar -->
<div id='sidebar' class='d-flex flex-column flex-shrink-0 bg-lightdark float-start sidebar fixed-top' style='width: 4.5rem;'>
  <div class='nav-item' style='display: block; width: 100%; height: 5%;'></div>
  <ul class='nav nav-pills nav-flush flex-column mb-auto text-center'>

    <li class='nav-item'>
      <a href='./' class='nav-link py-3 border-bottom border-dark' aria-current='page' title='Home' data-bs-toggle='tooltip' data-bs-placement='right' data-bs-original-title='Home'>
          <img class='bi' src='./bootstrap/icons/house.svg' width='24' height='24' alt='Home'></img>
      </a>
    </li>
    
    <li class='nav-item'>
      <a href='#' class='nav-link py-3 border-bottom border-dark' aria-current='page' title='Calendar' data-bs-toggle='tooltip' data-bs-placement='right' data-bs-original-title='Calendar'>
          <img src='./bootstrap/icons/calendar-event.svg' width='24' height='24' alt='Calendar'></img>
      </a>
    </li>
<!-- Followed by optional Nav-Items for specific user groups -->
    <?php
      if($_SESSION['username'] && $_SESSION['userid']) {
        if(getUserGroup($_SESSION['userid']) <= 2) { // Admin = 1, Moderator = 2, bessere Lösungs wünschenswert! 
          echo "<li class='nav-item'>
                  <a href='./admin' class='nav-link py-3 border-bottom border-dark' aria-current='page' title='Admin Dashboard' data-bs-toggle='tooltip' data-bs-placement='right' data-bs-original-title='Admin_Dashboard'>
                      <img src='./bootstrap/icons/robot.svg' width='24' height='24' alt='Admin-Dashboard'></img>
                  </a>
                </li>";
        }
      }
    ?>
  </ul>
<!-- Dropdown menu, only available when logged in -->
  <?php 
    if($_SESSION['userid'] && $_SESSION['username']) {
      echo "<!-- TODO: Sidebar je nach Benutzerstatus (Gruppen / Berechtigungen) anpassen! -->
            <div class='dropdown border-top border-dark'>
              <a href='#' class='d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none dropdown-toggle' id='dropdownUser3' data-bs-toggle='dropdown' aria-expanded='false'>
                ".getProfilePic(24, 1)."
              </a>
              <ul class='dropdown-menu text-small shadow' aria-labelledby='dropdownUser3'>
                <li><a class='dropdown-item' href='./?nav=profile'>Profile</a></li>
                <li><hr class='dropdown-divider'></li>
                <li><a class='dropdown-item' href='#' onclick='destroy_session();return false;'>Sign out</a></li>
              </ul>
            </div>";
    }
  ?>
</div>