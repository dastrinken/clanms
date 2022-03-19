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
                    <span class="td border-end border-activeTable"><button name="deleteArticle" value="true" class="btn btn-danger submit" onclick="alert(\'Der Artikel wird endgültig aus der Datenbank gelöscht, bist du dir sicher?\');">Löschen</button></span>
                </form>';
    }
    $table .= "</div>";
    $result->close();
    $mysqli->close();
    return $table;
}

/* Events */
if($_POST['saveEvent']) {
    writeEventToDB($_POST['updateEvent']);
} 

if($_GET['deleteEvent'] === 'true') {
    deleteEventFromDB($_GET['eventId']);
}

function writeEventToDB($editExisting) {
    $title = $_POST['eventTitle'];
    $description = $_POST['eventDescription'];
    $id_author = $_POST['userid'];
    $date_created = $_POST['date_created'];
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];
    $event_cat = $_POST['eventCat'];
    var_dump($title, $description, $id_author, $date_created, $date_start, $date_end, $event_cat);
    
    $mysqli = connect_DB();
    if($editExisting === 'true') {
        $eventId = $_POST['eventId'];
        $stmt = $mysqli->prepare("UPDATE clanms_event SET title = ?, description = ?, created = ?, start = ?, end = ?, event_cat = ?, id_user = ? WHERE id = ?");
        $stmt->bind_param("sssssiii",$title, $description, $date_created, $date_start, $date_end, $event_cat, $id_author, $eventId);
    } else {
        $stmt = $mysqli->prepare("INSERT INTO clanms_event(title, description, created, start, end, event_cat, id_user) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssii", $title, $description, $date_created, $date_start, $date_end, $event_cat, $id_author);
    }
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

function getEventCatsFromDB() {
    $mysqli = connect_DB();
    $select = "SELECT * FROM clanms_event_category";
    $result = $mysqli->query($select, MYSQLI_USE_RESULT);
    $resultArray = $result->fetch_all(MYSQLI_ASSOC);
    $result->close();
    $mysqli->close();
    return $resultArray;
}

function deleteEventFromDB($eventId) {
    $mysqli = connect_DB();
    $stmt = $mysqli->prepare("DELETE FROM clanms_event WHERE clanms_event.id = ?");
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

function getEventsFromDB($displayOption) {
    if (session_status() === PHP_SESSION_NONE){session_start();}
    $mysqli = connect_DB();
    switch($displayOption) {
        case "all":
            $where = "WHERE 1=1";
            break;
        case "week":
            $where = "WHERE YEARWEEK(start, 1) = YEARWEEK(CURDATE(), 1)";
            break;
        case "month":
            $where = "WHERE MONTH(start) = MONTH(CURRENT_DATE())
            AND YEAR(start) = YEAR(CURRENT_DATE())";
            break;
        default:
            $where = "WHERE 1=1";
            break;
    }
    $select = "SELECT *, timediff(end, start) AS diff FROM clanms_event ".$where;
    $result = $mysqli->query($select, MYSQLI_USE_RESULT);
    $table = "<div class='table'>
    <div class='thead'>
        <div class='tr mb-2'>
            <span class='td border-bottom border-dark'>#</span>
            <span class='td border-bottom border-dark'>Datum</span>
            <span class='td border-bottom border-dark'>Titel</span>
            <span class='td border-bottom border-dark'>Start</span>
            <span class='td border-bottom border-dark'>Ende</span>
            <span class='td border-bottom border-dark'>Dauer</span>
            <span class='td border-bottom border-dark'>Kategorie</span>
            <span class='td border-bottom border-dark'>Verantwortlich</span>
            <span class='td border-bottom border-dark'></span>
            <span class='td border-bottom border-dark'></span>
        </div>
    </div><div class='tbody'>";
    $count = 0;
    while($row = $result->fetch_assoc()) {
    ++$count;
    $event_id = $row['id'];
    $event_author = $row['id_user'];
    $event_title = $row['title'];
    $event_desc = $row['description'];

    $event_start = $row['start'];
    $event_start_display = explode(" ", $row['start']);
    $event_end = $row['end'];
    $timediff = $row['diff'];

    foreach($event_start_display as $datetime) {
        $date = $event_start_display[0];
        $time = $event_start_display[1];
    }

    $event_cat = $row['event_cat'];
    $table .= '<form class="tr activeTable">
                <span class="td border-end border-activeTable">
                '.(/*$offset+*/$count).'
                    <input type="hidden" name="eventId" value="'.$event_id.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$date.'
                    <input type="hidden" name="eventStart" value="'.$event_start.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$event_title.'
                    <input type="hidden" name="eventTitle" value="'.$event_title.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$time.'
                    <input type="hidden" name="eventStart" value="'.$event_start.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$event_end.'
                    <input type="hidden" name="eventEnd" value="'.$event_end.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$timediff.'
                </span>
                <span class="td border-end border-activeTable">
                    '.$event_cat.'
                    <input type="hidden" name="eventCat" value="'.$event_cat.'">
                </span>
                <span class="td border-end border-activeTable">
                    '.$event_author.'
                    <input type="hidden" name="author_id" value="'.$event_author.'">
                </span>

                <input type="hidden" name="description" value="'.$event_desc.'">
                <span class="td border-end border-activeTable">
                    <button name="editEvent" value="true" class="btn btn-secondary submit">Bearbeiten</button>
                </span>
                <span class="td border-end border-activeTable">
                    <button name="deleteEvent" value="true" class="btn btn-danger submit" onclick="alert(\'Das Event wird endgültig aus der Datenbank gelöscht, bist du dir sicher?\');">Löschen</button>
                </span>
            </form>';
    }
    $table .= "</div>";
    $result->close();
    $mysqli->close();
    return $table;

/* Benutzerverwaltung */
if($_GET['deleteUserOverview'] === 'true') {
    deleteUserFromDB($_GET['userId']);
}

function deleteUserFromDB($userid){
    if (session_status() === PHP_SESSION_NONE){session_start();}
    $mysqli = connect_DB();
    $stmt1 = $mysqli->prepare("DELETE FROM clanms_user_groups WHERE clanms_user_groups.id_user = ?");
    $stmt1->bind_param("i", $userid);
    $stmt1->execute();
    $stmt1->close();
    $stmt2 = $mysqli->prepare("DELETE FROM clanms_user_profile WHERE clanms_user_profile.id_user = ?");
    $stmt2->bind_param("i",$userid);
    $stmt2->execute();
    $stmt2->close();
    $stmt3 = $mysqli->prepare("DELETE FROM clanms_user WHERE clanms_user.id = ?");
    $stmt3->bind_param("i", $userid);
    $stmt3->execute();
    $stmt3->close();
    $mysqli->close();
}

function getUsersFromDB($displayOption) {
    if (session_status() === PHP_SESSION_NONE){session_start();}
    $groups = getUserGroups();
    $mysqli = connect_DB();
    switch($displayOption) {
        case "all":
            $where = "";
            break;
        case "admin":
            $where = "WHERE cg.title = 'Admin'";
            break;
        case "moderator":
            $where = "WHERE cg.title = 'Moderator'";
            break;
        case "member";
            $where = "WHERE cg.title = 'Member'";
            break;
        case "registered":
            $where = "WHERE cg.title = 'Registered'";
            break;
        default:
            $where = "";
            break;
    }
    $select = "SELECT cs.id AS userid, cs.username, cs.email, cs.registeredSince, cs.activated, cg.title, cg.id AS groupId FROM clanms_user cs JOIN clanms_user_groups cug ON cs.id = cug.id_user JOIN clanms_groups cg ON cug.id_group = cg.id ".$where;
    $result = $mysqli->query($select, MYSQLI_USE_RESULT);
    $table = "<div class='table'>
    <div class='thead'>
        <div class='tr mb-2'>
            <span class='td border-bottom border-dark'>#</span>
            <span class='td border-bottom border-dark'>Username</span>
            <span class='td border-bottom border-dark'>E-mail</span>
            <span class='td border-bottom border-dark'>Registriert seit</span>
            <span class='td border-bottom border-dark'>Aktiviert (1 = ja, 0 = nein)</span>
            <span class='td border-bottom border-dark'>Nutzergruppe</span>
            <span class='td border-bottom border-dark'></span>
            <span class='td border-bottom border-dark'></span>
        </div>
    </div><div class='tbody'>";
    $count = 0;
    while($row = $result->fetch_assoc()) {
        var_dump($groups);
        ++$count;
        $user_id = $row['userid'];
        $user_name = $row['username'];
        $user_email = $row['email'];
        $user_registeredSince = $row['registeredSince'];
        if($row['activated']==="1"){
            $user_activated = "aktiviert";
        }elseif($row['activated']==="0"){
            $user_activated = "nicht aktiviert";
        }
        $group_title = $row['title'];
        $group_id = $row['groupId'];
        $table .= '<form class="tr activeTable" onsubmit="confirmDelete()">
                    <span class="td border-end border-activeTable">
                    '.(/*$offset+*/$count).'
                        <input type="hidden" name="userId" value="'.$user_id.'">
                    </span>
                    <span class="td border-end border-activeTable" name="userName">
                        '.$user_name.'
                    </span>
                    <span class="td border-end border-activeTable" name="userEmail">
                        '.$user_email.'
                        <input type="hidden" name="eventTitle" value="'.$user_email.'">
                    </span>
                    <span class="td border-end border-activeTable" name="userRegistered">
                        '.$user_registeredSince.'
                        <input type="hidden" name="eventStart" value="'.$user_registeredSince.'">
                    </span>
        
                    <span class="td border-end border-activeTable">
                        <select name="userActivated" class="form-select border-0" aria-label="select user group">
                            <option selected>'.$user_activated.'</option>
                            <option value="activated">aktiviert</option>
                            <option value="not activated">nicht aktiviert</option>
                        </select>
                    </span>
                    <span class="td border-end border-activeTable">
                        <select name="userGroup" class="form-select border-0" aria-label="select user group">
                            <option selected>'.$group_title.'</option>';
                            foreach($groups as $row) {
                                $table .="<option value=".$row['id'].">".$row['title']."</option>";
                            }
                    $table .='</select>
                    </span>
                    <span class="td border-end border-activeTable">
                        <button name="updateUser" value="true" class="btn btn-secondary submit">Speichern</button>
                    </span>
                    <span class="td border-end border-activeTable">
                        <button name="deleteUserOverview" type="submit" value="true" class="btn btn-danger submit">Löschen</button>
                    </span>
                </form>';
    }
    $table .= "</div>";
    $result->close();
    $mysqli->close();
    return $table;
}
/*foreach($selectOption as $row) {
                    printf("<option value='%s'>%s</option>", $row['id'], $row['title']);
                }
*/
function getActiveDropdown() {
    $mysqli = connect_DB();
    $stmt1 = $mysqli->prepare("DELETE FROM clanms_user_group WHERE clanms_user_groups.id_user = ?");
    $stmt1->bind_param("i", $userid);
    $stmt1->execute();
    $stmt1->close();
    $mysqli->close();
}

function getUserGroups(){
    $mysqli = connect_DB();
    $select = "SELECT id AS groupId, title FROM clanms_groups";
    $query = $mysqli->query($select,MYSQLI_USE_RESULT);
    $resultArray = $query->fetch_all(MYSQLI_ASSOC);
    $query->close;
    $mysqli->close;
    return $resultArray;
}
?>
<script>    
function confirmDelete() {
  return window.confirm("Are you sure you want to delete this record?");
}
</script>

/* Gallery */
function getGalleriesFromDB() {
    if (session_status() === PHP_SESSION_NONE){session_start();}
    $mysqli = connect_DB();
    $query = "SELECT * FROM clanms_galleries";
    $select = $mysqli->query($query);
    while($row = $select->fetch_assoc()) {
        $card = '<div class="col m-2">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="'.$row['path_thumbnail'].'" alt="'.$row['title'].'" thumbnail">
                <div class="card-body">
                <h5 class="card-title">'.$row['title'].'</h5>
                <p class="card-text">'.$row['description'].'</p>
                <a href="#" class="btn btn-primary">Bearbeiten</a>
                <a href="#" class="btn btn-danger">Löschen</a>
                </div>
            </div>
            </div>';
        echo $card;
    }
    $select->close();
    $mysqli->close();
}

function uploadImage() {
    $errors= array();
    $year = date('Y');
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    
    $extensions= array("jpeg","jpg","png");
    
    if(in_array($file_ext,$extensions)=== false){
       $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }
    
    if($file_size > 2097152){
       $errors[]='File size must be excately 2 MB';
    }
    
    if(empty($errors)==true){
        showToastMessage("Datei wurde hochgeladen...");
       if(move_uploaded_file($file_tmp, __DIR__."/../gallery/images/".$file_name)) {
           showToastMessage("Success!");
       }
    } else {
       print_r($errors);
    }
}
?>
