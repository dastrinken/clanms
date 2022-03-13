<?php
/* Newsblog */
if($_POST['saveArticle']) {
    writeArticleToDB($_POST['updateArticle']);
} 

if($_GET['deleteArticle'] === 'true') {
    deleteArticleFromDB($_GET['articleId']);
}

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
        showToastMessage("create new");
        $stmt = $mysqli->prepare("INSERT INTO clanms_news(headline, color, content, id_author, date_created, date_published) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("sssiss", $title, $color, $content, $id_author, $date, $publish);
    }
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

function deleteArticleFromDB($articleId) {
    $mysqli = connect_DB();
    $stmt = $mysqli->prepare("DELETE FROM clanms_news WHERE clanms_news.id = ?");
    $stmt->bind_param("i", $articleId);
    $stmt->execute();
    $stmt->close();
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
    $Parsedown = new Parsedown();
    $Parsedown->setSafeMode(true);

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
    $totalPagesDB = "SELECT * FROM clanms_news AS news $where";
    $pagesResult = $mysqli->query($totalPagesDB);
    $rowCount = $pagesResult->num_rows;
    $totalPages = ceil($rowCount / $displayAmount);
    $pagesResult->close();
    
    $select = "SELECT news.id, news.headline, news.content, news.color, news.date_published, news.date_created, news.id_author, user.username, news.last_edited FROM clanms_news AS news
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
                    <span class="td border-end border-activeTable">
                        '.$date_created.'
                        <input type="hidden" name="date_created" value="'.$date_created.'">
                    </span>
                    <span class="td border-end border-activeTable">
                        <input type="hidden" name="content" value="'.$content.'">
                        <input type="hidden" name="userid" value="'.$_SESSION["userid"].'">
                        <button name="editArticle" value="true" class="btn btn-secondary submit">Bearbeiten</button>
                    </span>
                    <span class="td border-end border-activeTable"><button name="deleteArticle" value="true" class="btn btn-danger submit" onclick="alert(\'Der Artikel wird aus der Datenbank gelöscht, bist du dir sicher?\');">Löschen</button></span>
                </form>';
    }
    $table .= "</div>";
    $result->close();
    $mysqli->close();
    return $table;
}

?>