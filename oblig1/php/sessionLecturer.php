<?php
   include('config.php');
   session_start();

   $user_check = $_SESSION['login_user'];

   $ses_sql = mysqli_query($db,"SELECT brukernavn, email, bildeURL, brukerType FROM foreleser WHERE brukernavn = '$user_check'");

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['brukernavn'];
   $login_type = $row['brukerType'];

   if(!isset($_SESSION['login_user'])){
      header("location:welcomeTeacher.php");
      die();
   }
?>