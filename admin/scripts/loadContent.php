<?php
    if($_GET['editArticle']) {
        $editing = true;
        include(__DIR__."/../newsblog/writeArticle.php");
    } else {
        echo "<h2>Willkommen zurück ".$_SESSION['username']."!</h2>";
    }
?>