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
</header>
