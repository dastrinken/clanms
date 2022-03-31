<?php 
require_once(__DIR__."/../scripts/adminfunctions.php");
if(checkPermission('game', false)){
    if($editing) {
        $gameId = $_GET['gameId'];
        $gameTitle = $_GET['gameTitle'];
        $gameDesc = $_GET['gameDesc'];

        echo "<h2 class='text-center mt-2'>Spiel bearbeiten</h2>";
    } else {
        echo "<h2 class='text-center mt-2'>Neues Spiel</h2>";
    }
    include(__DIR__."/createGameForm.php");
}else {
    echo "<p>Dir fehlen die nötigen Berechtigungen hierfür...</p>";
}

?>
