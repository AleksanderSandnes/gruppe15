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

      $myEmailHASH = md5($myEmail);
      $myOldPasswordHASH = md5($myOldPassword);
      $myNewPasswordHASH = md5($myNewPassword);

      if($typeBruker == "brukeretabell"){
          $sql = "UPDATE brukeretabell SET brukerPassord = ? WHERE brukerEmailHash = ? AND brukerPassord = ?";
      } else if($typeBruker == "foreleser") {
          $sql = "UPDATE foreleser SET brukerPassord = ? WHERE brukerEmailHash = ? AND brukerPassord = ?";
      }
      $stmtsql = $conn->prepare($sql);
      $stmtsql->bind_param("sss", $myNewPasswordHASH, $myEmailHASH, $myOldPasswordHASH);
      $stmtsql->execute();

      // Logger at en bruker har fått nytt passord
      $Log->info('En bruker har fått nytt passord.', ['BrukerEmail'=>$myEmail]);
   }
?><html">
      <h2><a href = "logout.php" target="_top">Gå tilbake til login</a></h2>
</html>