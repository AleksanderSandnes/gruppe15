<?php
   include('cookiemonster.php');

   if(checkCookies(3)) {
       include('session.php');
       include('db.php');

       $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

       if (mysqli_connect_error()) {
           die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
       } else {
           $SELECTFag = "SELECT godkjentAvAdmin, idBruker, brukerNavn, brukerEmail FROM foreleser";
           $stmtSELECTFag = $conn->prepare($SELECTFag);
           $stmtSELECTFag->execute();
           $stmtSELECTFag->bind_result($godkjentAvAdmin, $idBruker, $brukerNavn, $brukerEmail);
           $stmtSELECTFag->store_result();
           $rnumSELECTFag = $stmtSELECTFag->num_rows;
           $fag = "";

           if ($rnumSELECTFag > 0) {
               // output data of each row
               while($stmtSELECTFag->fetch()) {
                    if($godkjentAvAdmin == 0) {
                        $fag .= "<div style='padding: 10px; border: 1px solid black;'><p>".$idBruker.": ".$brukerNavn."</p><p>".$brukerEmail."</p><form action='../php/approveTeacher.php' method='POST'><input type='text' style='display:none' name='brukerID' value='".$idBruker."'><button type='submit' value='submit'>Godkjenn</button></form><form action='../php/dontApproveTeacher.php' method='POST'><input type='text' style='display:none' name='brukerID' value='".$idBruker."'><button type='submit' value='submit'>Ikke godkjenn</button></form></div>";
                    }
               }
           } else {
                echo "Ingen lærere å godkjenne";
           }
           $conn->close();
       }
   } else {
       delCookies("emailCookie");
       delCookies("passwordCookie");
       header("Location: ../html/index.php");
   }
?>
<html">

   <head>
      <title>Welcome </title>
   </head>
   <body>
      <h2><a href = "logout.php" target="_top">Sign Out</a></h2>
      <h1>Welcome <?php echo $login_session; ?></h1>
      <div style='display:flex;'>
        <?php echo $fag; ?>
      </div>
   </body>

</html>