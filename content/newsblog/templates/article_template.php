<?php
    
    $displayDate = date_create_from_format("Y-m-d H:i:s", $article_date_published)->format("d.m.Y");
    $displayTime = date_create_from_format("Y-m-d H:i:s", $article_date_published)->format("H:i");
    $commentCount = getCommentsRowCount($article_id);
?>
<link rel="stylesheet" href="./content/newsblog/newsblog_style.css">
<div class="border-black rounded mb-4 p-3 bg-lightdark">
    <div class="border-bottom border-black shadow-sm rounded mb-2 p-2 text-center" style="<?php echo "background: ".$article_color; ?>">
        <h3><?php echo $article_headline; ?><!--<span class="badge bg-highlighted ml-2">New</span>--></h3>
    </div>
    <p>
    <?php echo $article_content; ?>
    </p>
    <hr />
    <p>
        <?php echo $article_name_author." - ".$displayDate." ".$displayTime; ?>
    </p>
    <div class="row">
        <div class="col d-flex justify-content-center">
            <button id="<?php echo $article_id; ?>" onclick="//showComments(this.id);" class="btn w-50 bg-blackened btn-darkmode-outline article-icon fs-6 border-0" title="Kommentare lesen" alt="Kommentare"  data-bs-toggle="collapse" data-bs-target="#<?php echo 'collapse'.$article_id; ?>" aria-expanded="false" aria-controls="<?php echo 'content'.$article_id; ?>"><?php echo $commentCount?> Kommentar(e) </button>
        </div>
    </div>
</div>
<div class="collapse" id="<?php echo 'collapse'.$article_id; ?>">
    <div id="<?php echo 'content'.$article_id; ?>" class="card card-body mb-4 bg-blackened border-0">
        <!-- Kommentare -->
        
        <?php 
        displayCommentForm($article_id);
        showComments($article_id);
        ?>
    </div>
</div>

<script>
var simplemde = new SimpleMDE({
                element: document.getElementById('commentContent'+ <?php echo $article_id?>),
                hideIcons: ['side-by-side', 'fullscreen'],
                

            });

</script>