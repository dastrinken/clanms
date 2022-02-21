<?php
    $id = $_GET['id'];
    $code = $_GET['code'];
    $codeDB = selectOneRow_DB("activationCode", "user", "id", $id);

    if($codeDB === $code){
        $active = 1;
        $mysqli = connect_DB();
        $stmt = $mysqli->prepare("UPDATE clanms_user SET activated = ? WHERE id=?");
        $stmt->bind_param("dd", $active, $id);
        if($stmt->execute()) {
            echo "Ihr Account wurde erfolgreich aktiviert";
        } else {
            echo "Die Aktivierung ist fehlgeschlagen, bitte kontaktieren Sie den Systemadministrator";
        }
        $stmt->close();
        $mysqli->close();
    }

?>