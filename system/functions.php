<?php
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

/* Login und Registrieren */
function registerNewAccount() {
    global $title;
    $getuser = $_POST['username'];
    $getemail = $_POST['email'];
    $getpass = $_POST['password'];
    $getpassretype = $_POST['passwordRetype'];

    /*
        - variablen in denen registrierdaten gespeichert werden
        - überprüfen ob die beiden passwörter übereinstimmen
        - wenn alles stimmt, dann in sql statement verpacken und datensatz in db einfügen (INSERT)
        - verifikations email verschicken
        - Fehlermeldungen für jeden Schritt
    */

    if($getuser) {
        if($getemail && filter_var($getemail, FILTER_VALIDATE_EMAIL)) {
            if($getpass) {
                if($getpassretype) {
                    if($getpass === $getpassretype) {
                        $mysqli = connect_DB();
                        $result = $mysqli->query("SELECT id FROM clanms_user WHERE username='$getuser'");
                        $rowcount = $result->num_rows;
                        $result->close();
                        if($rowcount == 0) {
                            $result = $mysqli->query("SELECT id FROM clanms_user WHERE email='$getemail'");
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
                                $result = $mysqli->query("SELECT id FROM clanms_user WHERE username='$getuser'");
                                $rowcount = $result->num_rows;
                                $result->close();
                                // $link =  http_build_url();
                                if($rowcount == 1) {
                                    /* Verschicke bestätigungsemail */
                                    // TODO: Schönere Email formulieren
                                    $site = $_SERVER['SERVER_NAME']."/clanms/system/login/activation.php"; // TODO: !clanms (Ordner) aus URL entfernen vor dem Release! url aus Datenbank auslesen?
                                    $webmaster = ""; //TODO: email des Seitenbetreibers aus Datenbank auslesen
                                    $header[] = 'MIME-Version: 1.0';
                                    $header[] = 'Content-type: text/html; charset=iso-8859-1';
                                    $header[] = "To: $getuser <$getemail>";
                                    $header[] = "From: $webmaster";
                                    $subject = "Deine Registrierung bei $title"; //Titel & Message sollen später vom Seitenbetreiber selbst über Adminpanel festgelegt werden können.
                                    $message = "Hallo $getuser!<br/>Du hast dich soeben erfolgreich bei $title registriert.<br/>"; 
                                    $message .= "<a href=\"$site?code=$code\">Um deine Registrierung abzuschließen, klicke bitte auf diesen Link</a>";
                                    if(mail($getemail, $subject, $message, implode("\r\n", $header))) {
                                        $getuser = "";
                                        $getemail = "";
                                        $errormsg = "Registrierung erfolgreich, es wurde eine Email mit Aktivierungslink an die angegebene Adresse verschickt";
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
var_dump($errormsg);
}

/* Hilfsfunktionen */
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
?>