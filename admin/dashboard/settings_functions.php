<?php
    require_once(__DIR__ . "/../scripts/adminfunctions.php");
    if (session_status() === PHP_SESSION_NONE){session_start();}

    switch($_POST['command']) {
        case "changeTitle":
            $newTitle = htmlspecialchars($_POST['content']);
            updateHomepageTitle($newTitle);
            break;
        case "saveSocialMedia":
            $id = $_POST['id'];
            $checked = $_POST['active'];
            $content = htmlspecialchars($_POST['content']);
            saveSocialMedia($id, $checked, $content);
            break;
    }

    function saveSocialMedia($id, $checked, $content) {
        $checked = $checked == "true" ? 1 : 0;
        $mysqli = connect_DB();
        $update = $mysqli->prepare("UPDATE clanms_social_media SET url=?, display=? WHERE id=?");
        $update->bind_param("sii", $content, $checked, $id);
        $update->execute();
        $update->close();
        $mysqli->close();
    }

    function updateHomepageTitle($newTitle) {
        $oldTitle = getSetting("title");
        $property = "title";
        $mysqli = connect_DB();
        if($newTitle != $oldTitle && $newTitle != "") {
            $update = $mysqli->prepare("UPDATE clanms_settings SET value=? WHERE property=?");
            $update->bind_param("ss", $newTitle, $property);
            $update->execute();
            $update->close();
        }
        $mysqli->close();
    }
?>