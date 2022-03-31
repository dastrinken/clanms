<form action="./dashboard.php" method="post">
    <div class="d-flex mb-3">
        <div class="input-group me-2">
            <span class="input-group-text" id="ariaLabelTitle">Titel</span>
            <input id="gameTitle" class="form-control" type="text" aria-describedby="ariaLabelTitle" name="gameTitle" value="<?php echo $gameTitle; ?>" placeholder="Bitte Titel eingeben">
        </div>
    </div>
    <div class="mb-3">
        <label for="gameDesc" class="form-label">Beschreibung</label>
        <textarea class="form-control" id="gameDesc" name="gameDesc" rows="15" placeholder="Gebe eine Spielbeschreibung ein"><?php echo $gameDesc; ?></textarea>
    </div>
        <?php 
            if($editing) {
                echo '<input type="hidden" name="updateGame" value="true">';
                echo '<input type="hidden" name="gameId" value="'.$gameId.'">';
                $editing = false;
            } else {
                echo '<input type="hidden" name="updateGame" value="false">';
            }
        ?>
        <button id="saveGame" class="form-control submit w-25" name="saveGame" value="save">Speichern</button>
    </div>
</form>