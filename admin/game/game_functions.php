<?php
    require_once(__DIR__ . "/../scripts/adminfunctions.php");

    function getGamesFromDB(){
        if (session_status() === PHP_SESSION_NONE){session_start();}
        global $pages;
        $mysqli = connect_DB();
        global $totalPages;
        $displayAmount = 10;
        $page = $_GET['page'];

        $offset = ($page - 1) * $displayAmount;
        $totalPagesDB = "SELECT * FROM clanms_user AS user";
        $pagesResult = $mysqli->query($totalPagesDB);
        $rowCount = $pagesResult->num_rows;
        $totalPages = ceil($rowCount / $displayAmount);
        $pagesResult->close();
        $mysqli = connect_DB();
        $select = "SELECT * FROM clanms_game";
        $result = $mysqli->query($select, MYSQLI_USE_RESULT);
        $table = "<div class='table'>
                    <div class='thead'>
                        <div class='tr mb-2'>
                            <span class='td border-bottom border-dark'>#</span>
                            <span class='td border-bottom border-dark'>Name</span>
                            <span class='td border-bottom border-dark'>Beschreibung</span>
                            <span class='td border-bottom border-dark'></span>
                            <span class='td border-bottom border-dark'></span>
                        </div>
                    </div>
                    <div class='tbody'>";
        $count = 0;
        while($row = $result->fetch_assoc()) {
            ++$count;
            $gameTitle = $row["title"];
            $gameDesc = $row["description"];
            $gameId = $row["id"];
            $table .= '<form class="tr activeTable">
                        <span class="td border-end border-activeTable">
                        '.(/*$offset+*/$count).'
                            <input type="hidden" name="gameId" value="'.$gameId.'">
                        </span>
                        <span class="td border-end border-activeTable" name="gameTitle">
                            '.$gameTitle.'
                            <input type="hidden" name="gameTitle" value="'.$gameTitle.'">
                        </span>
                        <span class="td border-end border-activeTable" name="gameDescription">
                            '.$gameDesc.'
                            <input type="hidden" name="gameDesc" value="'.$gameDesc.'">
                        </span>';
                        if(checkPermission("game",false)){
                            $table.='<span class="td border-end border-activeTable">
                                        <button name="editGame" value="true" class="btn btn-secondary submit">Bearbeiten</button>   
                                    </span>
                                    <span class="td border-end border-activeTable">
                                        <button name="deleteGame" type="submit" value="true" class="btn btn-danger submit" onclick="return confirm(\'Das Spiel wird endgültig aus der Datenbank gelöscht, bist du dir sicher?\');">Löschen</button>
                                    </span>';
                        }
                        $table.='</form>';
                    
        }
        $table .= '</div>';
        $result->close();
        $mysqli->close();
        return $table;
    }

    function deleteGameFromDB($gameId){
        if (session_status() === PHP_SESSION_NONE){session_start();}
        $mysqli = connect_DB();
        $stmt = $mysqli->prepare("DELETE FROM clanms_game WHERE clanms_game.id = ?");
        $stmt->bind_param("i", $gameId);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    }

    function writeGameToDB($editExisting){
        $gameTitle = $_POST['gameTitle'];
        $gameDesc = $_POST['gameDesc'];
        $mysqli = connect_DB();
        if($editExisting === 'true'){
            $gameId = $_POST['gameId'];
            $stmt = $mysqli->prepare("UPDATE clanms_game SET title = ? description = ? WHERE id = ?");
            $stmt->bind_param("ssi", $gameTitle, $gameDesc, $gameId);
        }else{
            $stmt = $mysqli->prepare("INSERT INTO clanms_game(title, description)VALUES(?,?)");
            $stmt->bind_param("ss", $gameTitle, $gameDesc);
        }
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    }   
    
?>