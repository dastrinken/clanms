<div class="row mb-4">
    <button id="changeEmail" class="btn sendbtn" data-bs-toggle="modal" data-bs-target="#accountModal" onclick="changeModalContent(this.id);">Email-Adresse ändern</button>
</div>
<div class="row mb-4">
    <button id="changePassword" class="btn sendbtn" data-bs-toggle="modal" data-bs-target="#accountModal" onclick="changeModalContent(this.id);">Passwort ändern</button>
</div>
<div class="row">
    <button id="deleteAccount" class="btn sendbtn" data-bs-toggle="modal" data-bs-target="#accountModal" onclick="changeModalContent(this.id);">Account löschen</button>
</div>



<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog text-dark">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="accountModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="accountModalBody" class="modal-body">
            <!-- Login / Register form -->
        </div>
        </div>
    </div>
</div>

<script>
    function changeModalContent(buttonId) {
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