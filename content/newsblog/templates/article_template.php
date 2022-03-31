<?php
?>
<link rel="stylesheet" href="./content/newsblog/newsblog_style.css">
<div class="content mb-4 p-3 bg-lightdark">
    <div class="border-bottom border-dark rounded mb-2 p-2 text-center" style="<?php echo "background: ".$article_color; ?>">
        <h3><?php echo $article_headline; ?><!--<span class="badge bg-highlighted ml-2">New</span>--></h3>
    </div>
    <p>
    <?php echo $article_content; ?>
    </p>
    <hr />
    <p>
        Article footer - <?php echo "Author: ".$article_name_author." Published: ".$article_date_published; ?>, contact info, tags, categories, etc
    </p>
        <ul class="col-md-20 justify-content-end list-unstyled d-flex">
            <li>
                <a href="#" Title="Kommentare lesen" alt="Kommentare"><i class="bi-chat-text article-icon"></i></a> | <a href="#" Title="Kommentar schreiben" alt="Kommentar schreiben"><i class="bi-pencil-square article-icon"></i></a> | <a href="#" title="Beitrag löschen" alt="Beitrag löschen"><i class="bi-trash3-fill article-icon"></i></a> | <a href="#" title="anpinnen" alt="Beitrag anpinnen"><i class="bi-pin-angle article-icon"></i></a>
             </li>
        </ul>
</div>
