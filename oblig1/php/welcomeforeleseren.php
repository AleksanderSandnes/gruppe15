<?php
   include('cookiemonster.php');

   if(checkCookies(2)) {
       include('session.php');
       include('db.php');
       $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

       if (mysqli_connect_error()) {
           die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
       } else {

           $SELECTMeldinger = "SELECT brukere.melding.melding, brukere.melding.idMelding, brukere.melding.status
                                FROM brukere.melding
                                INNER JOIN brukere.fag
                                    ON brukere.melding.idFag = brukere.fag.idFag
                                INNER JOIN brukere.foreleser
                                    ON brukere.fag.idBruker = brukere.foreleser.idBruker
                                WHERE brukere.foreleser.idBruker = ?;";
           $stmtSELECTMeldinger = $conn->prepare($SELECTMeldinger);
           $stmtSELECTMeldinger->bind_param("i",$login_id);
           $stmtSELECTMeldinger->execute();
           $stmtSELECTMeldinger->bind_result($meldingen, $idMelding, $status);
           $stmtSELECTMeldinger->store_result();
           $rnumSELECTMeldinger = $stmtSELECTMeldinger->num_rows;
           $meldinger = "";

           if ($rnumSELECTMeldinger > 0) {
               // output data of each row
               while($stmtSELECTMeldinger->fetch()) {
                   if($status == 0) {
                       $meldinger .=
                       "<form style='border: 1px solid black; padding: 10px' action='../php/answerMessage.php' method='POST'>".
                            "<p>Fra anonym</p>".
                            "<input style='display:none' name='meldingsId' type='text' value='".$idMelding."'>".
                            "<p>".$meldingen."</p>".
                            "<button type='submit' value='submit'>Svar</button>".
                       "</form>";
                   }
               }
           }


           $SELECTFag = "SELECT DISTINCT idFag, fagNavn FROM fag WHERE idBruker = ?";
           $stmtSELECTFag = $conn->prepare($SELECTFag);
           $stmtSELECTFag->bind_param("i",$login_id);
           $stmtSELECTFag->execute();
           $stmtSELECTFag->bind_result($idFag, $fagNavn);
           $stmtSELECTFag->store_result();
           $rnumSELECTFag = $stmtSELECTFag->num_rows;
           $fag = "";

           if ($rnumSELECTFag > 0) {
               // output data of each row
               while($stmtSELECTFag->fetch()) {
                   $fag .= "<li>".$idFag.": ".$fagNavn."</li>";
               }
           }
           $conn->close();
      }
   } else {
       delCookies("emailCookie");
       delCookies("passwordCookie");
       header("Location: ../html/index.html");
   }
?>
<html">

   <head>
      <title>Welcome </title>
   </head>
   <body id='body'>
      <h2><a href = "logout.php">Sign Out</a></h2>
      <h1>Welcome <?php echo $login_session; ?></h1>
      <form action='../php/addSubjectToTeacher.php' method='POST'>
         <label for='fagManUnderviser'>Velg fag du underviser:</label>
         <input type='text' id='fagManUnderviser' name='fagManUnderviser' spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off">
         <button type='submit' value='Submit'>Legg til</button>
      </form>
      <div>
        <h2>Mine meldinger:</h2>
        <div style='display:flex;'><?php echo $meldinger; ?></div>
      </div>
      <div>
        <h2>Mine fag:</h2>
        <ul><?php echo $fag; ?></ul>
      </div>
   </body>

</html>