<?php
  $login_form = "<form action='./index.php' method='post'>
                  <div class='mb-3'>
                    <label for='loginEmail' class='form-label'>Email address</label>
                    <input type='email' class='form-control' id='loginEmail' aria-describedby='emailHelp'>
                    <div id='emailHelp' class='form-text'>We'll never share your email with anyone else.</div>
                  </div>
                  <div class='mb-3'>
                    <label for='exampleInputPassword1' class='form-label'>Password</label>
                    <input type='password' class='form-control' id='exampleInputPassword1'>
                  </div>
                  <div class='mb-3 form-check'>
                    <input type='checkbox' class='form-check-input' id='exampleCheck1'>
                    <label class='form-check-label' for='exampleCheck1'>Check me out</label>
                  </div>
                  <input type='submit' class='btn btn-primary' name='loginBtn'>Submit</button>
                </form>";

  echo $login_form;
?>
