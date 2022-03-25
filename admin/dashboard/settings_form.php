<div class="row d-flex flex-column">
    <div class="col my-3">
        <h4 class="text-center">ClanMS - Systemeinstellungen</h4>
        <hr />
    </div>
</div>
<!-- Seite -->
<div class="row d-flex flex-column">
    <div class="col d-flex my-1">
        <h5>Einstellungen Seite</h5>
    </div>
    <div class="col d-inline-flex">
        <form>
            <div class="mb-3">
                <div class="input-group">
                    <fieldset disabled class="d-flex">
                        <span class="input-group-text rounded-0 rounded-start">Titel der Seite</span>
                        <input type="text" aria-label="Last name" class="form-control rounded-0 rounded-end bg-light" value="<?php echo getSetting("title"); ?>">
                    </fieldset>
                    <button id="changeTitle" class="btn rounded"><i class="bi-pencil-square"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="col">
        <p>Weitere Ideen: Logo der Seite, Anschrift Seitenbetreiber zwecks Impressum</p>
    </div>
    <hr />
</div>
<!-- Betreiber -->
<div class="row d-flex flex-column">
    <div class="col d-flex my-1">
        <h5>Einstellungen Seitenbetreiber</h5>
    </div>
    <div class="col d-inline-flex">
        <form>
            <div class="mb-3">
                <div class="input-group">
                    <fieldset disabled class="d-flex">
                        <span class="input-group-text rounded-0 rounded-start">E-Mail Seitenbetreiber</span>
                        <input type="text" aria-label="Last name" class="form-control rounded-0 rounded-end bg-light" value="<?php echo getSetting("email"); ?>">
                    </fieldset>
                    <button id="changeEmail" class="btn rounded"><i class="bi-pencil-square"></i></button>
                </div>
            </div>
        </form>
    </div>
    <hr />
</div>