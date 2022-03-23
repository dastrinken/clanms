/* General */
function setActive(buttonID) {
  var button = document.getElementById(buttonID);
  var active = document.getElementsByClassName("active");
  for(let i = 0; i < active.length; i++) {
    active[i].classList.remove("active");
  }
  button.classList.add("active");
}

/* Dashboard */

function showDashboard(buttonId) {
  var mainContent = document.getElementById("mainContentWrapper");
  $.post("./dashboard/clanms_settings.php",
  {
    command: buttonId
  }, 
  function(data) {
    mainContent.innerHTML = data;
  });
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
    if(pageNr != null) {
      pageNr.innerHTML = "Seite "+page;
    } else {
      console.log("variable pageNr is null, if everything is fine: ignore this message");
    }

    displayHeadline = document.getElementById("headlineDashboardContent");
    displayHeadline.innerHTML = headline.charAt(0).toUpperCase() + headline.slice(1);
  }

  switch(displayOption) {
    case 'all':
      xhttp.open("GET", "./"+content+"/content.php?displayOption="+displayOption+"&page="+page);
      headline = saveContent+" - Gesamt";
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

function newEntry(content) {
  var xhttp = new XMLHttpRequest();
  var container = document.getElementById("contentWrapper");

  xhttp.onload = function() {
    container.innerHTML = this.responseText;

    var simplemde = new SimpleMDE({
      autosave: {
        enabled: true,
        uniqueId: "newsContent",
        delay: 1000,
      } 
    });
  }

  switch(content) {
    case "newsblog":
      xhttp.open("GET", "./newsblog/writeArticle.php?author="+username+"&userid="+userid);
      break;
    case "event":
      xhttp.open("GET", "./events/createEvent.php?author="+username+"&userid="+userid);
      break;
  }

  
  xhttp.send();
  
} 

function confirmDelete() {
  return window.confirm("Are you sure you want to delete this record?");
}