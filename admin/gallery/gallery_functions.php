<?php
    require_once(__DIR__."/../../system/db_functions.php");
    $nameExt;

    if($_POST['command'] == 'deleteImage') {
        deleteImageFromDB($_POST['postId']);
    }

    function writeGalleryToDB($editExisting) {
        global $nameExt;
        $title = $_POST['galleryTitle'];
        $description = $_POST['galleryDescription'];
        if($_FILES['image']['size'] != 0) {
            uploadImage();
            $pathtothumb =  '/gallery/images/'.$nameExt.$_FILES['image']['name'];
        }
        else {
            $pathtothumb = '/gallery/images/gallery.jpg';
        }

        $mysqli = connect_DB();
        if($editExisting === 'true') {
            $galleryId = $_POST['galleryId'];
            if($_FILES['image']['size'] == 0) {
                $pathtothumb = selectOneRow_DB("path_thumbnail", "clanms_galleries", "id", $_POST['galleryId']);
            }
            $stmt = $mysqli->prepare("UPDATE clanms_galleries SET title = ?, description = ?, path_thumbnail = ? WHERE id = ?");
            $stmt->bind_param("sssi",$title, $description, $pathtothumb, $galleryId);
        } else {
            $stmt = $mysqli->prepare("INSERT INTO clanms_galleries(title, description, path_thumbnail) VALUES (?,?,?)");
            $stmt->bind_param("sss", $title, $description, $pathtothumb);
        }
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    }

    function deleteGalleryFromDB($galleryId) {
            $countImage = getGalleryImagesCount($galleryId) > 0 ? deleteGalleryImages($galleryId) : "";
            $mysqli = connect_DB();
            $stmt = $mysqli->prepare("DELETE FROM clanms_galleries WHERE clanms_galleries.id = ?");
            $stmt->bind_param("i", $galleryId);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
    }

    function deleteGalleryImages($galleryId) {
        $mysqli = connect_DB();
        $select = $mysqli->query("SELECT filename FROM clanms_images 
                    LEFT JOIN clanms_gallery_images 
                    ON clanms_images.id = clanms_gallery_images.id_image 
                    WHERE clanms_gallery_images.id_gallery = $galleryId");
        if(deleteImagesFromServer($select->fetch_all(MYSQLI_ASSOC))) {
            $mysqli->query("DELETE FROM clanms_gallery_images WHERE id_gallery = $galleryId");
        }
        $mysqli->close();
    }

    function deleteImagesFromServer($filesArray) {
        $deletion = true;
        foreach($filesArray as $filename) {
            if(!unlink("./gallery/images/".$filename['filename'])) {
                $deletion = false;
            }
        }
        return $deletion;
    }

    function deleteImageFromDB($imageId) {
        $mysqli = connect_DB();
        $select = $mysqli->query("SELECT filename FROM clanms_images WHERE id = $imageId;");
        while($row = $select->fetch_assoc()) {
            $filename = $row['filename'];
        }
        $select->close();
        if($mysqli->query("DELETE FROM clanms_gallery_images WHERE id_image = $imageId;")) {
            if($mysqli->query("DELETE FROM clanms_images WHERE id = $imageId;")){
                if(!unlink("./images/".$filename)) {
                    echo "Datei konnte nicht gelöscht werden.";
                }
            }
        }
        $mysqli->close();
    }


    /* Gallery */
    function getGalleriesFromDB() {
        if (session_status() === PHP_SESSION_NONE){session_start();}
        $mysqli = connect_DB();
        $query = "SELECT * FROM clanms_galleries;";
        $select = $mysqli->query($query);
        if($select->num_rows == NULL) {
            echo "<p>Keine Gallerie vorhanden, klicke oben auf 'Neu' um eine zu erstellen.</p>";
        } else {
            while($row = $select->fetch_assoc()) {
                $imageCount = getGalleryImagesCount($row['id']);
                $warning = $imageCount > 0 ? "In dieser Gallerie befinden sich noch $imageCount Bild(er), möchtest du sie wirklich löschen?" : "Die Gallerie wird endgültig aus der Datenbank gelöscht, bist du dir sicher?";
                $card = '<div class="col m-2" style="max-width: 30%;">
                            <form>
                                <div class="card shadow-sm">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                        '.$imageCount.'
                                    </span>

                                    <img class="card-img-top" src=".'.$row['path_thumbnail'].'" alt="'.$row['title'].'" thumbnail">
                                    <div class="card-body border-top bg-light">
                                        <h5 class="card-title">'.$row['title'].'</h5>
                                        <p class="card-text">'.$row['description'].'</p>

                                        <input type="hidden" name="galleryId" value="'.$row['id'].'">
                                        <input type="hidden" name="galleryTitle" value="'.$row['title'].'">
                                        <input type="hidden" name="galleryDescription" value="'.$row['description'].'">
                                        <input type="hidden" name="galleryThumbnail" value="'.$row['path_thumbnail'].'">
                                        <div class="col d-flex justify-content-evenly">
                                            <button name="editGallery" value="true" class="btn btn-primary submit" >Bearbeiten</button>
                                            <button name="deleteGallery" value="true" class="btn btn-danger submit" onclick="return confirm(\''.$warning.'\');">Löschen</button>
                                        </div>
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

    function getGalleryImagesCount($gallId) {
        $mysqli = connect_DB();
        $select = "SELECT id FROM clanms_gallery_images WHERE id_gallery = $gallId;";
        $result = $mysqli->query($select);
        $mysqli->close();
        return $result->num_rows;
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
            echo "<p class='w-50 text-center'>Keine Bilder vorhanden.</p>";
        } else {
            while($row = $select->fetch_assoc()) {

                $carousel = '<div class="card p-0 m-2 bg-light" style=" width: 15%;">
                                <span class="position-absolute top-0 start-100 translate-middle">
                                     <button name="deleteImage" value="true" class="btn btn-sm submit" onclick="deleteImageFromDB('.$row['imageId'].'); reloadImages();"><i class="bi-x-square-fill text-danger"></i></button>
                                </span>
                                <img src="./gallery/images/'.$row['filename'].'" class="m-1 img-thumbnail border-0" alt="'.$row['imgtitle'].'">
                            </div>';
                echo $carousel;
            }
            $select->close();
        }
        $mysqli->close();
    }

    /* TODO: make year-directories work */
    function uploadImage() {
        $errors= array();
        global $nameExt;
        if(empty($nameExt)) {
            $nameExt = md5(rand());
        }
        $year = date('Y');
        $file_name = $nameExt.$_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
        
        $extensions= array("jpeg","jpg","png");
        
        if(in_array($file_ext,$extensions) === false){
        $errors[]="Format not allowed, please choose a JPEG or PNG file.";
        }
        
        if($file_size > (2*MB)){
        $errors[]='File size must be smaller than 2 MB';
        }
        
        if(empty($errors)==true){
            showToastMessage("Datei wurde hochgeladen...");
        if(move_uploaded_file($file_tmp, __DIR__."/./images/".$file_name)) {
            showToastMessage("Success!");
        }
        } else {
        print_r($errors);
        }
    }


    /* 
        clanms_images -> clanms_gallery_images 
            |
             -> clanms_images_use_tags ? eintragen : neuer tag -> clanms_images_tags

    */
?>