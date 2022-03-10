<?php
  session_start();
  $userid = $_SESSION['userid'];
  $username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Armin Prinz">
    <title>ClanMS - Admin Dashboard</title>    
    
    <!-- Markdown Editor -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <!-- Bootstrap core CSS and icons -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../bootstrap/icons/bootstrap-icons.css" rel="stylesheet" > 
    <!-- Custom styles for this template -->
    <link href="./style/dashboard.css" rel="stylesheet">
    
    

    <?php 
      require(__DIR__."/../system/dbconnect.php");
      require(__DIR__."/../system/functions.php");
      require(__DIR__."/scripts/adminfunctions.php");
      //markdown parser
      require(__DIR__."/../parsedown/parsedown.php");
    ?>
  </head>
  <body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="./">ClanMS</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <div class="navbar-nav">
        <div class="nav-item text-nowrap">
          <a href='../' class='nav-link px-3 border-bottom border-dark' aria-current='page' title='Exit dashboard' data-bs-toggle='tooltip' data-bs-placement='right' data-bs-original-title='Exit dashboard'>
              <i class="link-icon bi-arrow-left-square" alt='Exit dashboard'></i>
          </a>
        </div>
      </div>
    </header>

    <!-- Sidebar Menu -->
    <div class="container-fluid">
      <div class="row">
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
                <a id="newsLink" class="nav-link" href="#" onclick="getNewsBlog('all'); setActive(this.id); return false;">
                  Newsblog
                </a>
              </li>
              <li class="nav-item">
                <a id="galleryLink" class="nav-link" href="#"  onclick="setActive(this.id); return false;">
                  Gallerie
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

        <!-- Main Content -->
        <main id="mainContentWrapper" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <h2>Willkommen zurück <?php echo $_SESSION['username']; ?>!</h2>
        </main>

      </div>
    </div>


    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script type="text/javascript">
      var userid = '<?php echo $userid; ?>';
      var username = '<?php echo $username; ?>';
    </script>
    <script src="./scripts/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
  </body>
</html>
