<?php
    require_once(__DIR__."/../../system/db_functions.php");
    require_once(__DIR__."/../../admin/scripts/rights_system.php");
    require_once(__DIR__."/../../parsedown/parsedown.php");
    
    $Parsedown = new Parsedown();
    $Parsedown->setSafeMode(true);

    if($_POST["command"] == "showComments") {
        showComments($_POST["id"]);
    }

    function showAllNews() {
        global $Parsedown;
        $mysqli = connect_DB();
        $select = "SELECT news.id, news.headline, news.content, news.color, news.date_published, user.username FROM clanms_news AS news
        LEFT JOIN clanms_user AS user
        ON news.id_author = user.id
        WHERE DATEDIFF(news.date_published, NOW()) <= 0 
        ORDER BY news.date_published DESC;";
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
        $mysqli->close();
    }

    function showComments($newsid) {
        global $Parsedown;
        $mysqli = connect_DB();
        $select = "SELECT cnc.id_author AS userId, 
                cnc.id_news AS newsId, 
                cnc.content AS content, 
                cup.name AS authorName, 
                cup.avatar AS ppic, 
                cnc.date_written AS date 
                FROM clanms_news_comments AS cnc
                JOIN clanms_user_profile AS cup ON cnc.id_author = cup.id_user 
                WHERE cnc.id_news = $newsid;";
        $result = $mysqli->query($select);
  
        foreach($result as $row){
            $commentContent = $Parsedown->text($row['content']);
            $commentPpic = base64_encode($row['ppic']);
            $commentAuthor = $row['authorName'];
            $commentDate = $row['date'];
            include(__DIR__."/templates/comment_template.php");
        }

        $mysqli->close();
    }

    function displayCommentForm() {

    }
?>