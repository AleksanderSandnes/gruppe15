window.onload = oppstart;

function oppstart() {
    var loginBtn = document.getElementById("loginBtn");
    var registerBtn = document.getElementById("registerBtn");

    loginBtn.addEventListener("click", loginUser);
    registerBtn.addEventListener("click", registerUser);
}

function loginUser() {
    var name = document.getElementById("loginName");
    var password = document.getElementById("loginPassword");
    console.log(name.value);
    console.log(password.value);
}

function registerUser() {
    var name = document.getElementById("registerName");
    var password = document.getElementById("registerPassword");
    var email = document.getElementById("registerEmail");
    var studie = document.getElementById("registerStudie");
    var year = document.getElementById("registerYear");
    console.log(name.value);
    console.log(password.value);
    console.log(email.value);
    console.log(studie.value);
    console.log(year.value)
}