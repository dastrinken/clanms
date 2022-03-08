function showNewsblogDashboard() {
  var content = document.getElementById("mainContentWrapper");
  var headline = document.getElementById("headlineDashboardContent");
  headline.innerHTML = "Newsblog";
  getContentPhp("newsblog");
  /* TODO:
  ** Content austauschen. Der innere Teil soll erstezt werden durch eine Ansicht aller bisherigen Artikel (Ordnerinhalt auflisten)
  ** Diese Artikel sollen bearbeitet werden können.
  ** Buttons erstellen für: Neuen Artikel schreiben, Bearbeiten, Löschen usw.
  ** Gerne weitere Ideen sammeln und erstmal hier aufschreiben!
  */
}


function getContentPhp(content) {
  var xhttp = new XMLHttpRequest();
  var mainContent = document.getElementById("mainContent");

  xhttp.onload = function() {
    mainContent.innerHTML = this.responseText;
  }
  if(content == "newsblog") {
      xhttp.open("GET", "./newsblog/overview.php");
  } 

  xhttp.send();
}