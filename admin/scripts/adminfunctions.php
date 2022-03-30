<?php
    /* SESSION setzen, falls noch nicht geschehen */
    if (session_status() === PHP_SESSION_NONE){session_start();}
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
    include_once(__DIR__."/../game/game_functions.php");
    include_once(__DIR__."/../../content/calendar/calendar_functions.php");


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
    
    /*Game */
    if($_POST['deleteGame'] === 'true'){
        deleteGameFromDB($_POST['gameId']);
    }

    /* Eventkategorie */
    if($_POST['saveEventCat'] === 'save'){
        writeEventCatToDB($_POST['updateEventCat']);
    }


    /* Groups & Rights */
    /**
     * @param String $moduleName String representation of the modules name
     * @param bool $checkSameUser You might want to check if user is the author e.g new article and edit old article
     * @param $creatorId Optional but needed when you pass checkSameUser as true
     * @return bool user permission
     */
    function checkPermission($moduleName, $checkSameUser, ?int $creatorId = null) {
        $permission = false;
        switch($moduleName) {
            case "newsblog":
                $rightsId = 1;
                break;
            case "eventorganizer":
                $rightsId = 2;
                break;
            case "gallery":
                $rightsId = 3;
                break;
            case "accounts":
                $rightsId = 4;
                break;
            case "enrollEvents":
                $rightsId = 5;
                break;
            case "eventCategory":
                $rightsId = 6;
                break;
        }
        $rightsValue = checkUserRights($_SESSION['userid'], $rightsId);
        if($rightsValue > 0) {
            if($rightsValue >= 25 && $rightsValue < 75) {
                //25 is the minimal value, 75 means you have permission to edit all content in this area
                if($checkSameUser) {
                    $permission = checkSameUser($creatorId);
                } else {
                    $permission = true;
                }
            } else {
                $permission = true;
            }
        }
        return $permission;
    }

    function checkSameUser($creatorId) {
        if($_SESSION['userid'] == $creatorId) {
            return true;
        } else {
            return false;
        }
    }

    function checkUserRights($userId, $rightsId) {
        $mysqli = connect_DB();
        $select = "SELECT value FROM clanms_group_has_rights AS cghr
                    LEFT JOIN clanms_user_groups AS cug
                    ON cghr.id_group = cug.id_group
                    WHERE cug.id_user = $userId
                    AND cghr.id_right = $rightsId;";
        $result = $mysqli->query($select);
        while($row = $result->fetch_assoc()) {
            $rightsValue = $row['value'];
        }
        $result->close();
        $mysqli->close();
        return $rightsValue;
    }
?>