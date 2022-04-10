
<div class="row p-2">
    <button class="btn btn-darkmode-outline bg-blackened border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#enrollCollapse<?php echo $row['id']; ?>" aria-expanded="false" aria-controls="collapseExample">
        <i class="bi-caret-down"></i>&nbsp;Mehr Info & Anmeldung
    </button>
</div>
<div class="collapse" id="enrollCollapse<?php echo $row['id']; ?>">
    <div class="col rounded p-2 bg-blackened">
        <div class="col d-flex justify-content-evenly">
            <?php  
            if(getEnrollment($_SESSION['userid'], $eventId)){
                echo '<button type="button" class="btn btn-darkmode-outline text-white flex-grow-1 rounded-0 rounded-start" data-bs-toggle="modal" data-bs-target="#loginRegisterModal" onclick="withdrawEvent('.$eventId.');">Abmelden</button>';
            }else{
                echo '<button type="button" class="btn btn-darkmode-outline text-white flex-grow-1 rounded-0 rounded-start" data-bs-toggle="modal" data-bs-target="#loginRegisterModal" onclick="enrollEvent('.$eventId.');">Anmelden</button>';
            }
            ?>
            <button class="btn btn-darkmode-outline text-white flex-grow-1 rounded-0 rounded-end" data-bs-toggle="modal" data-bs-target="#loginRegisterModal" onclick="showEntryList(<?php echo $eventId; ?>);">Teilnehmerliste</button>
        </div>
    </div>
</div>

<script>

    function reloadContent(){
        $(function() {
            $('#mainContent').load(document.URL +  ' #calendarContent', function() {
                $.getScript("./content/calendar/calendar_basic.js");
            });
        });
    }
    function enrollEvent(eventId) {
        $(function() {
            $("#loginRegisterModalLabel").html("Anmelden");
            $("#loginSignupModalBody").html("Hier kann man sich in Zukunft für Events anmelden...");
            $("#loginSignupModalBody").load("./content/calendar/eventorganizer/enrollEvent.php?eventId="+eventId);
        })
        reloadContent();
    }
    
    function withdrawEvent(eventId) {
        $(function() {
            $("#loginRegisterModalLabel").html("Abmelden");
            $("#loginSignupModalBody").html("Hier kann man sich in Zukunft von Events abmelden...");
            $("#loginSignupModalBody").load("./content/calendar/eventorganizer/withdraw.php?eventId="+eventId); 
        })
        reloadContent();
    }

    function showEntryList(eventId) {
        $(function() {
            $("#loginRegisterModalLabel").html("Teilnehmer");
            $("#loginSignupModalBody").html("Hier kann man in Zukunft Teilnehmerlisten einsehen...");
            $("#loginSignupModalBody").load("./content/calendar/eventorganizer/list.php?eventId="+eventId);
        })
    }
</script>