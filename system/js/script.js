// General
function destroy_session() {
    var xhttp = new XMLHttpRequest();
    xhttp.open('GET','./system/destroy_session.php', true);
    xhttp.onreadystatechange=function(){
        if (xhttp.readyState == 4){
           if(xhttp.status == 200){
              alert(xhttp.responseText);
          }
        }
     };
     xhttp.send(null);
}

// Header
function openLoginRegisterModal(buttonId) {
    var xhttp = new XMLHttpRequest();

    var modalFormBody = document.getElementById("loginSignupModalBody");
    var changeLoginFormBtn = document.getElementById("changeLoginFormBtn");

    xhttp.onload = function() {
        modalFormBody.innerHTML = this.responseText;
    }
    if(buttonId == "loginBtn") {
        xhttp.open("GET", "./system/login/login.php");
        changeLoginFormBtn.innerHTML = "Not registered yet?";
    } else if(buttonId == "signupBtn") {
        xhttp.open("GET", "./system/login/register.php");
        changeLoginFormBtn.innerHTML = "Already have an account?";
    }
    xhttp.send();
}
