// Device width, making header sticky
function makeItSticky(dwidth) {
    var header = document.getElementById("stickyHeader");
    if (dwidth.matches) {
        header.classList.add("sticky-top");
    } else {
        if(header.classList.contains("sticky-top")) {
            header.classList.remove("sticky-top");
        }
    }
}

var dwidth = window.matchMedia("screen and (min-width:768px)");
makeItSticky(dwidth);
dwidth.addEventListener("change", makeItSticky);

// General
function destroy_session() {
    var xhttp = new XMLHttpRequest();
    xhttp.open('GET','./system/destroy_session.php', true);
    xhttp.onreadystatechange=function(){
        if (xhttp.readyState == 4){
            if(xhttp.status == 200){
                window.location.href = './';
          }
        }
     };
     xhttp.send(null);
}

// Header
function openLoginRegisterModal(buttonId) {
    var xhttp = new XMLHttpRequest();

    var modalFormBody = document.getElementById("loginSignupModalBody");
    var modalFormLabel = document.getElementById("loginRegisterModalLabel");
    var header;

    xhttp.onload = function() {
        modalFormLabel.innerHTML = header;
        modalFormBody.innerHTML = this.responseText;
    }
    if(buttonId == "loginBtn") {
        header = "Log in";
        xhttp.open("GET", "./system/account/login/login.php");
    } else if(buttonId == "signupBtn") {
        header = "Register";
        xhttp.open("GET", "./system/account/login/register.php");
    }
    xhttp.send();
}

function closeToast() {
    var toast = document.getElementById("messageToast");
    toast.classList.remove("showToast");
    toast.classList.add("hideToast");
}