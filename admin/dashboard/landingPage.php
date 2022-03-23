<?php if (session_status() === PHP_SESSION_NONE){session_start();} ?>
<div id="dashboardHeader" class="row">
    <div class="col text-center p-3">
        <h2><i class="bi-stars"></i>Willkommen zurück <?php echo $_SESSION['username'] ?>!</h2>
    </div>
</div>
<div class="row">
    <div class="col text-center">
        <p>
            Hier könnte noch mehr Content geladen werden, das könnte so aussehen:
        </p>
        <?php include(__DIR__."/alerts_samples.html"); ?>
    </div>
</div>