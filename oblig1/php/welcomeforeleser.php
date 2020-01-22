<?php
   include('session.php');
   include('db.php');

   if($godkjentAvAdmin == 1) {
        header("location:welcome".$user_type."en.php");
   } else {
        echo "Brukeren er ikke godkjent";
   }
?>