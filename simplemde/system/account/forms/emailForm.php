<form action='?nav=profile&tab=accountTab' method='post'>
    <div class="mb-3">
        <label for="emailInput" class="form-label">Neue Email-Adresse</label>
        <input id='emailInput' type='email' name='newEmail' class="form-control" placeholder="Bitte geben sie eine neue Email-Adresse ein!" />
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Passwort</label>
        <input type="password" class="form-control" id="password" value="" placeholder="Geben sie ihr Passwort ein" name="passwordEmail">
    </div>
    <div class="mb-3">
        <input type="submit" name="confirmEmail" class="btn sendbtn" value="Senden" />
    </div>
</form>
