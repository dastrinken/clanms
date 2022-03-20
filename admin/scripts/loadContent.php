<?php
    if($_GET['editArticle'] || $_GET['editEvent']) {
        $editing = true;
        if($_GET['editArticle']) {
            include(__DIR__."/../newsblog/writeArticle.php");
        }
        if($_GET['editEvent']) {
            include(__DIR__."/../events/createEvent.php");
        }
    } else {
        include_once(__DIR__."/../landingPage.php");
    }

?>