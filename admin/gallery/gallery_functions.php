<?php
    /* Gallery */
    function getGalleriesFromDB() {
        if (session_status() === PHP_SESSION_NONE){session_start();}
        $mysqli = connect_DB();
        $query = "SELECT * FROM clanms_galleries";
        $select = $mysqli->query($query);
        while($row = $select->fetch_assoc()) {
            $card = '<div class="col m-2">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="'.$row['path_thumbnail'].'" alt="'.$row['title'].'" thumbnail">
                    <div class="card-body">
                    <h5 class="card-title">'.$row['title'].'</h5>
                    <p class="card-text">'.$row['description'].'</p>
                    <a href="#" class="btn btn-primary">Bearbeiten</a>
                    <a href="#" class="btn btn-danger">Löschen</a>
                    </div>
                </div>
                </div>';
            echo $card;
        }
        $select->close();
        $mysqli->close();
    }

    function uploadImage() {
        $errors= array();
        $year = date('Y');
        $file_name = $_FILES['image']['name'];
        $file_size =$_FILES['image']['size'];
        $file_tmp =$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
        
        $extensions= array("jpeg","jpg","png");
        
        if(in_array($file_ext,$extensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        
        if($file_size > 2097152){
        $errors[]='File size must be excately 2 MB';
        }
        
        if(empty($errors)==true){
            showToastMessage("Datei wurde hochgeladen...");
        if(move_uploaded_file($file_tmp, __DIR__."/../gallery/images/".$file_name)) {
            showToastMessage("Success!");
        }
        } else {
        print_r($errors);
        }
    }
?>