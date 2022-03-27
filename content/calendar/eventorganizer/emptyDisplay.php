<div class ='col mb-2 p-2 bg-lightdark rounded'>
    <!-- HEAD -->
    <div class='row d-flex align-content-center text-center bg-blackened m-1 p-1 rounded'>
        <h4>Nichts geplant...</h4>
    </div>
    <!-- CONTENT -->
    <div class='row'>
        <div class='col d-flex justify-content-center align-items-center'>
            <img src="./ressources/images/empty.png" class="rounded-circle" width="128px" height="128px">
        </div>
        <div class='col flex-grow-1'>
            <hr/>
            <div class='row p-2'>
                <pre><?php echo date("d.m.Y"); ?></pre>
            </div>
            <div class='row p-2'>
                <?php 
                    if(!empty($allEvents)) {
                        echo "<p>Es stehen aktuell keine Events an.</p>";
                    } else {
                        echo "<p>Noch gibt es keine Events, trage das erste Event im Admin-Dashboard ein, und es wird dir hier angezeigt werden.</p>";
                    }
                ?>
            </div>
        </div>
    </div>
    <hr/>
    <!-- FOOTER -->
</div>