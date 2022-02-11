<!-- Example for a sidebar, has to be modified 
    TODO: position sticky/fixed
-->
<div class="d-flex flex-column flex-shrink-0 bg-lightdark float-start sidebar sticky-top" style="width: 4.5rem;">
  <div class="nav-item" style="display: block; width: 100%; height: 5%;">

  </div>
    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">

      <li class="nav-item">
        <a href="#" class="nav-link py-3 border-bottom border-dark" aria-current="page" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
            <img class="bi" src="./bootstrap/bootstrap-icons-1.8.0/house.svg" width="24" height="24" alt="Home"></img>
        </a>
      </li>
      
      <li class="nav-item">
        <a href="#" class="nav-link py-3 border-bottom border-dark" aria-current="page" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
            <img src="./bootstrap/bootstrap-icons-1.8.0/calendar-event.svg" width="24" height="24" alt="Calendar"></img>
        </a>
      </li>
    </ul>

    <div class="dropdown border-top border-dark">
      <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none dropdown-toggle" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="mdo" class="rounded-circle" width="24" height="24">
      </a>
      <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser3">
        <li><a class="dropdown-item" href="#">New project...</a></li>
        <li><a class="dropdown-item" href="#">Settings</a></li>
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Sign out</a></li>
      </ul>
    </div>
  </div>