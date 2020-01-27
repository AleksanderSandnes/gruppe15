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
        if(typeBruker.value == "anonym") {
            document.getElementById("loginType").style.display = "none";
            document.getElementById("loginName").style.display = "none";
            document.getElementById("loginName").required = false;
            document.getElementById("loginPass").style.display = "none";
            document.getElementById("loginPassword").style.display = "none";
            document.getElementById("loginPassword").required = false;
        } else {
            document.getElementById("loginType").style.display = "inline-block";
            document.getElementById("loginName").style.display = "inline-block";
            document.getElementById("loginName").required = true;
            document.getElementById("loginPass").style.display = "inline-block";
            document.getElementById("loginPassword").style.display = "inline-block";
            document.getElementById("loginPassword").required = true;
        }
    });
}