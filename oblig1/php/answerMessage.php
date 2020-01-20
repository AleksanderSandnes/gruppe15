<?php
  include('session.php');
  include('db.php');

  $meldingsId = $_POST['meldingsId'];

  $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

  if (mysqli_connect_error()) {
      die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
  } else {
      $SELECTMeldinger = "SELECT melding FROM melding WHERE idMelding = $meldingsId";
      $resultMeldinger = $conn->query($SELECTMeldinger);
      $meldinger = "";

      if ($resultMeldinger->num_rows > 0) {
          // output data of each row
          while($rowMelding = $resultMeldinger->fetch_assoc()) {
                $meldinger = $rowMelding["melding"];
          }
      }
      $conn->close();
 }

?><html">
    <p><b>Melding du svarer på:</b></p>
    <p><?php echo $meldinger; ?></p>
    <form action='../php/answerMessageFromStudent.php' method='POST'>
        <p><b>Svar på meldingen:</b></p>
        <input style='display:none' name='meldingsId' type='text' value='<?php echo $meldingsId; ?>'>
        <textarea rows='4' cols='50' name='answer'> </textarea>
    <button type='submit' value='Submit'>Svar på melding</button>
  </form>
</html>