window.onload = oppstart;

function oppstart() {
    var type = document.getElementById("register");
    var student = document.getElementById("studentRegister");
    var teacher = document.getElementById("teacherRegister");

    student.style.display = "normal";
    teacher.style.display = "none";
    type.addEventListener("change", function() {
        if(type.value == "student") {
            student.style.display = "block";
            teacher.style.display = "none";
        } else if(type.value == "teacher") {
            student.style.display = "none";
            teacher.style.display = "block";
        }
    });

    var tekst = document.getElementById("loginType");
    var typeBruker = document.getElementById("userLoginTypeBruker");
    typeBruker.addEventListener("change", function() {
        if(typeBruker.value == "admin") {
            tekst.innerHTML = "Navn";
        } else {
            tekst.innerHTML = "Email";
        }
    });
}