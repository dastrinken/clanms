<div class ='col calendar-event mb-2 p-2 bg-lightdark rounded'>
    <!-- HEAD -->
    <div class='row d-flex align-content-center text-center bg-blackened m-1 p-1 rounded'>
        <h4><?php echo $optionalText,$row['title']; ?></h4>
    </div>
    <!-- CONTENT -->
    <div class='row'>
        <div class='col d-flex justify-content-center align-items-center'>
            <?php getCategoryImage($row['event_cat'], 128, 1); ?>
        </div>
        <div class='col flex-grow-1'>
            <hr/>
            <div class='row p-2'>
                <?php echo $row['start']; ?>
            </div>
            <div class='row p-2'>
                <?php echo $row['description']; ?>
            </div>
        </div>
    </div>
    <!-- FOOTER -->
    <?php if($_SESSION['userid'] && $_SESSION['username']) {
        include(__DIR__."/enrollForm.php");
    } ?>
</div>