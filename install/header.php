<header class="p-3 d-flex flex-wrap align-items-center justify-content-center justify-content-md-between mb-4 border-bottom border-dark">
    
    <link rel="icon" href="../ressources/icons/clanms_logo.svg">

    <a href="./" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
        <!-- Logo TODO: select logo name/location from database -->
        <img class="bi" src="../ressources/icons/clanms_logo.svg" width="70" height="50" alt="Logo"></img>
    </a>
    
    <ol class="nav justify-content-center">
        <?php
        $i = 1;
        foreach ($_SESSION['installer']->steps as $step) {
            echo "<li class='nav-link px-2 link-dark ";
            if ($i < $_SESSION['installer']->step) {
                echo "ready'>";
            } elseif ($i == $_SESSION['installer']->step) {
                echo "current'>";
            } else {
                echo "wait'>";
            }
            echo $step['headline'] . "</li>";
            $i++;
        }
        ?>
    </ol>
    <!--
    <ul class="nav justify-content-center">
        <li><a href="./?progress=0" class="nav-link px-2 link-dark">Willkommen</a></li>
        <li><a href="./?progress=1" class="nav-link px-2 link-dark">Datenbank</a></li>
        <li><a href="./?progress=2" class="nav-link px-2 link-dark">Einstellungen</a></li>
        <li><a href="./?progress=3" class="nav-link px-2 link-dark">Abschluss</a></li>
    </ul>
    -->
</header>
