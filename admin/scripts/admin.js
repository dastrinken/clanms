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
var saveDisplay;
var saveContent;
var page = 1;

function getTableView(content, displayOption) {
  saveContent = content;
  saveDisplay = displayOption;

  var xhttp = new XMLHttpRequest();
  var mainContent = document.getElementById("mainContentWrapper");
  var headline;
  var pageNr;

  xhttp.onload = function() {
    mainContent.innerHTML = this.responseText;

    pageNr = document.getElementById("showPageNr");
    pageNr.innerHTML = "Seite "+page;

    displayHeadline = document.getElementById("headlineDashboardContent");
    displayHeadline.innerHTML = headline.charAt(0).toUpperCase() + headline.slice(1);
  }

  switch(displayOption) {
    case 'all':
      xhttp.open("GET", "./"+content+"/content.php?displayOption="+displayOption+"&page="+page);
      headline = saveContent+" - Gesamt";
      console.log(headline);
      break;
    case 'week':
      xhttp.open("GET", "./"+content+"/content.php?displayOption="+displayOption+"&page="+page);
      headline = saveContent+" - Diese Woche";
      break;
    case 'month':
      xhttp.open("GET", "./"+content+"/content.php?displayOption="+displayOption+"&page="+page);
      headline = saveContent+" - Dieser Monat";
      break;
    case 'commented':
      xhttp.open("GET", "./"+content+"/content.php?displayOption="+displayOption+"&page="+page);
      headline = saveContent+" - Kommentierte Artikel";
      break;
    default:
      xhttp.open("GET", "./"+content+"/content.php?displayOption="+displayOption+"&page="+page);
      headline = saveContent+" - Gesamt";
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