<?php
   include('session.php');
   include('db.php');
   if ($login_type == 1) {
        header("location: welcomeUser.php");
   } else if ($login_type == 2) {
        header("location: welcomeTeacher.php");
   }

      $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

      if (mysqli_connect_error()) {
          die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
      } else {
          $SELECTFag = "SELECT * FROM foreleser";
          $resultFag = $conn->query($SELECTFag);
          $fag = "";

          if ($resultFag->num_rows > 0) {
              // output data of each row
              while($rowFag = $resultFag->fetch_assoc()) {
                   if($rowFag["godkjentAvAdmin"] == 0) {
                       $fag .= "<div style='padding: 10px; border: 1px solid black;'><p>".$rowFag["idBruker"].": ".$rowFag["brukerNavn"]."</p><p>".$rowFag["brukerEmail"]."</p><form action='../php/approveTeacher.php' method='POST'><input type='text' style='display:none' name='brukerID' value='".$rowFag["idBruker"]."'><button type='submit' value='submit'>Godkjenn</button></form><form action='../php/dontApproveTeacher.php' method='POST'><input type='text' style='display:none' name='brukerID' value='".$rowFag["idBruker"]."'><button type='submit' value='submit'>Ikke godkjenn</button></form></div>";
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
      <title>Welcome </title>
   </head>
   <body>
      <h2><a href = "logout.php">Sign Out</a></h2>
      <h1>Welcome <?php echo $login_session; ?></h1>
      <div style='display:flex;'>
        <?php echo $fag; ?>
      </div>
   </body>

</html>