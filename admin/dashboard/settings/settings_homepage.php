<!-- Seite -->
<div class="row d-flex flex-column">
    <div class="col d-flex my-1">
        <h5>Einstellungen Seite</h5>
    </div>
    <div class="col d-inline-flex">
        <form>
            <!-- Title -->
            <div class="mb-3">
                <div class="input-group">
                    <fieldset id="titleFieldset" disabled class="d-flex">
                        <span class="input-group-text rounded-0 rounded-start">Titel der Seite</span>
                        <input id="titleInput" type="text" aria-label="Homepage Title" class="form-control rounded-0 rounded-end bg-light" value="<?php echo getSetting("title"); ?>">
                    </fieldset>
                    <button id="changeTitle" type="button" class="btn rounded ms-2"><i class="bi-pencil-square"></i></button>
                </div>
            </div>
            <!-- Landingpage text -->
            <div class="mb-3">
                <label for="welcomeText" class="form-label">Inhalt</label>
                <textarea class="form-control" id="welcomeText" name="content" rows="15" placeholder="Erstelle einen Willkommens-Text für deine Landingpage..."><?php echo getSetting("text_landingpage"); ?></textarea>
            </div>
        </form>
    </div>
    <div class="col">
        <p>Weitere Ideen: Logo der Seite, Anschrift Seitenbetreiber zwecks Impressum</p>
    </div>
    <hr />
</div>