function passordSamme() {
    //Bytte passord
    document.getElementById("forgotPasswordBtn").setAttribute("disabled", true);

    document.getElementById("forgotPasswordForm").addEventListener("keyup", function()
        {
            var passord1 = document.getElementById("forgotPasswordNewPassword").value;
            var passord2 = document.getElementById("forgotPasswordNewPasswordAgain").value;

            var innenforReglene = false;
            if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(passord1))
                innenforReglene = true;

            var sammePassord = false;
            if (passord1 === passord2)
                sammePassord = true;

            if (innenforReglene && sammePassord) {
                document.getElementById("forgotPasswordBtn").disabled = false;
                console.log("gyldig")
            }
            else {
                document.getElementById("forgotPasswordBtn").setAttribute("disabled", true);
                console.log("IKKE gyldig")
            }
        }
    );

    //Ny bruker elev
    document.getElementById("registerBtn").setAttribute("disabled", true);
    document.getElementById("studentRegister").addEventListener("keyup", function()
        {
            var passord1 = document.getElementById("registerPassword").value;
            var passord2 = document.getElementById("registerPasswordAgain").value;

            var innenforReglene = false;
            if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(passord1))
                innenforReglene = true;

            var sammePassord = false;
            if (passord1 === passord2)
                sammePassord = true;

            if (innenforReglene && sammePassord) {
                document.getElementById("registerBtn").disabled = false;
                console.log("gyldig")
            }
            else {
                document.getElementById("registerBtn").setAttribute("disabled", true);
                console.log("IKKE gyldig")
            }
        }
    );

    //Ny bruker lærer
    document.getElementById("registerBtnTeacher").setAttribute("disabled", true);
    document.getElementById("teacherRegister").addEventListener("keyup", function()
        {
            var passord1 = document.getElementById("passord").value;
            var passord2 = document.getElementById("passordAgain").value;

            var innenforReglene = false;
            if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(passord1))
                innenforReglene = true;

            var sammePassord = false;
            if (passord1 === passord2)
                sammePassord = true;

            if (innenforReglene && sammePassord) {
                document.getElementById("registerBtnTeacher").disabled = false;
                console.log("gyldig")
            }
            else {
                document.getElementById("registerBtnTeacher").setAttribute("disabled", true);
                console.log("IKKE gyldig")
            }
        }
    );

}