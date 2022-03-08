<?php
  $login_form = "<form action='./' method='post'>
                  <div class='mb-3'>
                    <label for='loginEmail' class='form-label'>Email address</label>
                    <input type='email' class='form-control' id='loginEmail' aria-describedby='emailHelp' name='email'>
                    <div id='emailHelp' class='form-text'>We'll never share your email with anyone else.</div>
                  </div>
                  <div class='mb-3'>
                    <label for='loginPassword' class='form-label'>Password</label>
                    <input type='password' class='form-control' id='loginPassword' name='password'>
                  </div>
                  <div class='mb-3 form-check'>
                    <input type='checkbox' class='form-check-input' id='permaLogin'>
                    <label class='form-check-label' for='permaLogin'>Eingeloggt bleiben</label>
                  </div>
                  <input type='submit' class='btn btn-primary sendbtn' name='loginBtn'></input>
                </form>";

  echo $login_form;
?>
