<?php
   include('cookiemonster.php');

   if(checkCookies(2)) {
       include('session.php');
       include('db.php');

       if($godkjentAvAdmin == 1) {
            header("location:welcome".$user_type."en.php");
       } else {
            echo "Brukeren er ikke godkjent";
       }
   } else {
       delCookies("emailCookie");
       delCookies("passwordCookie");
       header("Location: ../html/index.html");
   }
?>