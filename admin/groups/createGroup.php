<?php
require_once(__DIR__."/../scripts/adminfunctions.php");
if(checkPermission('group',false)){
    include(__DIR__."/createGroupForm.php");
}else {
    echo "<p>Dir fehlen die nötigen Berechtigungen hierfür...</p>";
}
?>