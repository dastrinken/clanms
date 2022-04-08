<?php
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../../system/db_functions.php");
    require_once(__DIR__."/../../admin/scripts/rights_system.php");
    require_once(__DIR__."/../../parsedown/parsedown.php");
    require_once(__DIR__."/../../system/account/account_functions.php");

function getGalleriesFromDB() {
    if (session_status() === PHP_SESSION_NONE){session_start();}
    $mysqli = connect_DB();
    $query = "SELECT * FROM clanms_galleries;";
    $select = $mysqli->query($query);
    if($select->num_rows == NULL) {
        echo "<p>Keine Gallerie vorhanden.</p>";
    } else {
        while($row = $select->fetch_assoc()) {
            $card = '<div class="col m-2">
                        <form>
                            <div class="card border-black shadow-sm rounded p-1 bg-dark" style="width: 18rem;">

                                <img class="card-img-top" src="./admin'.$row['path_thumbnail'].'" alt="'.$row['title'].'">
                                <div class="card-body bg-lightdark rounded-bottom">
                                <h5 class="card-title">'.$row['title'].'</h5>
                                <p class="card-text">'.$row['description'].'</p>

                                <input type="hidden" name="galleryId" value="'.$row['id'].'">
                                <input type="hidden" name="galleryTitle" value="'.$row['title'].'">
                                <input type="hidden" name="galleryDescription" value="'.$row['description'].'">
                                <input type="hidden" name="galleryThumbnail" value="'.$row['path_thumbnail'].'">

                                <button name="openGallery" value="true" class="btn btn-primary submit" >Öffnen</button>
                                </div>
                            </div>
                        </form>
                    </div>';
            echo $card;
        }
        $select->close();
    }
    $mysqli->close();
}

?>