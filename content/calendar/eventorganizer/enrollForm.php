<hr />
<div class="row p-2">
    <button class="btn text-white" type="button" data-bs-toggle="collapse" data-bs-target="#enrollCollapse<?php echo $row['id']; ?>" aria-expanded="false" aria-controls="collapseExample">
        <i class="bi-caret-down"></i>&nbsp;Mehr Info & Anmeldung
    </button>
</div>
<div class="collapse" id="enrollCollapse<?php echo $row['id']; ?>">
    <div class="col rounded p-2 bg-blackened">
        <p>Anmeldungen: -</p>
        <button class="btn btn-darkmode-outline text-white">Anmelden</button>
        <button class="btn btn-darkmode-outline text-white">Teilnehmerliste</button>
        <button class="btn btn-darkmode-outline text-white">Info</button>
    </div>
</div>