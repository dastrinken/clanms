<div class="row p-2">
    <button class="btn text-white" type="button" data-bs-toggle="collapse" data-bs-target="#enrollCollapse<?php echo $row['id']; ?>" aria-expanded="false" aria-controls="collapseExample">
        <i class="bi-caret-down"></i>&nbsp;Mehr Info & Anmeldung
    </button>
</div>
<div class="collapse" id="enrollCollapse<?php echo $row['id']; ?>">
    <div class="col rounded p-2 bg-blackened">
        <p>Anmeldungen: -</p>
        <button id="<?php echo $eventId; ?>" type="button" class="btn btn-darkmode-outline text-white" data-bs-toggle="modal" data-bs-target="#loginRegisterModal" onclick="enrollEvent(this.id);">Anmelden</button>
        <button class="btn btn-darkmode-outline text-white" data-bs-toggle="modal" data-bs-target="#loginRegisterModal" onclick="showEntryList();">Teilnehmerliste</button>
        <button class="btn btn-darkmode-outline text-white">Info</button>
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