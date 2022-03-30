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