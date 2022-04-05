<?php
    /* require database connection functions & info in case they don't exist */
    require_once(__DIR__."/../../system/db_functions.php");

    var_dump($_POST);
    //registerImage($_POST["image"]);

    function registerImage($file) {
        //TODO: dateinamen "randomisieren"
        $nameExt = md5(rand());
        var_dump($file);

        $file_name = $nameExt.$file[0]["name"];
        $file_type = $file[0]["type"];
        $file_tmp = $file[0]["tmp_name"];
        $file_size = $file[0]["size"];


        move_uploaded_file($file_tmp, __DIR__."/./images/".$file_name);
/*
        $mysqli = connect_DB();
        $stmt = $mysqli->prepare("INSERT INTO clanms_images(title, description, filename) VALUES (?,?,?)");
        $stmt->bind_param("sss", $title, $description, $file_name);

        /*

        $file_name = $nameExt.$_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];



        1. Datei aus tmp verschieben in /gallery/images
            2. datenbankeintrag clanms_images und datenbankeintrag clanms_gallery_images
        */

    }

    
    /* Mögliche Probleme: 2 Dateien haben den exakt gleichen Dateinamen 
    $nameExt;
    function addImageToDB() {
        global $nameExt;
        $nameExt = md5(rand());
        $title = $_POST['imageTitle'];
        $description = $_POST['imageDescription'];
        if($_FILES['image']['size'] != 0) {
            $filename =  './gallery/images/'.''.$_FILES['image']['name'];
            uploadImage();
        }
        $mysqli = connect_DB();
            $ImageId = $_POST['imageId'];
            $galleryId = $_POST['galleryId'];
            $stmt = $mysqli->prepare("INSERT INTO clanms_images(title, description, filename) VALUES (?,?,?)");
            $stmt->bind_param("sss", $title, $description, $filename);
        $stmt->execute();

            $stmt = $mysqli->prepare("INSERT INTO clanms_gallery_images(id_gallery, id_image) VALUES (?,?)");  
            $stmt->bind_param("ii", $galleryId, $ImageId);
            $stmt->execute();

        $stmt->close();
        $mysqli->close();
    }

    */
?>