<?php
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../../system/db_functions.php");
    require_once(__DIR__."/../../admin/scripts/rights_system.php");
    require_once(__DIR__."/../../parsedown/parsedown.php");
    require_once(__DIR__."/../../system/account/account_functions.php");
    
    if($_GET['getImages']) {
        echo "<script>let srclist = [];</script>";
        getImagesFromDB($_GET['getImages']);
    }

function getGalleriesFromDB() {
    if (session_status() === PHP_SESSION_NONE){session_start();}
    $mysqli = connect_DB();
    $query = "SELECT * FROM clanms_galleries;";
    $select = $mysqli->query($query);
    $card = '<div class="container">
                <div class="row" id="gallery" class="gallery">';
    if($select->num_rows == NULL) {
        $card .= '<p>Keine Galerie vorhanden.</p>';
    } else {
        while($row = $select->fetch_assoc()) {
            $card .= '<div class="col m-2" id="galleryview">
                        <form>
                            <div class="card border-black shadow-sm rounded p-1 bg-dark" style="width: 18rem;">

                                <img class="card-img-top" src="./admin'.$row['path_thumbnail'].'" alt="'.$row['title'].'">
                                <div class="card-body bg-lightdark rounded-bottom">
                                <h5 class="card-title">'.$row['title'].'</h5>
                                <p class="card-text">'.$row['description'].'</p>

                                <input type="hidden" name="galleryId" value="'.$row['id'].'">

                                <button name="openGallery" type="button" value="true" class="btn btn-primary" onclick="getGallery('.$row["id"].');">Öffnen</button>
                                </div>
                            </div>
                        </form>
                    </div>';
        }
        $select->close();
        $card .= "</div>
            </div>";
    }
    $mysqli->close();
    echo $card;
}

function getImagesFromDB(?int $galleryId = null) {
    if (session_status() === PHP_SESSION_NONE){session_start();}  /* ImagesId's die der der GalleryId matchen */
    $galleryId = $galleryId == null ? $_GET['galleryId'] : $galleryId;
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
    $carousel = '<div id="imageContainer" class="container">
                    <div id="galleryNav" class="row">
                        <div class="col my-2">
                            <a href="./index.php?nav=gallery" class="btn btn-danger"><i class="bi-arrow-return-left"></i></a>
                        </div>
                    </div>
                    <div class="row" id="gallery" class="gallery">';
    if($select->num_rows == NULL) {
        $carousel .= "<p>Keine Bilder vorhanden.</p>";
    } else {
        while($row = $select->fetch_assoc()) {

            $carousel .= '<div class="card p-0 m-0 bg-transparent shadow-none border-0" style=" width: 15%;">
                            <script>   
                                srclist.push("./admin/gallery/images/'.$row['filename'].'");
                            </script>
                            <img src="./admin/gallery/images/'.$row['filename'].'" class="m-0 gallery-thumb border-0 border-top border-black" alt="'.$row['imgtitle'].'">
                        </div>';
        }
        $select->close();
    }
    $carousel .= "</div></div>";
    $mysqli->close();
    echo $carousel;
}
?>