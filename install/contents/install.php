<?php
    /* Idee: Diese Seite wird als letztes eingebunden, hier werden alle Einstellungen nochmal zur Überprüfung aufgelistet. 
    Button am Ende der Seite dann zum Bestätigen und die Installation wird durchgeführt. */
    function displayCheckCross($bool) {
        if($bool == 1) {
            echo "<p class='text-center text-success'>&check;</p>";
        } else {
            echo "<p class='text-center text-danger'>&cross;</p>";
        }
    }
?>
<h4 class='text-center'>Überprüfung & Abschluss</h4>
<hr/>
<p>Hier kannst du noch einmal alle von dir eingegebenen Daten einsehen.<br/>
Wenn du Änderungen durchführen möchtest, navigiere einfach oben im Header auf die entsprechende Seite.<br/>
Bist du dir sicher, dass alle stimmt, klicke unten auf Installation starten.</p>
<table class="table table-hover border-dark">
  <thead>
    <tr>
      <th scope="col">Einstellung</th>
      <th scope="col">Wert</th>
      <th scope="col">&check; / &cross;</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">DB-Host</th>
      <td><?php echo $dbhost; ?></td>
      <td><?php echo $checkmark = $dbhost != NULL ? displayCheckCross(1) : displayCheckCross(0) ?></td>
    </tr>
    <tr>
      <th scope="row">DB-User</th>
      <td><?php echo $dbuser; ?></td>
      <td><?php echo $checkmark = $dbuser != NULL ? displayCheckCross(1) : displayCheckCross(0) ?></td>
    </tr>
    <tr>
      <th scope="row">DB-Passwort</th>
      <td><?php echo $dbpw; ?></td>
      <td><?php echo $checkmark = $dbpw != NULL ? displayCheckCross(1) : displayCheckCross(0) ?></td>
    </tr>
    <tr>
      <th scope="row">Seitentitel</th>
      <td><?php echo $title; ?></td>
      <td><?php echo $checkmark = $title != NULL ? displayCheckCross(1) : displayCheckCross(0) ?></td>
    </tr>
    <tr>
      <th scope="row">Admin-Account</th>
      <td><?php echo $username; ?></td>
      <td><?php echo $checkmark = $username != NULL ? displayCheckCross(1) : displayCheckCross(0) ?></td>
    </tr>
    <tr>
      <th scope="row">Admin-PW</th>
      <td><?php echo $userpw; ?></td>
      <td><?php echo $checkmark = $userpw != NULL ? displayCheckCross(1) : displayCheckCross(0) ?></td>
    </tr>
  </tbody>
</table>

<!-- Programmlogik ergänzen, Datenbank mit gegebenen Variablen einrichten usw. -->
<form method='post' action=''>
    <div class='row'>
        <div class='btn-group' role='group' aria-label='Basic example'>
            <button type='submit' class='btn btn-primary' name='confirm'>Eingaben bestätigen & Installation starten</button>
        </div>
    </div>
</form>
