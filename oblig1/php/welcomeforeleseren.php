<?php
   include('session.php');
   include('db.php');
   if ($login_type == 1) {
        header("location: welcomeUser.php");
   } else if ($login_type == 3) {
        header("location: welcomeAdmin.php");
   }

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
                            WHERE brukere.foreleser.idBruker = $login_id;";
       $SELECTMeldingerr = "SELECT * FROM melding WHERE idBrukerTil = $login_id";
       $SELECTFag = "SELECT DISTINCT * FROM fag WHERE idBruker = $login_id";
       $resultMeldinger = $conn->query($SELECTMeldinger);
       $resultFag = $conn->query($SELECTFag);
       $meldinger = "";
       $fag = "";

       if ($resultMeldinger->num_rows > 0) {
           // output data of each row
           while($rowMelding = $resultMeldinger->fetch_assoc()) {
               if($rowMelding["status"] == 0) {
                   $meldinger .=
                   "<form style='border: 1px solid black; padding: 10px' action='../php/answerMessage.php' method='POST'>".
                        "<p>Fra anonym</p>".
                        "<input style='display:none' name='meldingsId' type='text' value='".$rowMelding["idMelding"]."'>".
                        "<p>".$rowMelding["melding"]."</p>".
                        "<button type='submit' value='submit'>Svar</button>".
                   "</form>";
               }
           }
       }
       if ($resultFag->num_rows > 0) {
           // output data of each row
           while($rowFag = $resultFag->fetch_assoc()) {
               $fag .= "<li>".$rowFag["idFag"].": ".$rowFag["fagNavn"]."</li>";
           }
       }
       $conn->close();
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
         <input type='text' id='fagManUnderviser' name='fagManUnderviser'>
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