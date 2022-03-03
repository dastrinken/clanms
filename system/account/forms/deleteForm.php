<form action='?nav=profile&tab=accountTab' method='post' enctype='multipart/form-data'>
    <div class="mb-3">
        <label for="password" class="form-label">Passwort</label>
        <input type="text" class="form-control" id="password" value="" placeholder="Geben sie ihr Passwort ein" name="passwordDelete">
    </div>
    <div class="mb-3">
        <p><strong>ACHTUNG!</strong> Mit diesem Schritt wird ihr Account und sämtliche zugehörige Daten <strong><u>unwiderruflich</u></strong> gelöscht. Sind sie sich wirklich sicher?</p>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="checkDelete" name="checkDelete">
        <label class="form-check-label" for="checkDelete">
            Ich bin mir sicher!
        </label>
    </div>
    <div class="mb-3">
        <input type="submit" name="confirmDelete" class="btn sendbtn" value="Senden" />
    </div>
</form>