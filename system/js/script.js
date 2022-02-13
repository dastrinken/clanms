function openLoginRegisterModal(buttonId) {
    const xhttp = new XMLHttpRequest();
    var modalFormBody = document.getElementById("loginSignupModalBody");
    xhttp.onload = function() {
        modalFormBody.innerHTML = this.responseText;
    }
    if(buttonId == "loginBtn") {
        xhttp.open("GET", "./system/login/login.php");
        console.log(modalFormBody);
    } else if(buttonId == "signupBtn") {
        xhttp.open("GET", "./system/login/register.php");
    }
    xhttp.send();
}