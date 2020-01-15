<?php
   include('config.php');
   session_start();

   $user_check = $_SESSION['login_user'];

   $ses_sql = mysqli_query($db,"SELECT brukerNavn, brukerEmail, brukerStudie, brukerAar, brukerType FROM brukeretabell WHERE brukerNavn = '$user_check'");

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['brukerNavn'];
   $login_type = $row['brukerType'];

   if(!isset($_SESSION['login_user'])){
      header("location:welcomeUser.php");
      die();
   }
?>