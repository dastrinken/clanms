<?php
    if($_GET['editArticle']) {
        $editing = true;
        include(__DIR__."/../newsblog/writeArticle.php");
    } else {
        include(__DIR__."/../landingPage.php");
    }
?>