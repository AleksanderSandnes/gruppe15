<?php
   include("config.php");
   include("db.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form
      $typeBruker = mysqli_real_escape_string($db,$_POST['typeBruker']);

      $myusername = mysqli_real_escape_string($db,$_POST['loginUserName']);
      $mypassword = mysqli_real_escape_string($db,$_POST['loginUserPassword']);

      if($typeBruker == "admin") {
          $sql = "SELECT idBruker FROM $typeBruker WHERE brukerNavn = '$myusername' and brukerPassord = '$mypassword'";
      } else if($typeBruker == "anonym") {
          header("location: welcome$typeBruker.php");
      } else {
          $sql = "SELECT idBruker FROM $typeBruker WHERE brukerEmail = '$myusername' and brukerPassord = '$mypassword'";
      }
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

      $count = mysqli_num_rows($result);

      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         $_SESSION['login_type'] = $typeBruker;
         header("location: welcome$typeBruker.php");
      } else {
         $error = "Your Login Name or Password is invalid";
         echo "Feil brukernavn eller passord...eller begge.";
      }
   }
?>