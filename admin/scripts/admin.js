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
var saveFolder;
var saveFile;
var page = 1;

function getTableView(folder, file, displayOption) {
  saveFolder = folder;
  saveFile = file;
  saveDisplay = displayOption;

  var xhttp = new XMLHttpRequest();
  var mainContent = document.getElementById("mainContentWrapper");
  var headline;
  var pageNr;

  xhttp.onload = function() {
    mainContent.innerHTML = this.responseText;
    if(folder == "groups") {
      manageGroupRights();
    }
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
      xhttp.open("GET", "./"+folder+"/"+file+".php?displayOption="+displayOption+"&page="+page);
      headline = saveFolder+" - Gesamt";
      break;
    case 'week':
      xhttp.open("GET", "./"+folder+"/"+file+".php?displayOption="+displayOption+"&page="+page);
      headline = saveFolder+" - Diese Woche";
      break;
    case 'month':
      xhttp.open("GET", "./"+folder+"/"+file+".php?displayOption="+displayOption+"&page="+page);
      headline = saveFolder+" - Dieser Monat";
      break;
    case 'commented':
      xhttp.open("GET", "./"+folder+"/"+file+".php?displayOption="+displayOption+"&page="+page);
      headline = saveFolder+" - Kommentierte Artikel";
      break;
    default:
      xhttp.open("GET", "./"+folder+"/"+file+".php?displayOption="+displayOption+"&page="+page);
      headline = saveFolder+" - Gesamt";
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
    case "gallery":
      xhttp.open("GET", "./gallery/editGallery.php?author="+username+"&userid="+userid);
      break;
    case "user":
      xhttp.open("GET", "./user/createUser.php?author="+username+"&userid="+userid);
      break;
    case "game":
      xhttp.open("GET", "./game/createGame.php?author="+username+"&userid="+userid);
    case "newsCategory":
      xhttp.open("GET", "./newsblog/createNewsCategory.php?author="+username+"&userid="+userid);
      break;
    case "eventCategory":
      xhttp.open("GET", "./events/createEventCategory.php?author="+username+"&userid="+userid);
      break;
  }

  
  xhttp.send();
  
} 

function confirmDelete() {
  return window.confirm("Are you sure you want to delete this record?");
}

function reloadContent()
{
     getElement("image-preview").oUp.reload();

     return true;
}

/* Rechteverwaltung */

function manageGroupRights() {
  var checkboxArray = document.getElementsByClassName("form-check-input");
  var checked;
  for(let i = 0; i < checkboxArray.length; i++) {
    checkboxArray[i].addEventListener("click", function() {
      if($(this).is(':checked')) {
        checked = "true";
      } else {
        checked = "false";
      }
      $.post("./groups/groups_functions.php", { id: this.id, command: "saveGroupRights", active: checked})
        .done(function(data) {
          console.log("Antwort: "+data);
        });
    })
  }
}