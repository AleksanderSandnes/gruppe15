<?php
   include("cookiemonster.php");
   include("db.php");
   include('inputValidation.php');
   session_start();

   $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form
      $typeBruker = test_input($_POST['typeBruker']);

      $myusername = test_input($_POST['loginUserName']);
      $mypassword = test_input(md5($_POST['loginUserPassword']));

      $sql = "";

      if($typeBruker == "admin") {
          $sql = "SELECT idBruker FROM admin WHERE brukerNavn = ? and brukerPassord = ?";
      } else if($typeBruker == "anonym") {
          header("location: welcome$typeBruker.php");
      } else if($typeBruker == "foreleser") {
          $sql = "SELECT idBruker FROM foreleser WHERE brukerEmail = ? and brukerPassord = ?";
      } else if($typeBruker == "brukeretabell") {
          $sql = "SELECT idBruker FROM brukeretabell WHERE brukerEmail = ? and brukerPassord = ?";
      }
      $stmtsql = $conn->prepare($sql);
      $stmtsql->bind_param("ss",$myusername,$mypassword);
      $stmtsql->execute();
      $stmtsql->bind_result($idBrukeren);
      $stmtsql->store_result();
      $rnumm = $stmtsql->num_rows;

      if($rnumm == 1) {
         $_SESSION['login_user'] = $myusername;
         $_SESSION['login_type'] = $typeBruker;
         setCookies("emailCookie", md5($myusername));
         setCookies("passwordCookie", $mypassword);
         header("location: welcome$typeBruker.php");
      } else {
         $error = "Your Login Name or Password is invalid";
         exit("<h1>Feil passord eller email</h1><img src='../images/sadLinux.jpg' style>");
      }
   }
?>