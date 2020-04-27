<?php
   include('config.php');
   include('db.php');
   include('inputValidation.php');

   $fagKode = test_input($_POST['fagManVilSe']);

   $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

   if (mysqli_connect_error()) {
       die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
   } else {
       $SELECTFag = "SELECT idMelding, melding, svar, status FROM melding WHERE idFag = ?";
       $stmtSELECTFag = $conn->prepare($SELECTFag);
       $stmtSELECTFag->bind_param("i",$fagKode);
       $stmtSELECTFag->execute();
       $stmtSELECTFag->bind_result($idMelding, $meldingen, $svaret, $statusen);
       $stmtSELECTFag->store_result();
       $rnumSELECTFag = $stmtSELECTFag->num_rows;
       $fag = "";

       if ($rnumSELECTFag > 0) {
           // output data of each row
           while($stmtSELECTFag->fetch()) {
                if($statusen == 0) {
                    $fag .= "<div style='border: 1px solid black; padding: 10px'><p><b>Spørsmål ".$idMelding.":</b>".$meldingen."</p><p><b>svar: </b>Ikke noe svar</p><form action='../php/reportMessage.php' method='POST'><input type='text' style='display:none' name='meldingID' value='".$idMelding."'><button type='submit' value='submit'>Rapporter</button></form><form action='../php/commentMessage.php' method='POST'><input type='text' style='display:none' name='meldingID' value='".$idMelding."'><button type='submit' value='submit'>Kommenter</button></form></div>";
                } else {
                    $fag .= "<div style='border: 1px solid black; padding: 10px'><p><b>Spørsmål ".$idMelding.":</b>".$meldingen."</p><p><b>svar: </b>".$svaret."</p><form action='../php/reportMessage.php' method='POST'><input type='text' style='display:none' name='meldingID' value='".$idMelding."'><button type='submit' value='submit'>Rapporter</button></form><form action='../php/commentMessage.php' method='POST'><input type='text' style='display:none' name='meldingID' value='".$idMelding."'><button type='submit' value='submit'>Kommenter</button></form></div>";
                }
           }
       } else {
            echo "Feil emnekode gett";
       }
       $conn->close();
  }
?>
<html">
   <head>
      <title>Welcome</title>
   </head>
   <body>
      <h2><a href = "logout.php" target="_top">Sign Out</a></h2>
      <p>EMNEKODE: <?php echo $fagKode; ?></p>
      <div style='display:flex;'>
        <?php echo $fag; ?>
      </div>
   </body>
</html>
