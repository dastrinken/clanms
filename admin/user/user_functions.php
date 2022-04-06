<?php 
    //TODO: Es sollte nicht möglich sein den ursprünglichen Admin-Account zu löschen oder zu verändern (außer vllt email und passwort)!
    function deleteUserFromDB($userid){
        if (session_status() === PHP_SESSION_NONE){session_start();}
        $mysqli = connect_DB();
        $stmt1 = $mysqli->prepare("DELETE FROM clanms_user_groups WHERE clanms_user_groups.id_user = ?");
        $stmt1->bind_param("i", $userid);
        $stmt1->execute();
        $stmt1->close();
        $stmt2 = $mysqli->prepare("DELETE FROM clanms_user_profile WHERE clanms_user_profile.id_user = ?");
        $stmt2->bind_param("i",$userid);
        $stmt2->execute();
        $stmt2->close();
        $stmt3 = $mysqli->prepare("DELETE FROM clanms_user WHERE clanms_user.id = ?");
        $stmt3->bind_param("i", $userid);
        $stmt3->execute();
        $stmt3->close();
        $mysqli->close();
    }

    $totalPages;
    // TODO Anzeige der Profilbilder
    function getUsersFromDB($displayOption) {
        if (session_status() === PHP_SESSION_NONE){session_start();}
        global $totalPages;

        $displayAmount = 10;
        $page = $_GET['page'];
        $offset = ($page - 1) * $displayAmount;

        $groups = getUserGroups();
        $mysqli = connect_DB();
        
        switch($displayOption) {
            case "all":
                $where = "WHERE 1=1";
                break;
            case "admin":
                $where = "WHERE cg.title = 'Admin'";
                break;
            case "moderator":
                $where = "WHERE cg.title = 'Moderator'";
                break;
            case "member";
                $where = "WHERE cg.title = 'Member'";
                break;
            case "registered":
                $where = "WHERE cg.title = 'Registered'";
                break;
            default:
                $where = "WHERE 1=1";
                break;
        }

        $totalPagesDB = "SELECT * FROM clanms_user AS user";
        $pagesResult = $mysqli->query($totalPagesDB);
        $rowCount = $pagesResult->num_rows;
        $totalPages = ceil($rowCount / $displayAmount);
        $pagesResult->close();

        $select = "SELECT cs.id AS userid, 
                    cs.username, cs.email, 
                    cs.registeredSince, 
                    cs.activated, 
                    cg.title, 
                    cg.id AS groupId, 
                    cup.avatar AS ppic
                    FROM clanms_user cs 
                    JOIN clanms_user_groups cug ON cs.id = cug.id_user 
                    JOIN clanms_groups cg ON cug.id_group = cg.id
                    JOIN clanms_user_profile cup ON cup.id_user = cs.id 
                    ".$where."
                    LIMIT $offset, $displayAmount;";
        $result = $mysqli->query($select, MYSQLI_USE_RESULT);
        $table = "<div class='table'>
        <div class='thead'>
            <div class='tr mb-2'>
                <span class='td border-bottom border-dark'>#</span>
                <span class='td border-bottom border-dark'>Username</span>
                <span class='td border-bottom border-dark'>Profilbild</span>
                <span class='td border-bottom border-dark'>E-mail</span>
                <span class='td border-bottom border-dark'>Registriert seit</span>
                <span class='td border-bottom border-dark'>Status Aktiviert</span>
                <span class='td border-bottom border-dark'>Nutzergruppe</span>
                <span class='td border-bottom border-dark'></span>
                <span class='td border-bottom border-dark'></span>
            </div>
        </div><div class='tbody'>";
        $count = 0;
        while($row = $result->fetch_assoc()) {
            ++$count;
            $user_id = $row['userid'];
            $user_name = $row['username'];
            $user_email = $row['email'];
            $user_registeredSince = $row['registeredSince'];
            $activatedInt = $row['activated'];
            $ppic = base64_encode($row['ppic']);
            if($row['activated']==="1"){
                $user_activated = "aktiviert";
            } elseif($row['activated']==="0"){
                $user_activated = "nicht aktiviert";
            }
            $group_title = $row['title'];
            $group_id = $row['groupId'];
            $table .= '<form method="post" class="tr activeTable" >
                        <span class="td border-end border-activeTable">
                        '.(/*$offset+*/$count).'
                            <input type="hidden" name="userId" value="'.$user_id.'">
                        </span>
                        <span class="td border-end border-activeTable" name="userName">
                            '.$user_name.'
                        </span>
                        <span class="td border-end border-activeTable">
                            <img src="data:image/png;base64,'.$ppic.'" width = "64px" height= "64px" class="rounded-circle" />
                        </span>
                        <span class="td border-end border-activeTable" name="userEmail">
                            '.$user_email.'
                            <input type="hidden" name="userMail" value="'.$user_email.'">
                        </span>
                        <span class="td border-end border-activeTable" name="userRegistered">
                            '.$user_registeredSince.'
                            <input type="hidden" name="userRegisteredSince" value="'.$user_registeredSince.'">
                        </span>
            
                        <span class="td border-end border-activeTable">';
            if(checkPermission("accounts",true, $user_id)){
                $table.='            
                            <select name="activated" class="form-select border-0" aria-label="select activated status">
                            <option value="'.$activatedInt.'">'.$user_activated.'</option>';
                if($activatedInt == 0) {
                    $table .= '<option value="1">aktiviert</option>';
                } else {
                    $table .= '<option value="0">nicht aktiviert</option>';
                }
                $table .= '</select>';
            }else{
                $table .= ''.$user_activated.'';
            }              
            $table .= '</span>
                        <span class="td border-end border-activeTable">';
            if(checkPermission("accounts",true, $user_id)){
                $table.='<select name="userGroup" class="form-select border-0" aria-label="select user group">
                            <option value='.$group_id.'>'.$group_title.'</option>';
                foreach($groups as $row) {
                    if($row['groupId'] == $group_id) {
                        continue;
                    }
                    $table .="<option value=".$row['groupId'].">".$row['title']."</option>";
                }
                $table .='</select>';
                    
            }else{
                $table.=''.$group_title.'';
            }
            $table.='</span>';
            if(checkPermission("accounts",true, $user_id)){
                $table.='<span class="td border-activeTable">
                        <button name="updateUser" value="true" class="btn btn-secondary submit">Speichern</button>
                    </span>
                    <span class="td border-activeTable">
                        <button name="deleteUserOverview" type="submit" value="true" class="btn btn-danger submit" onclick="return confirm(\'Der Benutzer wird endgültig aus der Datenbank gelöscht, bist du dir sicher?\');">Löschen</button>
                    </span>';
            }
            $table.='</form>';
        }
        $table .= "</div>";
        $result->close();
        $mysqli->close();
        return $table;
    }

    function getUserGroups(){
        $mysqli = connect_DB();
        $select = "SELECT id AS groupId, title FROM clanms_groups";
        $query = $mysqli->query($select,MYSQLI_USE_RESULT);
        $resultArray = $query->fetch_all(MYSQLI_ASSOC);
        $query->close;
        $mysqli->close;
        return $resultArray;
    }

    function writeUsersToDB() {
        $userid = $_POST['userId'];
        $useractivated = $_POST['activated'];
        $usergroup = $_POST['userGroup'];
        
        $mysqli = connect_DB();
        $stmt = $mysqli->prepare("UPDATE clanms_user SET clanms_user.activated = ? WHERE clanms_user.id = ?");
        $stmt->bind_param("ii",$useractivated, $userid);
        $stmt->execute();
        $stmt->close();
        $stmt2 = $mysqli->prepare("UPDATE clanms_user_groups SET clanms_user_groups.id_group = ? WHERE clanms_user_groups.id_user = ?");
        $stmt2->bind_param("ii", $usergroup, $userid);
        $stmt2->execute();
        $stmt2->close();
        $mysqli->close();
    }

    function createNewUser(){
        $getuser = $_POST['userName'];
        $getmail = $_POST['userMail'];
        $getpass = $_POST['userPassword'];
        $getpassverify = $_POST['userPasswordVerify'];
        $getusergroup = $_POST['userGroup'];
        
        if(isset($_POST['activated'])) {
            $getActivated = 1;
        } else {
            $getActivated = 0;
        }
        
        if($getuser){
            if($getmail){
                if($getpass){
                    if($getpassverify){
                        if($getusergroup){
                            if($getpass===$getpassverify){
                                $mysqli = connect_DB();
                                $result = $mysqli->query("SELECT id FROM clanms_user WHERE username='$getuser'");
                                $rowcount = $result->num_rows;
                                $result->close();
                                if($rowcount == 0) {
                                    $result = $mysqli->query("SELECT id FROM clanms_user WHERE email='$getmail'");
                                    $rowcount = $result->num_rows;
                                    $result->close();
                                    if($rowcount == 0) {
                                        $password = password_hash($getpass, PASSWORD_DEFAULT);
                                        $date = date("y-m-d");
                                        $code = md5(rand());
                                        $stmt = $mysqli->prepare("INSERT INTO `clanms_user` (`username`, `password`, `email`, `registeredSince`, `activated`, `activationCode`) VALUES (?,?,?,?,?,?)");
                                        $stmt->bind_param("ssssis", $getuser, $password, $getmail, $date, $getActivated, $code);
                                        $stmt->execute();
                                        $stmt->close();
                                        $result = $mysqli->query("SELECT id FROM clanms_user WHERE username='$getuser'");
                                        $rowcount = $result->num_rows;
                                        while($row = $result->fetch_row()) {
                                            $id = $row[0];
                                        }
                                        $result->close();
                                        if($rowcount == 1) {
                                            /* Setze Rechte für neu erstelltes Benutzerprofil */
                                            $comment = $getuser." - new User";
                                            $stmt = $mysqli->prepare("INSERT INTO clanms_user_groups (id_user, id_group, comment) VALUES (?,?,?)");
                                            $stmt->bind_param("iis", $id, $getusergroup, $comment);
                                            $stmt->execute();
                                            $stmt->close();
                                            /* Erstelle Benutzerprofil in der Datenbank */
                                            $avatar = file_get_contents(__DIR__."/../ressources/images/standard_avatar.jpg");
                                            $info = "Willkommen auf meinem öffentlichen Profil!";
                                            $stmt = $mysqli->prepare("INSERT INTO clanms_user_profile (id_user, name, avatar, info) VALUES (?,?,?,?)");
                                            $stmt->bind_param("isss", $id, $getuser, $avatar, $info);
                                            $stmt->execute();
                                            $stmt->close();
                                        }
                                    }
                                }
                            }
                        }  
                    }
                }
            }
        }
    }
?>