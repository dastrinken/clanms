<form action='./?nav=profile' method='post' enctype='multipart/form-data'>
    <div class="mb-3">
        <label for="mailaenderung" class="form-label">Email-Adresse ändern:</label>
        <input type="email" class="form-control" id="mailaenderung" placeholder="name@example.com">
    </div>
    <div class="mb-3">
        <input name="changeMail" type="submit" value="Ändern"/>
    </div>
    <div class="mb-3">
        <label for="passwortaenderung" class="form-label">Passwort ändern:</label>
        <input type="password" class="form-control" id="passwortaenderung" placeholder="Passwort">
    </div>
    <div class="mb-3">
        <input name="changePW" type="submit" value="Ändern"/>
    </div>
    <div class="mb-3">
        <input name="deleteAccount" type="submit" value="Account Löschen" onclick="alert();" />
    </div>
</form>

    <button name="deleteAccount" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Öffne Modal</button>



    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog text-dark">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login to your account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="loginSignupModalBody" class="modal-body">
                <!-- Login / Register form -->
                Testinhalt
            </div>
            </div>
        </div>
    </div>