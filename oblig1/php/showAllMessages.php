<?php
   include('config.php');
   include('db.php');

   $fagKode = $_POST['fagManVilSe'];

   $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

   if (mysqli_connect_error()) {
       die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
   } else {
       $SELECTFag = "SELECT * FROM melding WHERE idFag = $fagKode";
       $resultFag = $conn->query($SELECTFag);
       $fag = "";

       if ($resultFag->num_rows > 0) {
           // output data of each row
           while($rowFag = $resultFag->fetch_assoc()) {
                if($rowFag["status"] == 0) {
                    $fag .= "<div style='border: 1px solid black; padding: 10px'><p><b>Spørsmål ".$rowFag["idMelding"].":</b>".$rowFag["melding"]."</p><p><b>svar: </b>Ikke noe svar</p><form action='../php/reportMessage.php' method='POST'><input type='text' style='display:none' name='meldingID' value='".$rowFag["idMelding"]."'><button type='submit' value='submit'>Rapporter</button></form><form action='../php/commentMessage.php' method='POST'><input type='text' style='display:none' name='meldingID' value='".$rowFag["idMelding"]."'><button type='submit' value='submit'>Kommenter</button></form></div>";
                } else {
                    $fag .= "<div style='border: 1px solid black; padding: 10px'><p><b>Spørsmål ".$rowFag["idMelding"].":</b>".$rowFag["melding"]."</p><p><b>svar: </b>".$rowFag["svar"]."</p><form action='../php/reportMessage.php' method='POST'><input type='text' style='display:none' name='meldingID' value='".$rowFag["idMelding"]."'><button type='submit' value='submit'>Rapporter</button></form><form action='../php/commentMessage.php' method='POST'><input type='text' style='display:none' name='meldingID' value='".$rowFag["idMelding"]."'><button type='submit' value='submit'>Kommenter</button></form></div>";
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
      <h2><a href = "logout.php">Sign Out</a></h2>
      <p>EMNEKODE: <?php echo $fagKode; ?></p>
      <div style='display:flex;'>
        <?php echo $fag; ?>
      </div>
   </body>
</html>
