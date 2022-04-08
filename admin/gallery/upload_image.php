<?php
    /* require database connection functions & info in case they don't exist */
    require_once(__DIR__."/../../system/db_functions.php");
    registerImage($_FILES);

    function registerImage($file) {
        $nameExt = md5(rand());
        $errors= array();

        $file_name = $nameExt.$file["image"]["name"];
        $file_type = $file["image"]["type"];
        $file_tmp = $file["image"]["tmp_name"];
        $file_size = $file["image"]["size"];
        $galleryId = $_POST['galleryId'];
        $description = $_POST['description'];
        $imgtitle = $_POST['imageTitle'];
        $file_ext = strtolower(end(explode('.',$file[0]['name'])));

        if(move_uploaded_file($file_tmp, __DIR__."/./images/".$file_name)){
            if(writeImageToDB($galleryId, $file_name, $description, $imgtitle)) {
                echo "Success!";
            }
        } else {
            echo "Fail!";
        }
    }

    function writeImageToDB($galleryId, $file_name, $description, $imgtitle) {
        $success = false;
        $mysqli = connect_DB();
        $insert = $mysqli->prepare("INSERT INTO clanms_images(title, description, filename) VALUES (?,?,?)");
        $insert->bind_param("sss", $imgtitle, $description, $file_name);
        if($insert->execute()) {
            $success = true;
        }
        $insert->close();

        if($success == true) {
            $success = false;
            $imageId = $mysqli->insert_id;
            $insert= $mysqli->prepare("INSERT INTO clanms_gallery_images(id_gallery, id_image) VALUES (?,?)");
            if($insert->bind_param("ii", $galleryId, $imageId)) {
                $success = true;
            }
            $insert->execute();
            $insert->close();
        }

        $mysqli->close();
        return $success;
    }
?>