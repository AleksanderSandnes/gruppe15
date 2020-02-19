<?php
   include('inputValidation.php');
   include("db.php");

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
      // username and password sent from form
      $meldingID = test_input($_POST['meldingID']);
      $message = test_input($_POST['message']);

      $sql = "UPDATE melding SET kommentar = ? WHERE idMelding = ?";
      $stmtsql = $conn->prepare($sql);
      $stmtsql->bind_param("si",$message, $meldingID);
      $stmtsql->execute();
      echo "Melding kommetert";
   }
?>