<?php
    require_once(__DIR__ . "/../scripts/adminfunctions.php");

    function getGamesFromDB(){
        if (session_status() === PHP_SESSION_NONE){session_start();}
        $mysqli = connect_DB();
        $select = "SELECT * FROM clanms_game";
        $result = $mysqli->query($select, MYSQLI_USE_RESULT);
        $table = "<div class='table'>
                    <div class='thead'>
                        <div class='tr mb-2'>
                            <span class='td border-bottom border-dark'>#</span>
                            <span class='td border-bottom border-dark'>Name</span>
                            <span class='td border-bottom border-dark'>Beschreibung</span>
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
                            <input type="hidden" name="userId" value="'.$gameId.'">
                        </span>
                        <span class="td border-end border-activeTable" name="gameTitle">
                            '.$gameTitle.'
                        </span>
                        <span class="td border-end border-activeTable" name="gameDescription">
                            '.$gameDesc.'
                        </span>
                        <span class="td border-end border-activeTable">
                            <button name="editGame" value="true" class"btn btn-secondary submit">Bearbeiten</button>
                        </span>
                    </form>';
                    
        }
        $table .= '</div>';
        $result->close();
        $mysqli->close();
        return $table;
    }
?>