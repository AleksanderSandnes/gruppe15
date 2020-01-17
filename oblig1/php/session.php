<?php
   include('config.php');
   session_start();

   $user_check = $_SESSION['login_user'];
   $user_type = $_SESSION['login_type'];

   if($user_type == "brukeretabell") {
        $ses_sql = mysqli_query($db,"SELECT brukerNavn, brukerEmail, brukerStudie, brukerAar, brukerType FROM brukeretabell WHERE brukerNavn = '$user_check'");
   } else if($user_type == "foreleser") {
        $ses_sql = mysqli_query($db,"SELECT brukerNavn, brukerEmail, brukerURL, brukerType FROM foreleser WHERE brukerNavn = '$user_check'");
   }

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['brukerNavn'];
   $login_type = $row['brukerType'];

   if(!isset($_SESSION['login_user'])){
      header("location:welcome$user_type.php");
      die();
   }
?>