<?php
    require_once(__DIR__."/../../system/db_functions.php");

    /**
     * Selects all News articles from database and displays them in article_template.php
     */
    function showAllNews() {
        $Parsedown = new Parsedown();
        $Parsedown->setSafeMode(true);
        $mysqli = connect_DB();
        $select = "SELECT news.headline, news.content, news.color, news.date_published, user.username FROM clanms_news AS news
        LEFT JOIN clanms_user AS user
        ON news.id_author = user.id
        WHERE DATEDIFF(news.date_published, NOW()) <= 0 
        ORDER BY news.date_published DESC;";
        $result = $mysqli->query($select);
        while($row = $result->fetch_assoc()) {
            $article_headline = $row['headline'];
            $article_content = $Parsedown->text($row['content']);
            $article_name_author = $row['username'];
            $article_date_published = $row['date_published'];
            $article_color = $row['color'];
            include(__DIR__."/templates/article_template.php");
        }
        $mysqli->close();
    }

?>