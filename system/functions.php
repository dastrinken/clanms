<?php

/* Variablen aus DB auslesen */
$title = getSetting("title");

/* Entscheiden was zu tun ist bevor die Seite lädt */
if($_POST['registerBtn']){
    registerNewAccount();
} elseif($_POST['loginBtn']) {
    loginAccount();
}
/* Daten aus DB auslesen */

/* Settings aus DB auslesen */
function getSetting($property) {
    global $dbpre;
    $mysqli = connect_DB();
    $query = "SELECT value FROM ".$dbpre."settings WHERE  
    property = '".$property."';";
    $result = $mysqli->query($query);
    while($row = $result->fetch_row()) {
        $setting = $row[0];
    }
    $mysqli->close();
    return $setting;
}

//GruppenID des Nutzers auslesen
function getUserGroup($userid) {
    global $dbpre;
    $mysqli = connect_DB();
    $query = "SELECT id_group FROM ".$dbpre."user_groups WHERE id_user=$userid";
    $select = $mysqli->query($query);
    while($row = $select->fetch_row()) {
        return $row[0];
    }
    $select->close();
    $mysqli->close();
}

/* Login und Registrieren */
function loginAccount() {
    $getemail = $_POST['email'];
    $getpass = $_POST['password'];
    if($getemail) {
        if($getpass) {
            $mysqli = connect_DB();
            $stmt = $mysqli->prepare("SELECT id, username, password, activated FROM clanms_user WHERE email=?");
            $stmt->bind_param("s", $getemail);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $username = $row['username'];
            $password = $row['password'];
            $activated = $row['activated'];
            $stmt->close();
            $mysqli->close();

            if(password_verify($getpass, $password)){
                if($activated === 1) {
                    $_SESSION['userid'] = $id;
                    $_SESSION['username'] = $username; 
                    //Eventuell neue Tabellenspalte "lastvisited" anlegen und an dieser Stelle Timestamp setzen für Nutzungsstatistiken?
                    showToastMessage("Login erfolgreich");
                } else {
                    showToastMessage("Bitte aktiviere erst deinen Account!"); //Anbieten Email erneut zu schicken falls nicht angekommen?
                }
            } else {
                showToastMessage("Falsches Passwort!");
            }
        } else {
            showToastMessage("Bitte ein Passwort eingeben!");
        }
    } else {
        showToastMessage("Bitte Email eingeben.");
    }
}

/*
**  registerNewAccount is performed once when registering as a new user
**  there are different parts of this function:
**      1. register new user into database
**      2. insert user into standard user group
**      3. create new user_profile with standard avatar
**      4. send activation email
**
**      TODO: create procedure or trigger to automatically detect and delete unused user profiles
*/
function registerNewAccount() {
    // TODO: Mögliche Sicherheitslücke: Variablen aus POST Escapen oder prepared stmt nutzen!
    global $dbpre;
    global $title;
    $getuser = $_POST['username'];
    $getemail = $_POST['email'];
    $getpass = $_POST['password'];
    $getpassretype = $_POST['passwordRetype'];

    if($getuser) {
        if($getemail && filter_var($getemail, FILTER_VALIDATE_EMAIL)) {
            if($getpass) {
                if($getpassretype) {
                    if($getpass === $getpassretype) {
                        $mysqli = connect_DB();

                        $getuser = mysqli_escape_string($mysqli, $getuser);
                        $getemail = mysqli_escape_string($mysqli, $getemail);
                        $getpass = mysqli_escape_string($mysqli, $getpass);
                        $getpassretype = mysqli_escape_string($mysqli, $getpassretype);

                        $result = $mysqli->query("SELECT id FROM ".$dbpre."user WHERE username='$getuser'");
                        $rowcount = $result->num_rows;
                        $result->close();
                        if($rowcount == 0) {
                            $result = $mysqli->query("SELECT id FROM ".$dbpre."user WHERE email='$getemail'");
                            $rowcount = $result->num_rows;
                            $result->close();
                            if($rowcount == 0){
                                $password = password_hash($getpass, PASSWORD_DEFAULT);
                                $date = date("Y-m-d");
                                $code = md5(rand());
                                $activated = 0;
                                
                                $stmt = $mysqli->prepare("INSERT INTO `clanms_user` (`username`, `password`, `email`, `registeredSince`, `activated`, `activationCode`) VALUES (?,?,?,?,?,?)");
                                $stmt->bind_param("ssssis", $getuser, $password, $getemail, $date, $activated, $code);
                                $stmt->execute();
                                $stmt->close();
                                $result = $mysqli->query("SELECT id FROM ".$dbpre."user WHERE username='$getuser'");
                                $rowcount = $result->num_rows;
                                while($row = $result->fetch_row()) {
                                    $id = $row[0];
                                }
                                $result->close();
                                if($rowcount == 1) {
                                    /* Setze Rechte für neu erstelltes Benutzerprofil */
                                    $usergroup = 4;
                                    $comment = $getuser." - new User";
                                    $stmt = $mysqli->prepare("INSERT INTO clanms_user_groups (id_user, id_group, comment) VALUES (?,?,?)");
                                    $stmt->bind_param("iis", $id, $usergroup, $comment);
                                    $stmt->execute();
                                    $stmt->close();
                                    /* Erstelle Benutzerprofil in der Datenbank */
                                    $avatar = file_get_contents(__DIR__."/../ressources/images/standard_avatar.jpg");
                                    $info = "Willkommen auf meinem öffentlichen Profil!";
                                    $stmt = $mysqli->prepare("INSERT INTO clanms_user_profile (id_user, name, avatar, info) VALUES (?,?,?,?)");
                                    $stmt->bind_param("isss", $id, $getuser, $avatar, $info);
                                    $stmt->execute();
                                    $stmt->close();
                                    /* Verschicke bestätigungsemail */
                                    // TODO: Schönere Email formulieren
                                    $site = $_SERVER['SERVER_NAME']."/clanms/index.php"; // TODO: !clanms (Ordner) aus URL entfernen vor dem Release! url aus Datenbank auslesen?
                                    $webmaster = getSetting("email"); //TODO: Set up webmaster email during installation process!
                                    $header[] = 'MIME-Version: 1.0';
                                    $header[] = 'Content-type: text/html; charset=iso-8859-1';
                                    $header[] = "To: $getuser <$getemail>";
                                    $header[] = "From: $webmaster";
                                    $subject = "Deine Registrierung bei $title"; //Titel & Message sollen später vom Seitenbetreiber selbst über Adminpanel festgelegt werden können.
                                    $message = "Hallo $getuser!<br/>Du hast dich soeben erfolgreich bei $title registriert.<br/>"; 
                                    $message .= "<a href=\"$site?id=$id&code=$code\">Um deine Registrierung abzuschließen, klicke bitte auf diesen Link</a>";
                                    //var_dump Ausgabe der Email zum Testen, vor Release entfernen:
                                    showToastMessage($message);
                                    if(mail($getemail, $subject, $message, implode("\r\n", $header))) {
                                        $errormsg = "Registrierung erfolgreich, es wurde eine Email mit Aktivierungslink an die angegebene Adresse verschickt";
                                        $errormsg .= "<br>webmaster mail: $webmaster";
                                        $errormsg .= "<br>header: $header";
                                        $errormsg .= "<br>subject: $subject";
                                        $errormsg .= "<br>message: $message";
                                        /* important: empty user and email variable (don't change this!) */
                                        $getuser = "";
                                        $getemail = "";
                                    } else {
                                        $errormsg = "Email konnte nicht verschickt werden. Bitte kontaktiere den Administrator. $webmaster";
                                    }
                                } else {
                                    $errormsg = "Es ist ein Fehler aufgetreten, dein Account wurde nicht registriert";
                                }
                            }
                            else{
                                $errormsg = "Diese Emailadresse ist bereits vergeben";
                            }
                        } else {
                            $errormsg = "Der Benutzername existiert bereits, bitte wählen sie einen anderen";
                        }
                        $mysqli->close();
                    } else {
                        $errormsg = "Die beiden Passwörter stimmen nicht überein";
                    }
                } else {
                    $errormsg = "Bitte bestätige dein Passwort.";
                }
            } else {
                $errormsg = "Bitte geben Sie ein Passwort ein";
            }
        } else {
            $errormsg = "Bitte geben sie eine gültige Emailadresse ein!";
        }
    }
    else {
        $errormsg = "Bitte geben sie einen Benutzernamen ein";
    }
showToastMessage($errormsg);
}

function deleteAccount($userid) {
    $getpass = $_POST['passwordDelete'];
    $password = selectOneRow_DB("password", "clanms_user", "id", $userid);
    if(password_verify($getpass, $password)) {
        $mysqli = connect_DB();
        $delete = "DELETE FROM clanms_user_groups WHERE id_user=$userid;
                    DELETE FROM clanms_user_profile WHERE id_user=$userid;
                    DELETE FROM clanms_user WHERE id=$userid;";
        if($mysqli->multi_query($delete)) {
            $errormsg = "success! everything is deleted";
        } else {
            $errormsg =  "error! data could not be deleted";
        }
        $mysqli->close();
    }
    showToastMessage($errormsg);
}

function emailChange($userid){
    $getpass = $_POST['passwordEmail'];
    $getemail = $_POST['newEmail'];
    $password = selectOneRow_DB("password", "clanms_user", "id", $userid);
    if(password_verify($getpass, $password)) {
        $mysqli = connect_DB();
        $changemail = $mysqli->prepare("UPDATE clanms_user SET email=? WHERE id=?");
        $changemail->bind_param("si", $getemail, $userid);
        if($changemail->execute()){
            echo("Email wurde erfolgreich geändert!");
        }else{
            echo("Emailänderung fehlgeschlagen!");
        }
        $changemail->close();
        $mysqli->close();
    }
}

function passwordChange($userid){
    $getpass = $_POST['oldPass'];
    $getnewpass = $_POST['newPass'];
    $getnewpassre = $_POST['newPassRe'];
    $password = selectOneRow_DB("password", "clanms_user", "id", $userid);
    if(password_verify($getpass, $password)) {
        if($getnewpass === $getnewpassre){
            $newpass = password_hash($getnewpass, PASSWORD_DEFAULT);
            $mysqli = connect_DB();
            $changepass = $mysqli->prepare("UPDATE clanms_user SET password=? WHERE id=?");
            $changepass->bind_param("si", $newpass, $userid);
            if($changepass->execute()){
                echo("Passwort wurde erfolgreich geändert!");
            }else{
                echo("Passwortänderung fehlgeschlagen!");
            }
            $changepass->close();
            $mysqli->close();
        }else{
            echo "Passwörter stimmen nicht überein!";
        }
    
    }
}

function getUserProfile() {
    $userid = $_SESSION['userid'];
    $mysqli = connect_DB();
    $select = $mysqli->prepare("SELECT * FROM clanms_user_profile WHERE id_user=?");
    $select->bind_param("i", $userid);
    $select->execute();
    $result = $select->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data;
}

function getProfilePic($size, $rounded) {
    $userid = $_SESSION['userid'];
    $mysqli = connect_DB();
    $select = $mysqli->prepare("SELECT avatar FROM clanms_user_profile WHERE id_user=?");
    $select->bind_param("i", $userid);
    $select->execute();
    $result = $select->get_result();
    $data = $result->fetch_assoc();
    foreach($data as $value) {
        $content = base64_encode($value);
    }
    if($rounded == 0) {
        $image = '<img src="data:image/png;base64,'.$content.'" width = "'.$size.'px" height= "'.$size.'px" />';
    } elseif($rounded == 1) {
        $image = '<img src="data:image/png;base64,'.$content.'" width = "'.$size.'px" height="'.$size.'px" class="rounded-circle" />';
    }
    return $image;
}

/* Profilseite */
function changeProfile() {
    if(empty($_POST['pname'])) {
        $pname = selectOneRow_DB("name", "clanms_user_profile", "id_user", $_SESSION['userid']);
    } else {
        $pname = $_POST['pname'];
    }
    if(empty($_POST['pinfo'])){
        $pinfo = selectOneRow_DB("info", "clanms_user_profile", "id_user", $_SESSION['userid']);
    } else {
        $pinfo = $_POST['pinfo'];
    }
    if(empty($_FILES['ppic']['tmp_name'])) {
        $ppic = selectOneRow_DB("avatar", "clanms_user_profile", "id_user", $_SESSION['userid']);
    } else {
        $ppic = file_get_contents($_FILES['ppic']['tmp_name']);
    }

    $mysqli = connect_DB();
    $update = "UPDATE clanms_user_profile SET name=?, avatar=?, info=? WHERE id_user=?";
    $stmt = $mysqli->prepare($update);
    if($stmt->bind_param("sssi", $pname, $ppic, $pinfo, $_SESSION['userid'])) {
        debug_to_console("Hat geklappt!");
    } else {
        debug_to_console($stmt);
    }

    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

/* Calendar und alles Zugehörige */
function getClosestEventId() {
    $mysqli = connect_DB();
    $select = "SELECT id, MIN(DATEDIFF(start, NOW())) AS diff FROM clanms_event WHERE start > NOW() GROUP BY id ORDER BY diff ASC LIMIT 1;";
    $result = $mysqli->query($select);
    while($row = $result->fetch_row()) {
        $id = $row[0];
    }
    $result->close();
    $mysqli->close();
    return $id;
}

function getEventsArray() {
    $mysqli = connect_DB();
    $select = "SELECT * FROM clanms_event";
    $result = $mysqli->query($select, MYSQLI_USE_RESULT);
    $resultArray = $result->fetch_all(MYSQLI_ASSOC);
    $result->close();
    $mysqli->close();
    return $resultArray;
}

function getSpecificEventById($id) {
    $mysqli = connect_DB();
    $select = "SELECT * FROM clanms_event WHERE id=$id";
    $result = $mysqli->query($select, MYSQLI_USE_RESULT);
    $resultArray = $result->fetch_all(MYSQLI_ASSOC);
    $result->close();
    $mysqli->close();
    return $resultArray;
}

//catId muss aus Eventarray ausgelesen werden, rounded gibt an ob Bild rund sein soll oder Eckig (true/false)
function getCategoryImage($catId, $size, $rounded) {
    $mysqli = connect_DB();
    $select = $mysqli->prepare("SELECT image FROM clanms_event_category WHERE id=?");
    $select->bind_param("i", $catId);
    $select->execute();
    $result = $select->get_result();
    $data = $result->fetch_assoc();
    foreach($data as $value) {
        $content = base64_encode($value);
    }
    if($rounded == 0) {
        $image = '<img src="data:image/png;base64,'.$content.'" width = "'.$size.'px" height= "'.$size.'px" />';
    } elseif($rounded == 1) {
        $image = '<img src="data:image/png;base64,'.$content.'" width = "'.$size.'px" height="'.$size.'px" class="rounded-circle" />';
    }
    return $image;
}

/* Newsblog anzeigen und alles was dazugehört */

function showAllNews() {
    $Parsedown = new Parsedown();
    $Parsedown->setSafeMode(true);
    $mysqli = connect_DB();
    $select = "SELECT news.headline, news.content, news.color, news.date_published, user.username FROM clanms_news AS news
    LEFT JOIN clanms_user AS user
    ON news.id_author = user.id
    WHERE DATEDIFF(news.date_published, NOW()) <= 0 
    ORDER BY news.date_published DESC;";
    $result = $mysqli->query($select);
    while($row = $result->fetch_assoc()) {
        $article_headline = $row['headline'];
        $article_content = $Parsedown->text($row['content']);
        $article_name_author = $row['username'];
        $article_date_published = $row['date_published'];
        $article_color = $row['color'];
        include(__DIR__."/../content/newsblog/articles/article_template.php");
    }
    $mysqli->close();
}

/* Allgemeine Hilfsfunktionen */

// Shows a small Popup message on the bottom right, use it to display error Messages.
function showToastMessage($stringMessage) { 
    echo '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="messageToast" class="showToast bg-blackened" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-highlighted text-dark">
                <img src="..." class="rounded me-2" alt="...">
                <strong class="me-auto">Systemnachricht</strong>
                <button type="button" class="btn-close" onclick="closeToast();" aria-label="Close"></button>
                </div>
                <div id="toastBody" class="toast-body">
                '.$stringMessage.'
                </div>
            </div>
        </div>';
}

// Debugs data to javascript console
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

//selectOneRow_DB: use if you expect exactly one result (row). For example looking up a user id (or any other id)
function selectOneRow_DB($column, $tablename, $condition, $value) {
    $mysqli = connect_DB();

    $column = mysqli_escape_string($mysqli, $column);
    $tablename = mysqli_escape_string($mysqli, $tablename);
    $condition = mysqli_escape_string($mysqli, $condition);
    $value = mysqli_escape_string($mysqli, $value);
    
    $query = "SELECT $column FROM $tablename WHERE $condition=$value";
    $select = $mysqli->query($query);
    while($row = $select->fetch_row()) {
        $return = $row[0];
    }
    $select->close();
    $mysqli->close();
    return $return;
}
?>