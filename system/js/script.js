function openLoginRegisterModal(buttonId) {
    const xhttp = new XMLHttpRequest();

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

function overlayOn(errorMsg) {
    var overlay = document.getElementById("errormsgBox");
    overlay.innerHTML = "<p>"+errorMsg+"</p>";
    overlay.style.display = "block";
}
function overlayOff() {
    var overlay = document.getElementById("errormsgBox");
    overlay.style.display = "none";
}