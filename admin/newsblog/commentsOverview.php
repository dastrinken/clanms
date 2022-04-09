<?php
    /* SESSION setzen, falls noch nicht geschehen */
    if (session_status() === PHP_SESSION_NONE){session_start();}
    require_once(__DIR__."/../scripts/adminfunctions.php");
    
    echo '<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 id="headlineDashboardContent" class="h2"></h1>
            </div>';

    function showCommentsOverview() {
        global $Parsedown;
        $newsid = $_GET['articleId'];
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
        $table = '<div class="table">
                    <div class="thead">
                        <div class="tr mb-2">
                            <span class="td border-bottom border-dark">#</span>
                            <span class="td border-bottom border-dark">Author</span>
                            <span class="td border-bottom border-dark">Kommentar</span>
                            <span class="td border-bottom border-dark">Datum</span>
                            <span class="td border-bottom border-dark"></span>
                        </div>
                    </div>
                    <div class="tbody">';
        $count = 1;
  
        foreach($result as $row){
            $commentid = $row['commentId'];
            $commentContent = $Parsedown->text($row['content']);
            $commentPpic = base64_encode($row['ppic']);
            $authorid = $row['userId'];
            $commentAuthor = $row['authorName'];
            $commentDate = $row['date'];
            $table .= '<form method="post" class="tr activeTable">
                            <span class="td border-end border-activeTable" name="count">'.$count.'
                                <input type="hidden" name="authorId" value="'.$authorid.'">
                                <input type="hidden" name="commentId" value="'.$commentid.'">
                            </span>
                            <span class="td border-end border-activeTable" name="commentAuthor">'.$commentAuthor.'</span>
                            <span class="td border-end border-activeTable" name="content">'.$commentContent.'</span>
                            <span class="td border-end border-activeTable" name="date">'.$commentDate.'</span>
                            <span class="td border-end border-activeTable" name="date">';
            if(checkPermission("newsblogCommentAdmin", true, $authorid)){
                $table .= '<button class="btn btn-danger submit" name="deleteComment" value="true">Löschen</button>';
            }
            $table .= '</span></form>';
                        
            $count++;
        }
        $table .= '</div>';
        $mysqli->close();
        echo $table;
    }
    showCommentsOverview();
?>