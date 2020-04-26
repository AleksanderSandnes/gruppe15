<?php
  include('cookiemonster.php');

  if(checkCookies(1)) {
      include('session.php');
      include('db.php');

      $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

      if (mysqli_connect_error()) {
          die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
      } else {
          $SELECTFag = "SELECT idFag, fagNavn FROM fag GROUP BY fagNavn";
          $stmtSELECTFag = $conn->prepare($SELECTFag);
          $stmtSELECTFag->execute();
          $stmtSELECTFag->bind_result($idFag, $fagNavn);
          $stmtSELECTFag->store_result();
          $rnumSELECTFag = $stmtSELECTFag->num_rows;
          $fag = "";


          $SELECTForeleser = "SELECT idFag, brukerURL FROM fag INNER JOIN foreleser ON foreleser.idBruker = fag.idBruker GROUP BY idFag";
          $stmtSELECTForeleser = $conn->prepare($SELECTForeleser);
          $stmtSELECTForeleser->execute();
          $stmtSELECTForeleser->bind_result($idFag, $brukerURL);
          $stmtSELECTForeleser->store_result();
          $rnumSELECTForeleser = $stmtSELECTForeleser->num_rows;
          $bilder = "";

          if ($rnumSELECTFag > 0) {
              while($stmtSELECTFag->fetch()) {
                  $fag .= "<option value='".$idFag."'>".$idFag.": ".$fagNavn."</option>";
              }
          }
          if ($rnumSELECTForeleser > 0) {
              while($stmtSELECTForeleser->fetch()) {
                  $bilder .= "<div><img class='bildeTeacher' style='width:10%' id='".$idFag."' src='../images/".$brukerURL."'></div>";
              }
          }
          $conn->close();
      }
  } else {
      delCookies("emailCookie");
      delCookies("passwordCookie");
      header("Location: ../html/index.html");
  }

  if(isset($_GET['byttPassord'])) {
      $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

      $email = $_GET['email'];
      $gammeltPassord = $_GET['gammeltPassord'];
      $nyttPassord1 = $_GET['nyttPassord1'];
      $nyttPassord2 = $_GET['nyttPassord2'];

      $hentBruker = " SELECT brukerPassord FROM brukeretabell WHERE brukerPassord = '$gammeltPassord' AND brukerEmail = '$email'";

      if(mysqli_query($conn, $hentBruker)) {
          echo "Bruker fungerer";

          $oppdaterPassord = "UPDATE brukeretabell SET brukerPassord = '$nyttPassord1' WHERE brukerEmail = '$email'";

          mysqli_query($conn, $oppdaterPassord);
      }

      else {
          echo "Error: Noe gikk galt... " . mysqli_error($conn);
      }
  }
?>
<html>
   <head>
      <title>Welcome </title>
    <script type='text/javascript' src='../js/bilder.js'></script>
   </head>
   <body>
      <h2><a href = "logout.php">Sign Out</a></h2>
      <h1>Welcome <?php echo $login_session; ?></h1>

      <form action='../php/sendMessageToTeacher.php' method='POST'>
          <p>Send melding til foreleser:</p>
          <select name='teacher' id='velg'><?php echo $fag; ?></select><br>
          <textarea rows='4' cols='50' name='message'> </textarea><br>
          <button type='submit' value='Submit'>Send melding</button>
      </form>

      <div>
          <?php echo $bilder; ?>
      </div>
   </body>
</html>