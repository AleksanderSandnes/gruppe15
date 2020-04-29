<?php
   include('inputValidation.php');
   include("db.php");
   include('logger.php');

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
      // username and password sent from form
      $typeBruker = test_input($_POST['typeBruker']);

      $myEmail = test_input($_POST['forgotPasswordEmail']);
      $myOldPassword = test_input($_POST['forgotPasswordOldPassword']);
      $myNewPassword = test_input($_POST['forgotPasswordNewPassword']);
      $myNewPasswordAgain = test_input($_POST['forgotPasswordNewPasswordAgain']);

      preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $myNewPassword, $matchPassordKrav,PREG_OFFSET_CAPTURE);


      if ($myNewPassword == $myNewPasswordAgain) {
          if ($matchPassordKrav) {
              $myEmailHASH = md5($myEmail);
              $myOldPasswordHASH = md5($myOldPassword);
              $myNewPasswordHASH = md5($myNewPassword);

              $alphas = range('a', 'z');
              $numbers = range(1, 9);
              $salt = "";
              $dagensDato = date("Y-m-d");

              for ($i = 0; $i < rand(10, 20); $i++) {
                  $tallEllerBokstav = rand(1, 2);
                  if ($tallEllerBokstav == 1) {
                      $tilfeldigBokstav = rand(0, 25);
                      $salt .= $alphas[$tilfeldigBokstav];
                  } else if ($tallEllerBokstav == 2) {
                      $tilfeldigBokstav = rand(0, 8);
                      $salt .= $numbers[$tilfeldigBokstav];
                  }
              }

              if ($typeBruker == "brukeretabell") {
                  $sql = "UPDATE brukeretabell SET brukerPassord = ?, salt = ?, passordSistOppdatert = ? WHERE brukerEmailHash = ? AND brukerPassord = ?";
              } else if ($typeBruker == "foreleser") {
                  $sql = "UPDATE foreleser SET brukerPassord = ?, salt = ?, passordSistOppdatert = ? WHERE brukerEmailHash = ? AND brukerPassord = ?";
              }
              $stmtsql = $conn->prepare($sql);
              $stmtsql->bind_param("sssss", $myNewPasswordHASH, $salt, $dagensDato, $myEmailHASH, $myOldPasswordHASH);
              $stmtsql->execute();

              // Logger at en bruker har fått nytt passord
              $Log->info('En bruker har fått nytt passord.', ['BrukerEmail' => $myEmail]);
          } else {
              echo "  Brukeren ble ikke lagt til.
                <br><strong>Grunn:</strong>
                <br> Passord må inneholde minst: 
                <ul>
                    <li>En liten bokstav</li>
                    <li>En stor bokstav</li>
                    <li>Ett tall</li>
                    <li>Ett spesialtegn</li>
                </ul>";
          }
      } else {
          echo "Det nye passordet og verifikasjonspassordet må være det samme";
      }
   }
?><html">
      <h2><a href = "logout.php" target="_top">Gå tilbake til login</a></h2>
</html>