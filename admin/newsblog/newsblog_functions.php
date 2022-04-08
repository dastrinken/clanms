<?php
function writeArticleToDB($editExisting) {
    $title = $_POST['title'];
    $color = $_POST['color'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $id_author = $_POST['userid'];
    $date = $_POST['date'];
    $publish = $_POST['publish'];
    
    $mysqli = connect_DB();
    if($editExisting === 'true') {
        $articleId = $_POST['articleId'];
        $timestamp = date('Y-m-d H:i:s');
        $stmt = $mysqli->prepare("UPDATE clanms_news SET headline = ?, color = ?, content = ?, date_published = ?, last_edited = ?, id_editor = ? WHERE id = ?");
        $stmt->bind_param("sssssii", $title, $color, $content, $publish, $timestamp, $id_author, $articleId);
    } else {
        $stmt = $mysqli->prepare("INSERT INTO clanms_news(headline, color, content, id_author, date_created, date_published) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("sssiss", $title, $color, $content, $id_author, $date, $publish);
    }
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

function deleteArticleFromDB($articleId) {
    $mysqli = connect_DB();
    $stmt = $mysqli->prepare("DELETE FROM clanms_news_comments WHERE id_news = ?");
    $stmt->bind_param("i",$articleId);
    $stmt->execute();
    $stmt->close();
    $stmt1 = $mysqli->prepare("DELETE FROM clanms_news WHERE clanms_news.id = ?");
    $stmt1->bind_param("i", $articleId);
    $stmt1->execute();
    $stmt1->close();
    $mysqli->close();
}

// TODO: make displayAmount variable (user decides)
// TODO: sort options
// TODO: mark upcoming articles (not yet published) for better ux
// TODO: dates are poorly formatted (from a users point of view)

// store total no of pages in global for javascript use
$totalPages;
function getArticlesFromDB($displayOption) {
    if (session_status() === PHP_SESSION_NONE){session_start();}
    global $totalPages;
    $displayAmount = 10;
    $page = $_GET['page'];
    $offset = ($page - 1) * $displayAmount;
    $mysqli = connect_DB();
    switch($displayOption) {
        case "all":
            $where = "WHERE 1=1";
            break;
        case "week":
            $where = "WHERE YEARWEEK(news.date_published, 1) = YEARWEEK(CURDATE(), 1)";
            break;
        case "month":
            $where = "WHERE MONTH(news.date_published) = MONTH(CURRENT_DATE())
            AND YEAR(news.date_published) = YEAR(CURRENT_DATE())";
            break;
        case "comment":
            /* TODO: kommentare sind noch nicht in Datenbank enthalten. Sobald verfügbar, where ersetzen */
            $where = "WHERE 1=1";
            break;
        default:
            $where = "WHERE 1=1";
            break;
    }
    $totalPagesDB = "SELECT id FROM clanms_news AS news $where";
    $pagesResult = $mysqli->query($totalPagesDB);
    $rowCount = $pagesResult->num_rows;
    $totalPages = ceil($rowCount / $displayAmount);
    $pagesResult->close();

    $select = "SELECT news.id, news.headline, news.content, news.color, news.date_published, news.date_created, news.id_author, user.username, news.last_edited 
    FROM clanms_news AS news
    LEFT JOIN clanms_user AS user
    ON news.id_author = user.id
    $where
    ORDER BY news.date_published DESC
    LIMIT $offset, $displayAmount;";

    $result = $mysqli->query($select);
    $table = "<div class='table'>
                <div class='thead'>
                    <div class='tr mb-2'>
                        <span class='td border-bottom border-dark'>#</span>
                        <span class='td border-bottom border-dark'>Veröffentlichung</span>
                        <span class='td border-bottom border-dark'></span>
                        <span class='td border-bottom border-dark'>Titel</span>
                        <span class='td border-bottom border-dark'>Author</span>
                        <span class='td border-bottom border-dark'>Kommentare</span>
                        <span class='td border-bottom border-dark'>Letzte Änderung</span>
                        <span class='td border-bottom border-dark'></span>
                        <span class='td border-bottom border-dark'></span>
                    </div>
                </div><div class='tbody'>";
    $count = 0;
    while($row = $result->fetch_assoc()) {
        ++$count;
        $news_id = $row['id'];
        $news_author_id = $row['id_author'];
        $headline = $row['headline'];
        $content = $row['content'];
        $name_author = $row['username'];
        $commentCount = getCommentsRowCount($news_id);
        if($commentCount > 0) {
            $commentText = '<a href="#" onclick="getTableView(\'newsblog\', \'commentsOverview\', \'comments\', \''.$news_id.'\'); return false;">'.$commentCount.' Kommentare</a>';
        } else {
            $commentText = ' - ';
        }
        $date_published = $row['date_published'];
        $date_created = $row['last_edited'] != null ? $row['last_edited'] : $row['date_created'];
        $color = $row['color'];
        $table .= '<form class="tr activeTable">
                    <span class="td border-end border-activeTable">'.($offset+$count).'<input type="hidden" name="articleId" value="'.$news_id.'"></span>
                    <span class="td border-end border-activeTable">
                        '.$date_published.'
                        <input type="hidden" name="date_published" value="'.$date_published.'">
                    </span>
                    <span class="td border-end border-activeTable" style="color: '.$color.';">
                        <input type="hidden" name="color" value="'.$color.'">
                        <i class="bi-body-text"></i>
                    </span>
                    <span class="td border-end border-activeTable">
                        '.$headline.'
                        <input type="hidden" name="headline" value="'.$headline.'">
                    </span>
                    <span class="td border-end border-activeTable">
                        '.$name_author.'
                        <input type="hidden" name="author_name" value="'.$name_author.'">
                        <input type="hidden" name="author_id" value="'.$news_author_id.'">
                    </span>
                    <span class="td border-end border-activeTable text-center">
                        '.$commentText.'
                    </span>
                    <span class="td border-end border-activeTable">
                        '.$date_created.'
                        <input type="hidden" name="date_created" value="'.$date_created.'">
                        <input type="hidden" name="content" value="'.$content.'">
                    </span>';
                    if(checkPermission("newsblog",true, $news_author_id)){
                        $table.='<span class="td border-end border-activeTable">
                                    <button name="editArticle" value="true" class="btn btn-secondary submit">Bearbeiten</button>
                                </span>
                                <span class="td border-end border-activeTable">
                                    <button name="deleteArticle" value="true" class="btn btn-danger submit" onclick="return confirm(\'Der Artikel wird endgültig aus der Datenbank gelöscht, bist du dir sicher?\');">Löschen</button>
                                </span>';
                    }
                    $table.='</form>';
    }
    $table .= "</div>";
    $result->close();
    $mysqli->close();
    return $table;
}

function getNewsCatsFromDB() {
    $mysqli = connect_DB();
    $select = "SELECT * FROM clanms_news_categories";
    $result = $mysqli->query($select, MYSQLI_USE_RESULT);
    $resultArray = $result->fetch_all(MYSQLI_ASSOC);
    $result->close();
    $mysqli->close();
    return $resultArray;
}

function showNewsCats(){
    $cats = getNewsCatsFromDB();
    $table = "<div class='table'>
                <div class='thead'>
                    <div class='tr mb-2'>
                        <span class='td border-bottom border-dark'>#</span>
                        <span class='td border-bottom border-dark'>Titel</span>
                        <span class='td border-bottom border-dark'>Beschreibung</span>
                        <span class='td border-bottom border-dark'>Bild</span>
                        <span class='td border-bottom border-dark'></span>
                        <span class='td border-bottom border-dark'></span>
                    </div>
                </div><div class='tbody'>";
    $count = 0;
    foreach($cats as $row){
        ++$count;
        $catId = $row['id'];
        $catTitle = $row['title'];
        $catDesc = $row['description'];
        $table .= '<form class="tr activeTable">
                        <span class="td border-end border-activeTable">'.$count.'<input type="hidden" name="newsCatId" value="'.$catId.'"></span>
                        <span class="td border-end border-activeTable">
                            '.$catTitle.'
                        </span>
                        <span class="td border-end border-activeTable">
                            '.$catDesc.'
                        </span>
                        <span class="td border-end border-activeTable">
                            <button name="editNewsCat" value="true" class="btn btn-secondary submit">Bearbeiten</button>
                        </span>
                        <span class="td border-end border-activeTable"><button name="deleteNewsCat" value="true" class="btn btn-danger submit" onclick="return confirm(\'Die Eventkategorie wird endgültig aus der Datenbank gelöscht, bist du dir sicher?\');">Löschen</button></span>
                    </form>';
        }
        return $table;
    }
?>