/* General */
function setActive(buttonID) {
  var button = document.getElementById(buttonID);
  var active = document.getElementsByClassName("active");
  for(let i = 0; i < active.length; i++) {
    active[i].classList.remove("active");
  }
  button.classList.add("active");
}
/* Newsblog */

function getNewsBlog(content) {
  var xhttp = new XMLHttpRequest();
  var mainContent = document.getElementById("mainContentWrapper");
  var headline;

  xhttp.onload = function() {
    mainContent.innerHTML = this.responseText;
    displayHeadline = document.getElementById("headlineDashboardContent");
    displayHeadline.innerHTML = headline;
  }
  switch(content) {
    case 'all':
      xhttp.open("GET", "./newsblog/contentMenu.php?articles=all");
      headline = "Newsblog - Alle Artikel";
      break;
    case 'week':
      xhttp.open("GET", "./newsblog/contentMenu.php?articles=week");
      headline = "Newsblog - Diese Woche";
      break;
    case 'month':
      xhttp.open("GET", "./newsblog/contentMenu.php?articles=month");
      headline = "Newsblog - Dieser Monat";
      break;
    case 'commented':
      xhttp.open("GET", "./newsblog/contentMenu.php?articles=commented");
      headline = "Newsblog - Kommentierte Artikel";
      break;
    default:
      xhttp.open("GET", "./newsblog/contentMenu.php?articles=all");
      headline = "Newsblog - Alle Artikel";
      break;
  }

  xhttp.send();
}

function writeArticle() {
  var xhttp = new XMLHttpRequest();
  var container = document.getElementById("newsBlogContainer");

  xhttp.onload = function() {
    container.innerHTML = this.responseText;

    var simplemde = new SimpleMDE({
      element: document.getElementById("newsContent"),
      autosave: {
        enabled: true,
        uniqueId: "MyUniqueID",
        delay: 1000,
      } 
    });
  }
  xhttp.open("GET", "./newsblog/writeArticle.php?author="+username+"&userid="+userid);
  
  xhttp.send();
  
} 