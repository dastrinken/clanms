<?php
  session_start();
  require_once(__DIR__."/scripts/adminfunctions.php");

  if($_SESSION['username'] && $_SESSION['userid']) {
    if(checkPermission("admindashboard", false)) {
      // Redirect to Dashboard
      header('Location: ./dashboard.php');
      die();
    } else {
      echo "Du hast hierauf leider keinen Zugriff.";
    }
  } else {
    // Display login page TEST. Bisher nur ein echo, eine richtige Login-Page für direkten Zugriff auf den Adminbereich wäre schön!
    echo "Bitte logge dich zuerst ein.";
  }
?>