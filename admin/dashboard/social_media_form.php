<div class="row d-flex flex-column">
    <div class="col d-flex my-1">
        <h5>Social Media</h5>
    </div>
    <div class="col">
        <p>Hier kannst du auswählen, welche Social-Media Kanäle du nutzt und als Verlinkung anzeigen lassen möchtest...</p>
    </div>
    <div class="col d-flex flex-column">
        <?php
        $select = "SELECT * FROM clanms_social_media WHERE 1=1;";
        $query = $mysqli->query($select);
        while($row = $query->fetch_assoc()) {
            $checked = $row["display"] == true ? 'checked' : '';
            echo '<form class="d-flex flex-column">
                    <div class="mb-3 d-flex align-content-start align-items-center border">
                        <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="form-check-label me-3" for="flexCheckDefault">
                                <abbr title="'.$row["title"].'"><i class="'.$row["icon"].' fs-2"></i></abbr>
                            </label>
                            <input class="form-check me-3" type="text" name="'.lcfirst($row["title"]).'" placeholder="'.$row["url"].'">
                            <input class="form-check-input ms-3" type="checkbox" value="" id="flexCheckDefault" '.$checked.'>
                        </div>
                    </div>
                </form>';
        }
        ?>
    </div>
    <div class="col">
        <p>TODO: JavaScript funktionalität: Änderung soll direkt beim eintippen oder checkbox auswählen erfolgen (ohne "senden"-Button), Formular um neue Kanäle hinzuzufügen...</p>
    </div>
    <hr />
</div>