<?php

/* Variablen aus DB auslesen */
$title = getSetting("title");

/* Entscheiden was zu tun ist bevor die Seite lädt */
if($_POST['registerBtn']){
    registerNewAccount();
} elseif($_POST['loginBtn']) {
    loginAccount();
}

/* Settings aus DB auslesen */
function getSetting($property) {
    global $dbpre;
    $mysqli = connect_DB();
    $query = "SELECT value FROM ".$dbpre."settings WHERE  
    property = '".$property."';";
    $result = $mysqli->query($query);
    while($row = $result->fetch_row()) {
        return $row[0];
    }
    $mysqli->close();
}

function selectOneRow_DB($column, $tablename, $condition, $value) {
    global $dbpre;
    $mysqli = connect_DB();

    $column = mysqli_escape_string($mysqli, $column);
    $tablename = mysqli_escape_string($mysqli, $tablename);
    $condition = mysqli_escape_string($mysqli, $condition);
    $value = mysqli_escape_string($mysqli, $value);
    
    $query = "SELECT $column FROM ".$dbpre."$tablename WHERE $condition=$value";
    $select = $mysqli->query($query);
    while($row = $select->fetch_row()) {
        return $row[0];
    }
    $mysqli->close();
}

/* Login und Registrieren 
 1. Vergleich username mit datenbank 
 2. passwort Verifikation  -> verifypassword($getpass === $hash)
 3. $_Session updaten ? 
*/
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
                    echo "Login erfolgreich! ID=$id | username=$username";
                } else {
                    echo "Bitte aktiviere erst deinen Account!"; //Anbieten Email erneut zu schicken falls nicht angekommen?
                }
            } else {
                echo "Falsches Passwort!";
            }
        } else {
            echo "Bitte ein Passwort eingeben!";
        }
    } else {
        echo "Bitte Email eingeben.";
    }
}

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
                                    var_dump($message);
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
echo $errormsg; //TODO: display errormsg in own window or as part of the site, not just a printed string
}


/* Hilfsfunktionen */
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

?>