<?php
  include('session.php');
  include('db.php');
  if ($login_type == 2) {
       header("location: welcomeTeacher.php");
  } else if ($login_type == 3) {
       header("location: welcomeAdmin.php");
  }

  $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

  if (mysqli_connect_error()) {
      die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
  } else {
      $SELECTFag = "SELECT * FROM fag GROUP BY fagNavn";
      $SELECTForeleser = "SELECT * FROM foreleser INNER JOIN fag ON foreleser.idBruker = fag.idBruker GROUP BY idFag";
      $resultFag = $conn->query($SELECTFag);
      $resultForeleser = $conn->query($SELECTForeleser);
      $fag = "";
      $bilder = "";

      if ($resultFag->num_rows > 0) {
          // output data of each row
          while($rowFag = $resultFag->fetch_assoc()) {
              $fag .= "<option value='".$rowFag["idFag"]."'>".$rowFag["idFag"].": ".$rowFag["fagNavn"]."</option>";
          }
      }
      if ($resultForeleser->num_rows > 0) {
          // output data of each row
          while($rowForeleser = $resultForeleser->fetch_assoc()) {
              $bilder .= "<div><img class='bildeTeacher' style='width:10%' id='".$rowForeleser["idFag"]."' src='../images/".$rowForeleser["brukerURL"]."'></div>";
          }
      }
      $conn->close();
 }
?>
<html">

   <head>
      <title>Welcome </title>
    <script type='text/javascript' src='../js/bilder.js'></script>
   </head>
   <body>
      <h2><a href = "logout.php">Sign Out</a></h2>
      <h1>Welcome <?php echo $login_session; ?></h1>
      <form action='../php/sendMessageToTeacher.php' method='POST'>
        <p>Send melding til foreleser:</p>
        <select name='teacher' id='velg'><?php echo $fag; ?></select>
        <textarea rows='4' cols='50' placeholder='Send melding ang. ønsket emne/fag' name='message'> </textarea>
        <button type='submit' value='Submit'>Send melding</button>
      </form>
      <div>
        <?php echo $bilder; ?>
      </div>
   </body>

</html>