<?php
   include('config.php');
   include('db.php');
   session_start();

   $user_check = $_SESSION['login_user'];
   $user_type = $_SESSION['login_type'];

   if($user_type == "brukeretabell") {
        $ses_sql = mysqli_query($db,"SELECT idBruker, brukerNavn, brukerEmail, brukerStudie, brukerAar, brukerType FROM $user_type WHERE brukerEmail = '$user_check'");
   } else if($user_type == "foreleser") {
        $ses_sql = mysqli_query($db,"SELECT idBruker, brukerNavn, brukerEmail, brukerURL, brukerType, godkjentAvAdmin FROM $user_type WHERE brukerEmail = '$user_check'");
   } else if($user_type == "admin") {
        $ses_sql = mysqli_query($db,"SELECT idBruker, brukerNavn, brukerEmail, brukerType FROM $user_type WHERE brukerNavn = '$user_check'");
   }

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['brukerNavn'];
   $login_type = $row['brukerType'];
   $login_id = $row['idBruker'];

   if($user_type == "foreleser") {
        $godkjentAvAdmin = $row['godkjentAvAdmin'];
   }

   if(!isset($_SESSION['login_user'])){
      header("location:welcome$user_type.php");
      die();
   }
?>