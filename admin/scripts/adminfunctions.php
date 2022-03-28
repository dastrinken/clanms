<?php
    /* Einbinden aller Funktionen aus anderen Admin-Bereichen */
    require_once(__DIR__."/../../system/db_functions.php");
    require_once(__DIR__."/../../system/helper_functions.php");
    require_once(__DIR__."/../../system/account/account_functions.php");
    require_once(__DIR__."/../../parsedown/parsedown.php");
    // optionale Funktionen
    include_once(__DIR__."/../events/events_functions.php");
    include_once(__DIR__."/../newsblog/newsblog_functions.php");
    include_once(__DIR__."/../user/user_functions.php");
    include_once(__DIR__."/../gallery/gallery_functions.php");
    include_once(__DIR__."/../groups/groups_functions.php");

    /* Newsblog */
    if($_POST['saveArticle']) {
        writeArticleToDB($_POST['updateArticle']);
    } 
    if($_GET['deleteArticle'] === 'true') {
        deleteArticleFromDB($_GET['articleId']);
    }

    /* Events */
    if($_POST['saveEvent']) {
        writeEventToDB($_POST['updateEvent']);
    } 
    if($_GET['deleteEvent'] === 'true') {
        deleteEventFromDB($_GET['eventId']);
    }

    /* Benutzerverwaltung */
    if($_POST['createUser']) {
        createNewUser();
    }
    if($_POST['deleteUserOverview'] === 'true') {
        deleteUserFromDB($_POST['userId']);
    }
    if($_POST['updateUser'] === 'true'){
        writeUsersToDB();
    }

    /*Gallery */
    if($_POST['saveGallery']) {
        writeGalleryToDB($_POST['updateGallery']);
    }
    if($_GET['deleteGallery'] === 'true') {
        deleteGalleryFromDB($_GET['galleryId']);
    }
?>