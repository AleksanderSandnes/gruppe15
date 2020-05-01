<?php
  include('cookiemonster.php');

  if(checkCookies(2)) {
      include('session.php');
      include('db.php');
      include('inputValidation.php');

      $meldingsId = test_input($_POST['meldingsId']);

      $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

      if (mysqli_connect_error()) {
          die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());

      } else {
          $SELECTMeldinger = "SELECT melding FROM melding WHERE idMelding = ?";
          $stmtSELECTMeldinger = $conn->prepare($SELECTMeldinger);
          $stmtSELECTMeldinger->bind_param("i",$meldingsId);
          $stmtSELECTMeldinger->execute();
          $stmtSELECTMeldinger->bind_result($meldingen);
          $stmtSELECTMeldinger->store_result();
          $rnumSELECTMeldinger = $stmtSELECTMeldinger->num_rows;
          $meldinger = "";

          if ($rnumSELECTMeldinger > 0) {
              // output data of each row
              while($stmtSELECTMeldinger->fetch()) {
                    $meldinger = $meldingen;
              }
          }
          $conn->close();
     }
  } else {
      delCookies("emailCookie");
      delCookies("passwordCookie");
      header("Location: ../html/index.php");
  }

?><html">
    <p><b>Melding du svarer på:</b></p>
    <p><?php echo $meldinger; ?></p>
    <form action='../php/answerMessageFromStudent.php' method='POST'>
        <p><b>Svar på meldingen:</b></p>
        <input style='display:none' name='meldingsId' type='text' value='<?php echo $meldingsId; ?>' spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off">
        <textarea rows='4' cols='50' name='answer'> </textarea>
    <button type='submit' value='Submit'>Svar på melding</button>
  </form>
</html>