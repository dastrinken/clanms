<?php 
    /* SESSION setzen, falls noch nicht geschehen */
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../scripts/adminfunctions.php");
    if($editing) {
        if(checkPermission("newsblog", true, $_GET['author_id'])) {
            $title = $_GET['headline'];
            $content = $_GET['content'];
            $articleId = $_GET['articleId'];
            $color = $_GET['color'];
            $author_name = $_GET['author_name'];
            $date_created = $_GET['date_created'];
            $date_published = $_GET['date_published'];
            $date_p_array = explode(" ", $date_published);
            $date_published_w3c = $date_p_array[0]."T".$date_p_array[1];
            echo "<h2 class='text-center mt-2'>Artikel bearbeiten</h2>";
            include_once(__DIR__."/writeArticleForm.php");
        } else {
            echo "<p>Dir fehlen die nötigen Berechtigungen hierfür...</p>";
        }
    } else {
        if(checkPermission("newsblog", false)) {
            echo "<h2 class='text-center mt-2'>Neuer Artikel</h2>";
            include_once(__DIR__."/writeArticleForm.php");
        } else {
            echo "<p>Dir fehlen die nötigen Berechtigungen hierfür...</p>";
        }
    }
?>
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
    var simplemde = new SimpleMDE();
</script>