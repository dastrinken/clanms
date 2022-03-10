<?php
/* Newsblog */
if($_POST['saveArticle']) {
    writeArticleToDB();
}

function writeArticleToDB() {
    $title = $_POST['title'];
    $color = $_POST['color'];
    //$content = nl2br2($_POST['content']);
    $content = $_POST['content'];
    $author = $_POST['author'];
    $id_author = $_POST['userid'];
    $date = $_POST['date'];
    $publish = $_POST['publish'];    
    
    showToastMessage("Writing to DB:<br>Title:".$title." Color: ".$color."<br> Content: ".$content."<br>Author: ".$author." Date: ".$date."<br>Publish: ".$publish);

    $mysqli = connect_DB();
    $stmt = $mysqli->prepare("INSERT INTO clanms_news(headline, color, content, id_author, date_created, date_published) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("sssiss", $title, $color, $content, $id_author, $date, $publish);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

function getArticlesFromDB($displayOption) {
    $Parsedown = new Parsedown();
    $Parsedown->setSafeMode(true);
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
            break;
    }
    $select = "SELECT news.headline, news.content, news.color, news.date_published, news.date_created, user.username FROM clanms_news AS news
    LEFT JOIN clanms_user AS user
    ON news.id_author = user.id
    ".$where."
    ORDER BY news.date_published DESC;";

    /* TODO: paging */
    $result = $mysqli->query($select);
    echo "<table class='table table-hover'>
            <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Veröffentlichung</th>
                <th scope='col'>Titel</th>
                <th scope='col'>Author</th>
                <th scope='col'>Erstellt</th>
            </tr>
            </thead>";
    $count = 0;
    while($row = $result->fetch_assoc()) {
        ++$count;
        $headline = $row['headline'];
        $content = $Parsedown->text($row['content']);
        $name_author = $row['username'];
        $date_published = $row['date_published'];
        $date_created = $row['date_created'];
        $color = $row['color'];
        echo '<tr>
                <th scope="row">'.$count.'</th>
                <td>'.$date_published.'</td>
                <td>'.$headline.'</td>
                <td>'.$name_author.'</td>
                <td>'.$date_created.'</td>
            </tr>';
    }
    echo "</table>";
    $mysqli->close();
}

function nl2br2($string) {
    $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
    return $string;
    }
     
?>