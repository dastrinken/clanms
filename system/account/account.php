<form action='./?nav=profile' method='post' enctype='multipart/form-data'>
    <div class="mb-3">
        <label for="mailaenderung" class="form-label">Email-Adresse änder:</label>
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
        <input name="deleteAccount" type="submit" value="Account Löschen"/>
    </div>
</form>