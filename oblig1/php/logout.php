<?php
   include('cookiemonster.php');
   session_start();

   if(session_destroy()) {
      delCookies("emailCookie");
      delCookies("passwordCookie");
      header("Location: ../html/index.html");
   }
?>