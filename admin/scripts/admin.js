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

//pagination variables
var saveContent;
var page = 1;

function getNewsBlog(content) {
  saveContent = content;

  var xhttp = new XMLHttpRequest();
  var mainContent = document.getElementById("mainContentWrapper");
  var headline;
  var pageNr;

  xhttp.onload = function() {
    mainContent.innerHTML = this.responseText;

    pageNr = document.getElementById("showPageNr");
    pageNr.innerHTML = "Seite "+page;

    displayHeadline = document.getElementById("headlineDashboardContent");
    displayHeadline.innerHTML = headline;
  }
  switch(content) {
    case 'all':
      xhttp.open("GET", "./newsblog/contentMenu.php?articles=all&page="+page);
      headline = "Newsblog - Alle Artikel";
      break;
    case 'week':
      xhttp.open("GET", "./newsblog/contentMenu.php?articles=week&page="+page);
      headline = "Newsblog - Diese Woche";
      break;
    case 'month':
      xhttp.open("GET", "./newsblog/contentMenu.php?articles=month&page="+page);
      headline = "Newsblog - Dieser Monat";
      break;
    case 'commented':
      xhttp.open("GET", "./newsblog/contentMenu.php?articles=commented&page="+page);
      headline = "Newsblog - Kommentierte Artikel";
      break;
    default:
      xhttp.open("GET", "./newsblog/contentMenu.php?articles=all&page="+page);
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
        uniqueId: "newsContent",
        delay: 1000,
      } 
    });
  }
  xhttp.open("GET", "./newsblog/writeArticle.php?author="+username+"&userid="+userid);
  
  xhttp.send();
  
} 