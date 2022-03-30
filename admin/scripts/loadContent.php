<?php
    /* Load Content */
    if($_GET['editArticle'] || $_GET['editEvent'] || $_GET['editGallery'] || $_GET['editEventCat']) {
        $editing = true;
        if($_GET['editArticle']) {
            include(__DIR__."/../newsblog/writeArticle.php");
        }
        if($_GET['editEvent']) {
            include(__DIR__."/../events/createEvent.php");
        }
        if($_GET['editGallery']) {
            include(__DIR__."/../gallery/editGallery.php");
        }
        if($_GET['editEventCat']) {
            include(__DIR__."/../events/createEventCategory.php");
        }
    } else {
        include_once(__DIR__."/../dashboard/landingPage.php");
    }

    /* Gallery */
    if($_POST['uploadImage']){
        var_dump($_FILES);
        uploadImage();
        }
    
?>