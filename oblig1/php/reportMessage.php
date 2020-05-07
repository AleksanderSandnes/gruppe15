<?php
   //include('logger.php');
   include('inputValidation.php');
   include("db.php");
   $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form
      $meldingID = test_input($_POST['meldingID']);

      $sql = "UPDATE melding SET upassende = 1 WHERE idMelding = ?";
      $stmtsql = $conn->prepare($sql);
      $stmtsql->bind_param("i",$meldingID);
      $stmtsql->execute();

      // Sender log om at melding er rapportert
      //$Log->info('Noen har rapportert en melding', ['meldingID:'=>$meldingID]);

      echo "Melding rapportert";
   }
?>