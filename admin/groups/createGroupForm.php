<form action="./dashboard.php" method="post">
    <div class="d-flex mb-3">
        <div class="input-group me-2">
            <span class="input-group-text" id="ariaLabelTitle">Titel</span>
            <input id="groupTitle" class="form-control" type="text" aria-describedby="ariaLabelTitle" name="groupTitle" placeholder="Bitte Titel eingeben">
        </div>
    </div>
    <div class="mb-3">
        <label for="groupDesc" class="form-label">Beschreibung</label>
        <textarea class="form-control" id="groupDesc" name="groupDesc" rows="15" placeholder="Gebe eine Gruppenbeschreibung ein"></textarea>
    </div>
        <button id="saveGroup" class="form-control submit w-25" name="saveGroup" value="save">Speichern</button>
    </div>
</form>