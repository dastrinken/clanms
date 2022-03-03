<?php
    if($_POST['changeProfile']) {
        changeProfile();
    }

    $profile = getUserProfile();

    foreach($profile as $row) {
        $pname = $row['name'];
        $pinfo = $row['info'];
    }
?>

<div class="container">
    <div class="row bg-lightdark p-4 mb-4">
        <!-- Öffentliches Profil (was sehen andere von meinem Profil?) -->
        <div class="col"><?php echo getProfilePic(256, 1); ?></div>
        <div class="col d-flex flex-column justify-content-around">
            <div class="row">
                <h3><?php echo $pname; ?></h3>
            </div>
            <div class="row">
                <p class="lead">
                <?php echo $pinfo; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="row bg-lightdark p-4 d-flex">
        <ul class="nav nav-tabs justify-content-center border-dark">
            <li class="nav-item">
                <a class="nav-link active linktab" id="profileTab" aria-current="page" href="#" onclick="changeContent(this.id);">Profile</a>
            </li>
            <li class="nav-item">
                <button class="nav-link linktab" id="accountTab" aria-current="page" href="#" onclick="changeContent(this.id);">Account</button>
            </li>
            <li class="nav-item">
                <a class="nav-link linktab" aria-current="page" id="preferencesTab" href="#" onclick="changeContent(this.id);">Preferences</a>
            </li>
            <li class="nav-item">
                <a class="nav-link linktab disabled" aria-current="page" id="" href="#">Placeholder</a>
            </li>
        </ul>
    </div>
    <div class="row bg-lightdark p-4">
        <div id="settingsForm" class="column"></div>
    </div>
</div>

<script>
document.onload = changeContent("profileTab");

function changeContent(id) {
    var xhttp = new XMLHttpRequest();
    var tabs = document.getElementsByClassName("linktab");

    for (let i = 0; i<tabs.length; i++){
        if (tabs[i].classList.contains("active")){
            tabs[i].classList.remove("active");
        }
    }
    
    var settingsForm = document.getElementById("settingsForm");
    xhttp.onload = function() {
        settingsForm.innerHTML = this.responseText;
    }

    if(id == "profileTab"){
        xhttp.open("GET", "./system/account/profile.php");
    } else if(id == "accountTab"){
        xhttp.open("GET", "./system/account/account.php");
    } else if(id == "preferencesTab"){
        xhttp.open("GET", "./system/account/settings.php");
    }
    document.getElementById(id).classList.add("active");

    xhttp.send();
}


function changeModalContent(id) {
        var xhttp = new XMLHttpRequest();
        var accountModalBody = document.getElementById("accountModalBody");
        var accountModalLabel = document.getElementById("accountModalLabel");
        console.log(xhttp, accountModalBody, accountModalLabel);
        xhttp.onload = function() {
            accountModalBody.innerHTML = this.responseText;
        }

        if(id == "deleteAccount"){
            xhttp.open("GET", "./system/account/forms/deleteForm.php");
            accountModalLabel.innerHTML = "Account löschen";
        } else if(id == "changeEmail"){
            xhttp.open("GET", "./system/account/forms/emailForm.php");
            accountModalLabel.innerHTML = "Email ändern";
        } else if(id == "changePassword"){
            xhttp.open("GET", "./system/account/forms/passwordForm.php");
            accountModalLabel.innerHTML = "Passwort ändern";
        }

        xhttp.send();
    }

</script>