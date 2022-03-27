<div class="row p-2">
    <button class="btn btn-darkmode-outline bg-blackened border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#enrollCollapse<?php echo $row['id']; ?>" aria-expanded="false" aria-controls="collapseExample">
        <i class="bi-caret-down"></i>&nbsp;Mehr Info & Anmeldung
    </button>
</div>
<div class="collapse" id="enrollCollapse<?php echo $row['id']; ?>">
    <div class="col rounded p-2 bg-blackened">
        <p>Anmeldungen: -</p>
        <div class="col d-flex justify-content-evenly">
            <button id="<?php echo $eventId; ?>" type="button" class="btn btn-darkmode-outline text-white flex-grow-1 rounded-0 rounded-start" data-bs-toggle="modal" data-bs-target="#loginRegisterModal" onclick="enrollEvent(this.id);">Anmelden</button>
            <button class="btn btn-darkmode-outline text-white flex-grow-1 rounded-0" data-bs-toggle="modal" data-bs-target="#loginRegisterModal" onclick="showEntryList();">Teilnehmerliste</button>
            <button class="btn btn-darkmode-outline text-white flex-grow-1 rounded-0 rounded-end">Info</button>
        </div>
    </div>
</div>

<script>
    function enrollEvent(buttonId) {
        $("#loginRegisterModalLabel").html("Anmelden");
        $("#loginSignupModalBody").html("Hier kann man sich in Zukunft für Events anmelden...");
        $("#loginSignupModalBody").load("./content/calendar/eventorganizer/enrollForm.php?eventId="+buttonId);
    }

    function showEntryList() {
        $("#loginRegisterModalLabel").html("Teilnehmer");
        $("#loginSignupModalBody").html("Hier kann man in Zukunft Teilnehmerlisten einsehen...");
    }

</script>