<?php 
    /*
        TODO: 
            Richtige Textformatierung, sowohl das auslesen der Formatierten eingabe als auch das eingeben eines formatierten Textes beim erstellen.
            Außerdem: Generelles Aussehen der Artikelblöcke, mal mit margin und padding ein wenig hübsch machen
            In Zukunft soll es möglich sein, individuell Bilder und andere Dinge die man von herkömmlichen Texteditoren im Web kennt einzufügen.

            Erster Anlauf wäre: Zeilenumbrüche erkennen, darauf aufbauen Absätze erkennen usw. Muss kein perfekter Texteditor sein,
            hauptsache die News sehen halbwegs passabel aus im ersten Release!

            Außerdem: Kategorien, Tags uvm. einfügen bzw. zuweisen können. Ist im Datenbankmodell "verschriftlicht",
            ist allerdings kein muss. Je nach dem was zeitlich hinhaut.
    */
?>
<div class="content mb-4 p-3 bg-lightdark">
    <div class="border-bottom border-dark rounded mb-2 p-2 text-center" style="<?php echo "background: ".$article_color; ?>">
        <h3><?php echo $article_headline; ?><!--<span class="badge bg-highlighted ml-2">New</span>--></h3>
    </div>
    <p>
    <?php echo $article_content; ?>
    </p>
    <hr />
    <p>Article footer - <?php echo "Author: ".$article_name_author." Published: ".$article_date_published; ?>, contact info, tags, categories, etc</p>
</div>
