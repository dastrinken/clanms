<?php
require_once(__DIR__ . "/../scripts/adminfunctions.php");
$groupOption = getUserGroups();
?>

<form action="./dashboard.php" method="post">
    <div class="d-flex mb-3">
        <div class="input-group me-2">
            <span class="input-group-text" id="ariaLabelUsername">Nutzername</span>
            <input id="createUsername" class="form-control" type="text" aria-describedby="ariaLabelUsername" name="userName" placeholder="Bitte Nutzername eingeben">
        </div>
    </div>
    <div class="d-flex mb-3">
        <div class="input-group me-2">
            <span class="input-group-text" id="ariaLabelUsermail">E-Mail</span>
            <input id="createEmail" class="form-control" type="text" aria-describedby="ariaLabelUsermail" name="userMail" placeholder="Bitte Emailadresse eingeben">
        </div>
    </div>
    <div class="d-flex mb-3">
        <div class="input-group me-2">
            <span class="input-group-text" id="ariaLabelPassword">Passwort</span>
            <input id="createPassword" class="form-control" type="password" aria-describedby="ariaLabelPassword" name="userPassword" placeholder="Bitte Passwort eingeben">
        </div>
    </div>
    <div class="d-flex mb-3">
        <div class="input-group me-2">
            <span class="input-group-text" id="ariaLabelPasswordVerify">Passwort wiederholen</span>
            <input id="createPasswordVerify" class="form-control" type="password" aria-describedby="ariaLabelPasswordVerify" name="userPasswordVerify" placeholder="Bitte Passwort wiederholen">
        </div>
    </div>
    <div class="d-flex mb-3">
        <select name="userGroup" class="form-select me-2" aria-label="select User Group">
            <option selected>Nutzergruppe</option>
            <?php
                foreach($groupOption as $row){
                    printf("<option value='%s'>%s</option>",$row['groupId'],$row['title']);
                }
            ?>
        </select>
    </div>
    <div class="d-flex mb-3">
        <input class="form-check-input align-items-center" type="checkbox" id="activated" name="activated">
        <label for="activated">Aktiviert</label>
    </div>
    <div class="d-flex mb-3">
        <button id="createUser" class="form-control submit w-25" name="createUser" value="save">Erstellen</button>
    </div>
</form>