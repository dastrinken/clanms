<form action='' method='post'>
    <h4 class='text-center'>Einstellungen</h4>
    <hr/>
    <p>Die Zugangsdaten, die du hier einträgst, gelten für den Betreiber-Account der Webseite.<br/>
    Sie sind also auch deine Anmeldedaten nach der Installation, bewahre sie sicher auf!<br/>
    <i>(Die Daten kannst du nachher jederzeit im Adminbereich deiner Seite ändern.)</i><br/>
    Falls du Hilfe benötigst, folge den Hinweisen oder besuche unser GitHub-Wiki.</p>
    <div class='input-group mb-3'>
        <span class='input-group-text' id='pageTitle'><abbr title='Der Titel deiner öffentlichen Seite (z.B. Name deines Clans)'>Seitentitel</span>
        <input type='text' class='form-control' placeholder ='Titel der Seite' value='<?php echo $title ?>' aria-label='PageTitle' aria-describedby='pageTitle' name='pageTitle'>
    </div>
    <div class='input-group mb-3'>
        <span class='input-group-text' id='loginName'><abbr title='Der Name, mit dem du dich im System einloggen wirst'>Login-Name</span>
        <input type='text' class='form-control' placeholder='Dein Nutzername für den Admin-Account' value='<?php echo $username ?>' aria-label='LoginName' aria-describedby='loginName' name='username'>
    </div>
    <div class='input-group mb-3'>
        <span class='input-group-text' id='password'><abbr title='Das Passwort für deinen Admin-Account'>Login-Passwort</span>
        <input type='password' class='form-control' placeholder='Dein Passwort (Admin Login)' value='<?php echo $userpw ?>' aria-label='Password' aria-describedby='password' name='userpw'>
    </div>
    <div class='input-group mb-3'>
        <span class='input-group-text' id='password'><abbr title='Wiederhole das eingegebene Passwort'>Passwort wdh.&nbsp;&nbsp;</span>
        <input type='password' class='form-control' placeholder='Wiederhole das Passwort' value='<?php echo $userpw ?>' aria-label='Password' aria-describedby='password'>
    </div>
    <div class='btn-group' role='group' aria-label='next-step'>
            <button type='submit' class='btn btn-primary' name='install'>Nächster Schritt</button>
    </div>
</form>

<script>
    
</script>