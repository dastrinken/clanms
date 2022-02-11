<?php
    /* TODO: Include all important files 
    ** - Start session, set all cookies
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
<body class="bg-dark text-white">
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-auto"><?php require("./sidebar.php"); ?></div>
                <div class="col">
                    <div class="row">
                        <?php require("./header.php"); ?>
                    </div>
                    <!-- This extra row is for optional sub-pages. Can be enabled and disabled by admin-backend
                    <div class="row">
                        <?php //require("./nav.php"); ?>
                    </div> 
                    -->
                    <!-- Content -->
                    <div class="row p-3 content-wrapper bg-blackened">
                        <?php include("./content/articles/article_template.php"); 
                            /* TODO: 
                            **   - autom. include all articles
                            **   - avoid potential security risk when using get
                            */
                        ?>
                    </div>
                </div>
            </div>
            <div class="row"><!-- Footer -->
                <?php include("./footer.php"); ?>
            </div>
        </div>
    </main>
</body>
</html>