<form method="post">
    <div class="d-flex mb-3">
        <div class="input-group me-2">
            <span class="input-group-text" id="ariaLabelTitle">Titel</span>
            <input id="newsTitle" class="form-control" type="text" aria-describedby="ariaLabelTitle" name="title" placeholder="Bitte Titel eingeben">
        </div>
        <div class="input-group w-25">
            <span class="input-group-text" id="ariaLabelTitleColor">Farbe</span>
            <input type="color" class="form-control form-control-color" id="exampleColorInput" name="color" value="#dc3545" aria-describedby="ariaLabelTitleColor"  title="Choose your color">
        </div>
    </div>
    <div id="" class="mb-3">
        <label for="newsContent" class="form-label">Inhalt</label>
        <textarea class="form-control" id="newsContent" name="content" rows="15"></textarea>
    </div>
    <div class="d-flex mb-3">
        <div class="input-group w-auto me-2">
            <span class="input-group-text" id="ariaLabelAuthor">Author</span>
            <input class="form-control" type="text" name="author" value="<?php echo $_GET['author']; ?>" aria-describedby="ariaLabelAuthor" readonly>
        </div>

        <div class="input-group w-auto me-2">
            <span class="input-group-text" id="ariaLabelDate">Datum</span>
            <input class="form-control" type="text" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>" aria-describedby="ariaLabelDate" readonly>
        </div>

        <div class="input-group w-auto me-2">
            <span class="input-group-text" id="ariaLabelPublish">Veröffentlichung</span>
            <input class="form-control" type="text" name="publish" value="<?php echo date('Y-m-d H:i:s'); ?>" aria-describedby="ariaLabelPublish">
        </div>

        <input type="hidden" name="userid" value="<?php echo $_GET['userid']; ?>">

        <button id="saveArticle" class="form-control submit w-25" name="saveArticle" value="save">Speichern</button>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
    var simplemde = new SimpleMDE({ element: document.getElementById("newsContent") });
    console.log("Test");
</script>