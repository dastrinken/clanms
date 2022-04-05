<?php
    function writeGalleryToDB($editExisting) {
        $title = $_POST['galleryTitle'];
        $description = $_POST['galleryDescription'];
        if($_FILES['image']['size'] != 0) {
            $pathtothumb =  './gallery/images/'.$_FILES['image']['name'];
            uploadImage();
        }
        else {
            $pathtothumb = './gallery/images/gallery.jpg';
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

    function deleteGalleryFromDB($eventId) {
            $mysqli = connect_DB();
            $stmt = $mysqli->prepare("DELETE FROM clanms_galleries WHERE clanms_galleries.id = ?");
            $stmt->bind_param("i", $eventId);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
    }


    /* Gallery */
    function getGalleriesFromDB() {
        if (session_status() === PHP_SESSION_NONE){session_start();}
        $mysqli = connect_DB();
        $query = "SELECT * FROM clanms_galleries";
        $select = $mysqli->query($query);
        if($select->num_rows == NULL) {
            echo "<p>Keine Gallerie vorhanden, klicke oben auf 'Neu' um eine zu erstellen.</p>";
        } else {
            while($row = $select->fetch_assoc()) {
                $card = '<div class="col m-2">
                            <form>
                                <div class="card" style="width: 18rem;">
                                    <img class="card-img-top" src="'.$row['path_thumbnail'].'" alt="'.$row['title'].'" thumbnail">
                                    <div class="card-body">
                                    <h5 class="card-title">'.$row['title'].'</h5>
                                    <p class="card-text">'.$row['description'].'</p>

                                    <input type="hidden" name="galleryId" value="'.$row['id'].'">
                                    <input type="hidden" name="galleryTitle" value="'.$row['title'].'">
                                    <input type="hidden" name="galleryDescription" value="'.$row['description'].'">
                                    <input type="hidden" name="galleryThumbnail" value="'.$row['path_thumbnail'].'">

                                    <button name="editGallery" value="true" class="btn btn-primary submit">Bearbeiten</button>
                                    <button name="deleteGallery" value="true" class="btn btn-danger submit" onclick="return confirm(\'Die Gallerie wird endgültig aus der Datenbank gelöscht, bist du dir sicher?\');">Löschen</button>
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
                $carousel = '<img src="./gallery/images/'.$row['filename'].'" class="m-3 img-thumbnail" alt="'.$row['imgtitle'].'" style=" width: 15%;">';
                echo $carousel;
            }
            $select->close();
        }
        $mysqli->close();
    }

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
        
        if(in_array($file_ext,$extensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        
        if($file_size > 10097152){
        $errors[]='File size must be exactly 2 MB';
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