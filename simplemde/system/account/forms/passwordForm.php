<form action='?nav=profile&tab=accountTab' method='post'>
    <div class="mb-3">
        <label for="oldPassInput" class="form-label">Altes Passwort</label>
        <input id='oldPassInput' type='password' name='oldPass' class="form-control" placeholder="Bitte geben sie ihr bisheriges Passwort ein!" />
    </div>
    <div class="mb-3">
        <label for="newPasswordInput" class="form-label">Neues Passwort</label>
        <input type="password" class="form-control" id="newPass" value="" placeholder="Geben sie ihr neues Passwort ein" name="newPass">
    </div>
    <div class="mb-3">
        <label for="newPasswordRetype" class="form-label">Passwort wdh.</label>
        <input type="password" class="form-control" id="newPassRe" value="" placeholder="Geben sie ihr neues Passwort erneut ein" name="newPassRe">
    </div>
    <div class="mb-3">
        <input type="submit" name="confirmPass" class="btn sendbtn" value="Senden" />
    </div>
</form>
