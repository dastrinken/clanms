<?php
    class Installer{
        public $step = 1;
        public $allsteps = 5;
        public $steps = null;
        public $params = null;
        private $systemcheck = true;
        private $doc = null;

        public function __construct() {
            $this->doc = new DOMDocument();
            $this->addWelcomePage();
            $this->addDbSettings();
            $this->addHomepageSettings();
            $this->addSystemCheck();
            $this->addAuth();
            $this->allsteps = sizeof($this->steps);
        }

        public function validateCurrentStep() {
            return true;
        }

        public function getHeadline() {
            return $this->steps[$this->step-1]['headline'];
        }

        public function getContent() {
            $display = $this->steps[$this->step-1]['content'];
            if($_POST['dbSettings'] == true) {
                $this->params[2]['host']     = $_POST['dbhost'];
                $this->params[2]['database'] = $_POST['dbname'];
                $this->params[2]['user']     = $_POST['dbuser'];
                $this->params[2]['password'] = $_POST['dbpw'];

                $this->doc->loadHTML($this->steps[3]['content']);
                $phpv = $this->doc->getElementById("php_check");
                $dbc = $this->doc->getElementById("db_check");

                $checkOk = $this->doc->createElement("td", "O.k. ");
                $checkOk->setAttribute("class", "conform");
                $iconOk = $this->doc->createElement("i", "");
                $checkOk->appendChild($iconOk);
                $iconOk->setAttribute("class", "bi-check2-square");

                $checkFalse = $this->doc->createElement("td", "Not O.k. ");
                $checkFalse->setAttribute("class", "conflict");
                $iconFalse = $this->doc->createElement("i", "");
                $checkFalse->appendChild($iconFalse);
                $iconFalse->setAttribute("class", "bi-exclamation-square");

                if(substr(phpversion(), 0, 1) >= 7) {
                    $phpv->replaceChild(clone $checkOk, $phpv->lastChild);
                } else {
                    $phpv->replaceChild(clone $checkFalse, $phpv->lastChild);
                }
                if($mysqli = mysqli_connect($this->params[2]['host'], $this->params[2]['user'], $this->params[2]['password'], $this->params[2]['database'])) {
                    $dbc->replaceChild(clone $checkOk, $dbc->lastChild);
                } else {
                    $dbc->replaceChild(clone $checkFalse, $dbc->lastChild);
                }
                $this->steps[3]['content'] = $this->doc->saveHTML();
            }
            if($_POST['hpSettings'] == true) {
                $this->params[3]['pageTitle'] = $_POST['pageTitle'];
                $this->params[3]['username'] = $_POST['username'];
                $this->params[3]['userpw'] = $_POST['userpw'];
            }

            if($this->params[$this->step]) {
                foreach($this->params[$this->step] as $name=>$value) {
                    $display = str_replace("{".$name."}", $value, $display);
                }
            }
            return $display;
        }

        public function showReturnButton() {
            return $this->step > 1 and $this->step != $this->allsteps;
        }

        public function showFwdButton() {
            return $this->step < $this->allsteps-1;
        }

        public function showFinalButton() {
            return $this->step == $this->allsteps-1;
        }

        private function addWelcomePage() {
            $step['headline'] = 'Willkommen';
            $step['content'] = '<figure class="text-center">
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
                      <dt class="col col-lg-3">Vorraussetzungen</dt>
                      <dd class="col">Webserver (z.B. Apache2) mit eingerichteter Datenbank und <abbr title="Optional, jedoch eindrücklich empfohlen um alle Funktionen nutzen zu können!">Mailserver</abbr></dd>
                  </div>
                  <div class="row justify-content-md-center">
                      <dt class="col col-lg-3">Zugangsdaten</dt>
                      <dd class="col">Halte bitte deine Zugangsdaten für deine Datenbank bereit (Nutzername, Passwort).</dd>
                  </div>
                  <div class="row justify-content-md-center">
                      <dt class="col col-lg-3">Datenbank</dt>
                      <dd class="col">Alle gängigen Datenbanksysteme sollten unser System unterstützen.<br/>
                      Dennoch an dieser Stelle als Hinweis:<br/>
                      Das System wurde auf einer <abbr title="Es gibt keine Garantie, dass ClanMS auf anderen Systemen problemfrei läuft.">MySQL / MariaDB</abbr> entwickelt.<br/>
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
                      <a href="https://github.com/dastrinken/clanms" target="_blank"><i class="bi-github" width="24" height="24"></i>GitHub</a></dd>
                  </div>
              </dl>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="licenceModal" tabindex="-1" aria-labelledby="licenceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg text-dark">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="licenceModalLabel">ClanMS - Licence</h3>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>ClanMS - A free Content Management System for gaming communities and everyone else.<br/>
                  Copyright (C) 2022  Armin Prinz, Silas Waldschmidt, Angela Rutkowski, Irina Imranov, Rayan Ahmed Bhatti, Sven Kwiatkowski</p>
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
          </div>';
            $this->steps[] = $step;
        }

        private function addSystemCheck() {
            $step['headline'] = 'Systemcheck';
            $step['content'] = '<div class="d-flex flex-column justify-content-center align-items-center">
                                <p>Hier siehst du, ob dein System den Mindestanforderungen entspricht:</p>
                                <table class="table table-dark table-hover">
                                    <tr id="php_check">
                                        <td>PHP-Version</td>
                                    </tr>
                                    <tr id="db_check">
                                        <td>Datenbankverbindung</td>
                                    </tr>
                                </table>
                            </div>';
            $this->steps[] = $step;
        }

        private function addDbSettings() {
            $step['headline'] = 'Datenbank';
            $step['content']  = "<h4 class='text-center'>Datenbankzugang</h4>
                                    <hr/>
                                    <p>Trage hier deine Zugangsdaten ein. ClanMS wird automatisch die benötigten Tabellen in deiner Datenbank erstellen.<br/>
                                    Falls du Hilfe benötigst, folge den Hinweisen oder besuche unser GitHub-Wiki.</p>
                                    <input type='hidden' name='dbSettings' value ='true'>
                                    <div class='input-group mb-3'>
                                        <span class='input-group-text' id='hostname'><abbr title='Normalerweise localhost, nur ändern wenn du dir wirklich sicher bist!'>Hostname</span>
                                        <input type='text' class='form-control' value='{host}' aria-label='Hostname' aria-describedby='hostname' name='dbhost'>
                                    </div>
                                    <div class='input-group mb-3'>
                                        <span class='input-group-text' id='dbname'><abbr title='Der Name der Datenbank, die ClanMS nutzen soll.'>Datenbank</span>
                                        <input type='text' class='form-control' placeholder='Name der Datenbank, die ClanMS nutzen soll' value='{database}' aria-label='Hostname' aria-describedby='dbname' name='dbname'>
                                    </div>
                                    <div class='input-group mb-3'>
                                        <span class='input-group-text' id='username'><abbr title='Dein Datenbank Benutzername'>DB-Nutzer</span>
                                        <input type='text' class='form-control' placeholder='Dein Benutzername (Datenbank Login)' value='{user}' aria-label='Username' aria-describedby='username' name='dbuser'>
                                    </div>
                                    <div class='input-group mb-3'>
                                        <span class='input-group-text' id='password'><abbr title='Dein Datenbank Passwort'>DB-Passwort</span>
                                        <input type='password' class='form-control' placeholder='Dein Passwort (Datenbank Login)' value='{password}' aria-label='Password' aria-describedby='password' name='dbpw'>
                                    </div>";
            $this->params[2]['host']     = 'localhost';
            $this->params[2]['database'] = '';
            $this->params[2]['user']     = '';
            $this->params[2]['password'] = '';
            $this->steps[] = $step;
        }

        private function addHomepageSettings() {
            $step['headline'] = 'Homepage';
            $step['content'] = "<h4 class='text-center'>Einstellungen</h4>
                                <hr/>
                                <p>Die Zugangsdaten, die du hier einträgst, gelten für den Betreiber-Account der Webseite.<br/>
                                Sie sind also auch deine Anmeldedaten nach der Installation, bewahre sie sicher auf!<br/>
                                <i>(Die Daten kannst du nachher jederzeit im Adminbereich deiner Seite ändern.)</i><br/>
                                Falls du Hilfe benötigst, folge den Hinweisen oder besuche unser GitHub-Wiki.</p>
                                <input type='hidden' name='hpSettings' value='true'>
                                <div class='input-group mb-3'>
                                    <span class='input-group-text' id='pageTitle'><abbr title='Der Titel deiner öffentlichen Seite (z.B. Name deines Clans)'>Seitentitel</span>
                                    <input type='text' class='form-control' placeholder ='Titel der Seite' value='{pageTitle}' aria-label='PageTitle' aria-describedby='pageTitle' name='pageTitle'>
                                </div>
                                <div class='input-group mb-3'>
                                    <span class='input-group-text' id='loginName'><abbr title='Der Name, mit dem du dich im System einloggen wirst'>Login-Name</span>
                                    <input type='text' class='form-control' placeholder='Dein Nutzername für den Admin-Account' value='{username}' aria-label='LoginName' aria-describedby='loginName' name='username'>
                                </div>
                                <div class='input-group mb-3'>
                                    <span class='input-group-text' id='password'><abbr title='Das Passwort für deinen Admin-Account'>Login-Passwort</span>
                                    <input type='password' class='form-control' placeholder='Dein Passwort (Admin Login)' value='{userpw}' aria-label='Password' aria-describedby='password' name='userpw'>
                                </div>
                                <div class='input-group mb-3'>
                                    <span class='input-group-text' id='password'><abbr title='Wiederhole das eingegebene Passwort'>Passwort wdh.&nbsp;&nbsp;</span>
                                    <input type='password' class='form-control' placeholder='Wiederhole das Passwort' value='{userpw}' aria-label='Password' aria-describedby='password'>
                                </div>";
            $this->params[3]['pageTitle'] = 'ClanMS';
            $this->params[3]['username'] = 'admin';
            $this->params[3]['userpw'] = '1234';
            $this->steps[] = $step;
        }

        private function addAuth(){
            $step['headline'] = 'Authentifizierung';
            $step['content']  = 'Authentifizierung';
            $this->steps[] = $step;
        }
    }

?>