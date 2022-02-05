<?php
    /* TODO: Include all important files 
    ** - Session anlegen
    */
    require("./system/dbconnect.php");
    require("./system/settings.php");
    $title = getSetting("title");
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- CSS only -->
    <link href="./bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/style.css"> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <?php echo "<title>$title</title>" ?>
</head>
<body>
    <div class="d-flex flex-column flex-shrink-0 bg-light">
        <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
            <li>Test</li>
        </ul>
    </div>
    <nav class="nav justify-content-center nav-tabs">
        <a class="nav-link active" aria-current="page" href="#">Home</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link disabled">Disabled</a>
    </nav>
    <div class="wrapper">

    </div>
</body>
</html>