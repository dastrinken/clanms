<header class="p-3 d-flex flex-wrap align-items-center justify-content-center justify-content-md-between mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
        <!-- Logo TODO: select logo name from database -->
        <img class="bi" src="./ressources/icons/clanms_logo.svg" width="70" height="50" alt="Logo"></img>
    </a>

    <ul class="nav justify-content-center">
        <li><a href="#" class="nav-link px-4 link-dark">Home</a></li>
        <li><a href="#" class="nav-link px-4 link-dark">Blog</a></li>
        <li><a href="#" class="nav-link px-4 link-dark">About us</a></li>
        <li><a href="#" class="nav-link px-4 link-dark">Games</a></li>
        <li><a href="#" class="nav-link px-4 link-dark">FAQ</a></li>
    </ul>

    <div class="col-md-3 text-end">
        <button type="button" class="btn btn-darkmode-outline me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button>
        <button type="button" class="btn btn-darkmode">Sign-up</button>
    </div>

    <!-- Modal triggered by login button TODO: include form to register and login, make it dynamic: one modal, two forms -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog text-dark">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Login to your account</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            TODO: Login form
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Login</button>
        </div>
        </div>
    </div>
    </div>

</header>
