<?php
   include("config.php");
   include("db.php");

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form
      $meldingID = mysqli_real_escape_string($db,$_POST['meldingID']);

      $sql = "UPDATE melding SET upassende = 1 WHERE idMelding = $meldingID";
      $result = mysqli_query($db,$sql);
      echo "Melding rapportert";
   }
?>