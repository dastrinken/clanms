<?php
    /* define bounding constants */
    define('VAL_MIN', 25);
    define('VAL_MOD', 50);
    define('VAL_ADM', 75);

    /**
     * @param String $moduleName String representation of the modules name
     * @param bool $checkSameUser You might want to check if user is the author e.g new article and edit old article
     * @param $creatorId Optional but needed when you pass checkSameUser as true
     * @return bool user permission
     */
    function checkPermission($moduleName, $checkSameUser, ?int $creatorId = null) {
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
            case "admindashboard":
                $rightsId = 7;
                break;
            case "manageRights":
                $rightsId = 8;
                break;
            case "game":
                $rightsId = 9;
                break;
            case "group":
                $rightsId = 10;
                break;
            case "newsblogComment":
                $rightsId = 11;
                break;
        }
        $rightsValue = checkUserRights($_SESSION['userid'], $rightsId);

        if($rightsValue < VAL_MIN) {
            return false;
        } elseif($rightsValue >= VAL_ADM) {
            return true;
        } elseif($rightsValue == VAL_MIN) {
            if($checkSameUser) {
                return checkSameUser($creatorId);
            } else {
                return true;
            }
        } else {
            return false;
        }
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