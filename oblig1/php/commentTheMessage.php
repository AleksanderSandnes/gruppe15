<?php
   include("config.php");
   include("db.php");

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form
      $meldingID = mysqli_real_escape_string($db,$_POST['meldingID']);
      $message = mysqli_real_escape_string($db,$_POST['message']);

      $sql = "UPDATE melding SET kommentar = '$message' WHERE idMelding = $meldingID";
      $result = mysqli_query($db,$sql);
      echo "Melding kommetert";
   }
?>