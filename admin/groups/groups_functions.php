<?php
    require_once(__DIR__ . "/../scripts/adminfunctions.php");
    if (session_status() === PHP_SESSION_NONE){session_start();}

    if($_POST['command'] === "saveGroupRights") {
        saveGroupRights($_POST['id']);
    }

    function getGroupsFromDB(){
        $mysqli = connect_DB();
        $select = "SELECT id FROM clanms_groups cg";
        $result = $mysqli->query($select, MYSQLI_USE_RESULT);
        $return = array();
        while($row = $result->fetch_assoc()) {
            $return[] = $row['id'];
        }
        $result->close();
        $mysqli->close();
        return $return;
    }

    function showRightsTable($groupId) {
        $mysqli = connect_DB();
        $select = "SELECT cr.id AS rightId, 
                    cr.title AS rightTitle, 
                    cghr.value AS rightValue, 
                    cg.id AS groupId, 
                    cg.title AS groupTitle, 
                    cg.description AS groupDesc 
                    FROM clanms_group_has_rights AS cghr
                    LEFT JOIN clanms_rights AS cr ON cghr.id_right = cr.id
                    LEFT JOIN clanms_groups AS cg ON cghr.id_group = cg.id
                    WHERE cg.id = ".$groupId.";";
        $result = $mysqli->query($select);
        $table = "<div class='table'>
                        <div class='thead'>
                            <div class='tr'>
                                <span class='td border-bottom border-end text-center'>#</span>
                                <span class='td border-bottom border-end'>Bereich</span>
                                <span class='td border-bottom'>Eigene verwalten</span>
                                <span class='td border-bottom'>Alle verwalten</span>
                            </div>
                        </div>
                        <div class='tbody'>";
        while($row = $result->fetch_assoc()) {
            $table .= "<div class='tr activeTable'>
                        <span class='td border-end text-center'>".$row['rightId']."</span>
                        <span class='td border-end'>".$row['rightTitle']."</span>";
            $checkedOwn = $row['rightValue'] >= 25 ? "checked" : "";
            $checkedAll = $row['rightValue'] >= 75 ? "checked" : "";            
            if($row['groupId'] === '1' && $row['groupTitle'] === 'Admin'){
                $disabled = " disabled";
            } else {
                $disabled = "";
            }
            
            $table .= "<span class='td border-end'><div class='form-check'><input id='".$row['groupId']."_".$row['rightId']."_25' class='form-check-input' type='checkbox' ".$checkedOwn.$disabled."></div></span>";
            //some rights only have on value
            if($row['rightId'] != 6) {
                $table .= "<span class='td'><div class='form-check'><input id='".$row['groupId']."_".$row['rightId']."_75' class='form-check-input' type='checkbox' ".$checkedAll.$disabled."></div></span>";
            } else {
                $table .= "<span class='td'></span>";
            }
            
            $table .= "</div>";
        }
        $table .= "</div>
                </div>";
        $result->close();
        $mysqli->close();
        echo $table;
    }

    function saveGroupRights($id) {
        $explodeId = explode("_", $id);
        $groupId = $explodeId[0];
        $rightId = $explodeId[1];
        $wantedValue = $explodeId[2];
        $checked = $_POST['active'];

        $select = "SELECT * 
                    FROM clanms_group_has_rights AS cghr 
                    WHERE id_group = $groupId 
                    AND id_right = $rightId";
        $mysqli = connect_DB();
        $result = $mysqli->query($select);
        while($row = $result->fetch_assoc()) {
            $idDB = $row['id'];
            $oldValue = $row['value'];
            switch($checked) {
                case "true":
                    $newvalue = $row['value'] > $wantedValue ? $row['value'] : $wantedValue;
                    break;
                case "false":
                    $newvalue = $row['value'] < $wantedValue ? $row['value'] : ($wantedValue - 25);
                    break;
            }
        }
        $result->close();

        $update = "UPDATE clanms_group_has_rights SET value = ? WHERE id = ?";
        $stmt = $mysqli->prepare($update);
        $stmt->bind_param("ii", $newvalue, $idDB);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
        // DEBUG: echo "groupId: ".$groupId." - rightId: ".$rightId." - (checkbox)value: ".$value." - checked: ".$checked." - Old Value: ".$oldValue." - New Value: ".$newvalue;
    }
    /* TODO: Beim Eintragen einer neuen Gruppe müssen alle Werte mit eingetragen werden (auf 0 gesetzt).
    
    Newsblog -> 25 = Eigene News erstellen, 50 = Alle News verwalten dürfen, 75 = alle Newsbeiträge verwalten | 100
    
        1 newsblog

        1 1 50

        value(recht) > 50 ? bearbeiten : nicht bearbeiten;
    
        JOIN clanms_group_has_rights cghr ON cg.id = cghr.id_group 
        JOIN clanms_rights cr ON cghr.id_right = cr.id"
        */
?>