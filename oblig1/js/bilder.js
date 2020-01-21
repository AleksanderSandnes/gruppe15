window.onload = oppstart;

function oppstart() {
    var velg = document.getElementById("velg");
    var bilder = document.querySelectorAll("img.bildeTeacher");
    console.log(bilder)


    for (i=0;i<bilder.length;i++){
        if (bilder[i].id == velg.value) {
            document.getElementById(bilder[i].id).style.display = "block";
        } else {
            document.getElementById(bilder[i].id).style.display = "none";
        }
    }
    velg.addEventListener("change", function () {
        for (i=0;i<bilder.length;i++){
            if (bilder[i].id == velg.value) {
                document.getElementById(bilder[i].id).style.display = "block";
            } else {
                document.getElementById(bilder[i].id).style.display = "none";
            }
        }
    });
}