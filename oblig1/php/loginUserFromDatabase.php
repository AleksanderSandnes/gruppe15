<?php
   include("config.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $myusername = mysqli_real_escape_string($db,$_POST['loginName']);
      $mypassword = mysqli_real_escape_string($db,$_POST['loginPassword']);

      $sql = "SELECT idBruker FROM brukeretabell WHERE brukerNavn = '$myusername' and brukerPassord = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

      $count = mysqli_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row

      echo "<p>'$myusername'</p><p>'$mypassword'</p>"

      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         header("location: welcomeUser.php");
      } else {
         $error = "Your Login Name or Password is invalid";
         echo "Feil brukernavn eller passord...eller begge.";
      }
   }
?>