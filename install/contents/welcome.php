<figure class="text-center">
  <blockquote class="blockquote">
    <img class="bi" src="../ressources/icons/clanms_logo.svg" width="140" height="100" alt="ClanMS"></img>
  </blockquote>
  <figcaption class="blockquote-footer">
    Das Content-Management-System für Spieler
  </figcaption>
</figure>
<hr>
<div class="d-flex flex-column justify-content-center align-items-center">
    <h5 class="text-center">Herzlich Willkommen</h5>
    <p>Vielen Dank, dass du dich für die Nutzung unseres Systems entschieden hast!<br/>
    Bevor du loslegst, stelle bitte sicher, dass du folgende Dinge beachtest:
    </p>
    <dl>
        <div class="row justify-content-md-center">
            <dt class="col col-lg-3">Zugangsdaten</dt>
            <dd class="col">Halte bitte deine Zugangsdaten für deine Datenbank bereit (Nutzername, Passwort).</dd>
        </div>
        <div class="row justify-content-md-center">
            <dt class="col col-lg-3">Datenbank</dt>
            <dd class="col">Alle gängigen Datenbanksystem sollten unser System unterstützen.<br/>
            Dennoch an dieser Stelle als Hinweis:<br/>
            Das System wurde auf einer MySQL / MariaDB entwickelt.<br/>
            (10.6.7-MariaDB-1:10.6.7+maria~focal - mariadb.org binary distribution)</dd>
        </div>
        <div class="row justify-content-md-center">
            <dt class="col col-lg-3">Rechtliche Hinweise</dt>
            <dd class="col">Das System gilt als freie Software und verwendet die <abbr title="GNU General Public License">GNU-GPL</abbr><br/>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#licenceModal">
            Lizenz anzeigen
            </button>
        </div>
        <div class="row justify-content-md-center">
            <dt class="col col-lg-3">Probleme</dt>
            <dd class="col">Solltest du einmal nicht weiterkommen oder ein Problem entdecken, kannst du dich jederzeit an uns wenden:
            <a href='https://github.com/dastrinken/clanms' target='_blank'><img class='bi' src='../bootstrap/bootstrap-icons-1.8.0/github.svg' width='24' height='24'></img>GitHub</a></dd>
        </div>
    </dl>
</div>

<!-- Formular zum starten der Installation -->
<form method='post' action=''>
    <div class='row'>
        <div class='btn-group' role='group' aria-label='Basic example'>
            <button type='submit' class='btn btn-primary' name='start'>Installation starten</button>
            <button type='submit' class='btn btn-primary' name='destroy'>Session Destroy -> remove before release!</button>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="licenceModal" tabindex="-1" aria-labelledby="licenceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg text-dark">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="licenceModalLabel">GNU-GPL</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5>This file is part of ClanMS.</h5>

        <p>
        ClanMS is free software: you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation, either version 3 of the License, or
        (at your option) any later version.
        </p>

        <p>
        ClanMS is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.
        </p>

        <p>
        You should have received a copy of the GNU General Public License
        along with ClanMS.  If not, see <a href="http://www.gnu.org/licenses/" target="_blank">http://www.gnu.org/licenses/</a>.
        </p>
        <hr/>
        <h5>Diese Datei ist Teil von ClanMS.</h5>
        <p>
        ClanMS ist Freie Software: Sie können es unter den Bedingungen
        der GNU General Public License, wie von der Free Software Foundation,
        Version 3 der Lizenz oder (nach Ihrer Wahl) jeder neueren
        veröffentlichten Version, weiter verteilen und/oder modifizieren.
        </p>
        <p>
        ClanMS wird in der Hoffnung, dass es nützlich sein wird, aber
        OHNE JEDE GEWÄHRLEISTUNG, bereitgestellt; sogar ohne die implizite
        Gewährleistung der MARKTFÄHIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK.
        Siehe die GNU General Public License für weitere Details.
        </p>
        <p>
        Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
        Programm erhalten haben. Wenn nicht, siehe <a href="http://www.gnu.org/licenses/" target="_blank">http://www.gnu.org/licenses/</a>.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>