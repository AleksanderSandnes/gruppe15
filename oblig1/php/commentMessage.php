<?php
  include("config.php");
  include("db.php");
  include('inputValidation.php');

  $meldingID = test_input($_POST['meldingID']);

  $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

  if (mysqli_connect_error()) {
      die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
  } else {
      $SELECTFag = "SELECT idMelding, melding FROM melding WHERE idMelding = ?";
      $stmt = $conn->prepare($SELECTFag);
      $stmt->bind_param("i",$meldingID);
      $stmt->execute();
      $stmt->bind_result($idMelding, $meldingen);
      $stmt->store_result();
      $rnum = $stmt->num_rows;
      $fag = "";

      if ($rnum > 0) {
          // output data of each row
          while($stmt->fetch()) {
               $fag = $meldingen;
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