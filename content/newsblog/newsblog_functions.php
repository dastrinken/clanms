<?php
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../../system/db_functions.php");
    require_once(__DIR__."/../../admin/scripts/rights_system.php");
    require_once(__DIR__."/../../parsedown/parsedown.php");
    require_once(__DIR__."/../../system/account/account_functions.php");
    
    $Parsedown = new Parsedown();
    $Parsedown->setSafeMode(true);

    if($_POST['deleteComment'] == "true"){
        deleteCommentFromDB($_POST['commentid']);
    }

    if($_POST["command"] == "showComments") {
        displayCommentForm($_POST["id"]);
        showComments($_POST["id"]);
        
    }
    if($_POST["saveComment"] === "true"){
        var_dump($_POST);
        writeCommentToDB();
    }
   

    $totalPages;
    function showAllNews() {
        global $Parsedown;
        //Pagination variables
        global $totalPages;
        $displayAmount = 5;
        $page = $_GET['page'];
        $offset = ($page - 1) * $displayAmount;

        $mysqli = connect_DB();
        $totalPagesDB = "SELECT id FROM clanms_news AS news";
        $pagesResult = $mysqli->query($totalPagesDB);
        $rowCount = $pagesResult->num_rows;
        $totalPages = ceil($rowCount / $displayAmount);
        $pagesResult->close();
        
        $select = "SELECT news.id, news.headline, news.content, news.color, news.date_published, user.username FROM clanms_news AS news
        LEFT JOIN clanms_user AS user 
        ON news.id_author = user.id 
        WHERE DATEDIFF(news.date_published, NOW()) <= 0 
        ORDER BY news.date_published DESC 
        LIMIT $offset, $displayAmount;";
        $result = $mysqli->query($select);
        while($row = $result->fetch_assoc()) {
            $article_id = $row['id'];
            $article_headline = $row['headline'];
            $article_content = $Parsedown->text($row['content']);
            $article_name_author = $row['username'];
            $article_date_published = $row['date_published'];
            $article_color = $row['color'];
            include(__DIR__."/templates/article_template.php");
        }
        include(__DIR__."/newsblog_pagination.php");
        $mysqli->close();
    }

    function getCommentsRowCount($articleId){
        $mysqli = connect_DB();
        $select = $mysqli->prepare("SELECT id FROM clanms_news_comments WHERE id_news = ?");
        $select->bind_param("i", $articleId);
        $select->execute();
        $select->store_result();
        $result = $select->num_rows;
        $select->close();
        $mysqli->close();
        return $result;
    }
    
    function showComments($newsid) {
        global $Parsedown;
        $mysqli = connect_DB();
        $select = "SELECT cnc.id AS commentId,
                cnc.id_author AS userId, 
                cnc.id_news AS newsId, 
                cnc.content AS content, 
                cup.name AS authorName, 
                cup.avatar AS ppic, 
                cnc.date_written AS date 
                FROM clanms_news_comments AS cnc
                JOIN clanms_user_profile AS cup ON cnc.id_author = cup.id_user 
                WHERE cnc.id_news = $newsid
                ORDER BY date DESC;";
        $result = $mysqli->query($select);
  
        foreach($result as $row){
            $commentid = $row['commentId'];
            $commentContent = $Parsedown->text($row['content']);
            $commentPpic = base64_encode($row['ppic']);
            $authorid = $row['userId'];
            $commentAuthor = $row['authorName'];
            $commentDate = $row['date'];
            include(__DIR__."/templates/comment_template.php");
        }

        $mysqli->close();
    }

    function displayCommentForm($newsid) {
        if (session_status() === PHP_SESSION_NONE){session_start();}
        if(!empty($_SESSION)){
            if(checkPermission("newsblogComment", false)){
                echo "<form method='post' class='bg-lightdark rounded mb-3'>
                        <label for='commentContent' class='form-label'></label>
                            <input type='hidden' name='newsid' value='".$newsid."'>
                            <textarea class='form-control' id='commentContent".$newsid."' name='commentContent' palceholder='Schreibe hier deinen Kommentar'></textarea>
                            <hr class='mt-0'>
                            <div class='d-flex flex-row align-items-center justify-content-between px-2 pb-2'>
                                <div class='d-flex'>
                                    ".getProfilePic(25,1)."
                                    <p class='small mb-0 ms-2'>".selectOneRow_DB("name", "clanms_user_profile", "id_user", $_SESSION['userid'])."</p>
                                </div>
                                <input type='hidden' name='nav' value='news'>
                                <button name='saveComment' class='btn btn-danger submit' value='true'>Senden</button>
                            </div>
                    </form>";
            }
            else{
                echo "<p>Bitte melden Sie sich an, um zu kommentieren</p>";
            }
        }
}

    function writeCommentToDB(){
        $content = $_POST['commentContent'];
        $newsid = $_POST['newsid'];
        $userid = $_SESSION['userid'];
        $timestamp = date('Y-m-d H:i:s');
        $mysqli = connect_DB();
        if(!empty($content)){
            $insert = $mysqli->prepare("INSERT INTO clanms_news_comments(id_author, id_news, content, date_written) VALUES (?,?,?,?)");
            $insert->bind_param("iiss", $userid, $newsid, $content, $timestamp);
            $insert->execute();
            $insert->close();
        }else{
            showToastMessage("Bitte geben sie einen Kommentar ein");
        }
        $mysqli->close();
        $_POST = '';
    }

    function deleteCommentFromDB($commentId){
        $mysqli = connect_DB();
        $delete = $mysqli->prepare("DELETE FROM clanms_news_comments WHERE id = ?");
        $delete->bind_param("i", $commentId);
        $delete->execute();
        $delete->close();
        $mysqli->close();
    }
?>