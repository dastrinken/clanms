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
            $card = '<div class="col m-2" id="galleryview">
                        <form>
                            <div class="card border-black shadow-sm rounded p-1 bg-dark" style="width: 18rem;">

                                <img class="card-img-top" src="./admin'.$row['path_thumbnail'].'" alt="'.$row['title'].'">
                                <div class="card-body bg-lightdark rounded-bottom">
                                <h5 class="card-title">'.$row['title'].'</h5>
                                <p class="card-text">'.$row['description'].'</p>

                                <input type="hidden" name="galleryId" value="'.$row['id'].'">

                                <button name="openGallery" value="true" class="btn btn-primary" href=#;" >Öffnen</button>
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

function getImagesFromDB() {
    if (session_status() === PHP_SESSION_NONE){session_start();}  /* ImagesId's die der der GalleryId matchen */
    $galleryId = $_GET['galleryId'];
    $mysqli = connect_DB();
    $query = "SELECT cgi.id_image AS imageId, 
                ci.title AS imgtitle, 
                ci.description AS description, 
                ci.filename AS filename 
                FROM clanms_gallery_images AS cgi 
                LEFT JOIN clanms_images AS ci 
                ON cgi.id_image = ci.id 
                WHERE cgi.id_gallery = $galleryId";

    $select = $mysqli->query($query);
    if($select->num_rows == NULL) {
        echo "<p>Keine Bilder vorhanden.</p>";
    } else {
        while($row = $select->fetch_assoc()) {

            $carousel = '<div class="card p-0 m-2 bg-light" style=" width: 15%;">
                            <script>   
                                srclist.push("./admin/gallery/images/'.$row['filename'].'");
                            </script>
                            <img src="./admin/gallery/images/'.$row['filename'].'" class="m-1 img-thumbnail border-0" alt="'.$row['imgtitle'].'">
                        </div>';
            echo $carousel;
        }
        $select->close();
    }
    $mysqli->close();
}


?>

<script>
    function reloadImages(){

$('#galleryvie').load(document.URL +  ' #galleryview');
}

</script>