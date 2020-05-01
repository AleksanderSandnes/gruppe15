<?php
   include('db.php');
   if(!isset($_SESSION))
   {
       session_start();
   }
   $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

   if (isset($_SESSION['login_user']))
       $user_check = $_SESSION['login_user'];

   if (isset($_SESSION['login_type']))
       $user_type = $_SESSION['login_type'];

   if (!isset($_SESSION['login_user']) && !isset($_SESSION['login_type']))
       header("location: ../html/index.php");



   $ses_sql = "";

   if($user_type == "brukeretabell") {
        $ses_sql = "SELECT idBruker, brukerNavn, brukerType FROM brukeretabell WHERE brukerEmail = ?";
   } else if($user_type == "foreleser") {
        $ses_sql = "SELECT idBruker, brukerNavn, brukerType, godkjentAvAdmin FROM foreleser WHERE brukerEmail = ?";
   } else if($user_type == "admin") {
        $ses_sql = "SELECT idBruker, brukerNavn, brukerType FROM admin WHERE brukerNavn = ?";
   }

   $stmtses_sql = $conn->prepare($ses_sql);
   $stmtses_sql->bind_param("s", $user_check);
   $stmtses_sql->execute();
   if($user_type == "foreleser") {
       $stmtses_sql->bind_result($idBrukeren, $brukerNavnet, $brukerTypen, $godkjentAvAdminen);
   } else {
       $stmtses_sql->bind_result($idBrukeren, $brukerNavnet, $brukerTypen);
   }
   $stmtses_sql->store_result();

   while($stmtses_sql->fetch()) {
       $login_session = $brukerNavnet;
       $login_type = $brukerTypen;
       $login_id = $idBrukeren;

       if($user_type == "foreleser") {
            $godkjentAvAdmin = $godkjentAvAdminen;
       }
   }

   if(!isset($_SESSION['login_user'])){
      header("location: ../html/index.php");
      die();
   }
?>