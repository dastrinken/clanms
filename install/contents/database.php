<form action='' method='post'>
    <h4 class='text-center'>Datenbankzugang</h4>
    <hr/>
    <p>Trage hier deine Zugangsdaten ein. ClanMS wird automatisch die benötigten Tabellen in deiner Datenbank erstellen.<br/>
    Falls du Hilfe benötigst, folge den Hinweisen oder besuche unser GitHub-Wiki.</p>
    <div class='input-group mb-3'>
        <span class='input-group-text' id='hostname'><abbr title='Normalerweise localhost, nur ändern wenn du dir wirklich sicher bist!'>Hostname</span>
        <input type='text' class='form-control' value='localhost' aria-label='Hostname' aria-describedby='hostname' name='dbhost'>
    </div>
    <div class='input-group mb-3'>
        <span class='input-group-text' id='username'><abbr title='Dein Datenbank Benutzername'>DB-Nutzer</span>
        <input type='text' class='form-control' placeholder='Dein Benutzername (Datenbank Login)' value='<?php echo $dbuser; ?>' aria-label='Username' aria-describedby='username' name='dbuser'>
    </div>
    <div class='input-group mb-3'>
        <span class='input-group-text' id='password'><abbr title='Dein Datenbank Passwort'>DB-Passwort</span>
        <input type='password' class='form-control' placeholder='Dein Passwort (Datenbank Login)' value='<?php echo $dbpw ?>' aria-label='Password' aria-describedby='password' name='dbpw'>
    </div>
    <div class='btn-group' role='group' aria-label='next-step'>
            <button type='submit' class='btn btn-primary' name='admin'>Nächster Schritt</button>
    </div>
</form>