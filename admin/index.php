<?php
  session_start();
  $userid = $_SESSION['userid'];
  $username = $_SESSION['username'];

  require("../system/dbconnect.php");
  require("../system/functions.php");

  if($username && $userid) {
    if(getUserGroup($userid) <= 2) { // 1 = Admin, 2 = Moderator, alles darüber hat keinen Zugriff. Eventuell bessere (variable) Lösung überlegen!
      // Redirect to Dashboard
      header('Location: ./dashboard.php');
      die();
    } else {
      echo "Nur Administratoren und Moderatoren haben hier zugriff,";
    }
  } else {
    // Display login page
    echo "Bitte logge dich zuerst ein.";
  }
?>