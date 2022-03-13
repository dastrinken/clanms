<?php
  session_start();

  require(__DIR__."/../system/dbconnect.php");
  require(__DIR__."/../system/functions.php");

  if($_SESSION['username'] && $_SESSION['userid']) {
    if(getUserGroup($_SESSION['userid']) <= 2) { // 1 = Admin, 2 = Moderator, alles darüber hat keinen Zugriff. Eventuell bessere (variable) Lösung überlegen!
      // Redirect to Dashboard
      header('Location: ./dashboard.php');
      die();
    } else {
      echo "Nur Administratoren und Moderatoren haben hier zugriff,";
    }
  } else {
    // Display login page TEST. Bisher nur ein echo, eine richtige Login-Page für direkten Zugriff auf den Adminbereich wäre schön!
    echo "Bitte logge dich zuerst ein.";
  }
?>