<?php
    require_once(__DIR__."/../../system/db_functions.php");

    function getAllFaq() {
        $mysqli = connect_DB();
        $select = "SELECT * FROM clanms_faq WHERE 1;";
        $result = $mysqli->query($select);
        while($row = $result->fetch_assoc()) {
            include(__DIR__."/faq_template.php");
        }
        $result->close();
        $mysqli->close();
    }
?>