<?php
  include("config.php");
  include("db.php");

  $meldingID = $_POST['meldingID'];

  $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

  if (mysqli_connect_error()) {
      die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
  } else {
      $SELECTFag = "SELECT * FROM melding WHERE idMelding = $meldingID";
      $resultFag = $conn->query($SELECTFag);
      $fag = "";

      if ($resultFag->num_rows > 0) {
          // output data of each row
          while($rowFag = $resultFag->fetch_assoc()) {
               $fag = $rowFag["melding"];
          }
      } else {
           echo "Feil emnekode gett";
      }
      $conn->close();
 }
?><html">
    <form action='../php/commentTheMessage.php' method='POST'>
        <p>Kommenter meldingen:</p>
        <p><?php echo $fag; ?></p>
        <input style='display:none;' type='text' name='meldingID' value='<?php echo $meldingID; ?>'>
        <textarea rows='4' cols='50' name='message'> </textarea>
        <button type='submit' value='Submit'>Kommenter melding</button>
    </form>
</html>