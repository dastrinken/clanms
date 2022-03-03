<form action='./?nav=profile' method='post' enctype='multipart/form-data'>
    <div class="mb-3">
        <label for="password" class="form-label">Passwort</label>
        <input type="text" class="form-control" id="password" value="" placeholder="Geben sie ihr Passwort ein" name="password">
    </div>
    <div class="mb-3">
        <p><strong>ACHTUNG!</strong> Mit diesem Schritt wird ihr Account und sämtliche zugehörige Daten <strong><u>unwiderruflich</u></strong> gelöscht. Sind sie sich wirklich sicher?</p>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
            Ich bin mir sicher!
        </label>
    </div>
    <div class="mb-3">
        <input type="submit" class="btn sendbtn" value="Senden" />
    </div>
</form>