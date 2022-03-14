

<?php
    echo "Hier entsteht die Bildergalerie";
    /* Idee: Datenbank gibt an, welche Bilder existieren und wie sie dargestellt werden (bootstrap carousel oder cards)
            Für Erstinbetriebnahme sollen beispielhaft alle Möglichkeiten dargestellt werden. 
            Also includen wir beides und laden ein paar Beispielbilder hoch.
    */
?>
<div class="row">
    <div class="col">
        <?php include(__DIR__."/galleryframe.php"); ?>
    </div>
</div>
