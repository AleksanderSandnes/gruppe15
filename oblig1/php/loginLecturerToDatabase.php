<?php
   include("config.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $myusername = mysqli_real_escape_string($db,$_POST['loginLecturerName']);
      $mypassword = mysqli_real_escape_string($db,$_POST['loginLecturerPassword']);

      $sql = "SELECT id FROM foreleser WHERE brukernavn = '$myusername' and passord = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

      $count = mysqli_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row

      echo "<p>'$count'</p><p>'$myusername'</p><p>'$mypassword'</p>";

      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         header("location: welcomeTeacher.php");
      } else {
         $error = "Your Login Name or Password is invalid";
         echo "Feil brukernavn eller passord...eller begge.";
      }
   }
?>