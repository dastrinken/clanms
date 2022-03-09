function getContentPhp(content) {
  var xhttp = new XMLHttpRequest();
  var mainContent = document.getElementById("mainContentWrapper");

  xhttp.onload = function() {
    mainContent.innerHTML = this.responseText;
  }
  if(content == "newsblog") {
      xhttp.open("GET", "./newsblog/contentMenu.php");
  } 

  xhttp.send();
}

/* Newsblog */

function newsDisplayOption(buttonId) {
  var displayHeadline = document.getElementById("displayArticlesHeadline");  
  if(displayHeadline == null) {
    getContentPhp("newsblog");
  }

  if(buttonId == "thisWeeksArticles") {
    displayHeadline.innerHTML = "Diese Woche";
  } else if(buttonId == "thisMonthsArticles") {
    displayHeadline.innerHTML = "Dieser Monat";
  } else if(buttonId == "articlesComments") {
    displayHeadline.innerHTML = "Kommentare";
  }
}

function writeArticle() {
  var xhttp = new XMLHttpRequest();
  var container = document.getElementById("newsBlogContainer");

  xhttp.onload = function() {
    container.innerHTML = this.responseText;
    var simplemde = new SimpleMDE({ element: document.getElementById("newsContent") });
    simplemde.value("hier den Newsbeitrag formulieren");
  }
  xhttp.open("GET", "./newsblog/writeArticle.php?author="+username+"&userid="+userid);
  
  xhttp.send();
  
} 