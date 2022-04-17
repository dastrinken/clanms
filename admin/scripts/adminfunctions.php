<?php
    /* SESSION setzen, falls noch nicht geschehen */
    if (session_status() === PHP_SESSION_NONE){session_start();}
    /* Globale Konstanten einbinden */
    require_once(__DIR__."/../../system/constants.php");
    /* Einbinden aller wichtigen Systemfunktionen */
    require_once(__DIR__."/../../system/db_functions.php");
    require_once(__DIR__."/rights_system.php");
    require_once(__DIR__."/../../system/helper_functions.php");
    require_once(__DIR__."/../../system/account/account_functions.php");
    require_once(__DIR__."/../../parsedown/parsedown.php");
    // Einbinden aller Module (hier neue Zeile hinzufügen).
    include_once(__DIR__."/../events/events_functions.php");
    include_once(__DIR__."/../newsblog/newsblog_functions.php");
    include_once(__DIR__."/../user/user_functions.php");
    include_once(__DIR__."/../gallery/gallery_functions.php");
    include_once(__DIR__."/../groups/groups_functions.php");
    include_once(__DIR__."/../game/game_functions.php");
    include_once(__DIR__."/../../content/calendar/calendar_functions.php");
    include_once(__DIR__."/../../content/newsblog/newsblog_functions.php");
    

    /* Newsblog */
    if($_POST['saveArticle']) {
        writeArticleToDB($_POST['updateArticle']);
    } 
    if($_GET['deleteArticle'] === 'true') {
        deleteArticleFromDB($_GET['articleId']);
    }
    if($_POST['deleteComment'] === 'true') {
        deleteCommentFromDB($_POST['commentId']);
    }

    /* Events */
    if($_POST['saveEvent']) {
        writeEventToDB($_POST['updateEvent']);
    } 
    if($_GET['deleteEvent'] === 'true') {
        deleteEventFromDB($_GET['eventId']);
    }
    if([$_POST['deleteEnroll'] === 'true']) {
        deleteEnroll($_POST['enrollid']);
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
    
    /*Game */
    if($_POST['saveGame'] === 'save'){
        writeGameToDB($_GET['updateGame']);
    }
    if($_GET['deleteGame'] === 'true'){
        deleteGameFromDB($_GET['gameId']);
    }

    /* Eventkategorie */
    if($_POST['saveEventCat'] === 'save'){
        writeEventCatToDB($_POST['updateEventCat']);
    }

    /* Groups */
    if($_POST['saveGroup'] === 'save'){
        writeGroupToDB();
    }

?>