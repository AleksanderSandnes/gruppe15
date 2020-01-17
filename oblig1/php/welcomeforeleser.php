<?php
   include('session.php');
   if ($login_type == 1) {
        header("location: welcomeUser.php");
   } else if ($login_type == 3) {
        header("location: welcomeAdmin.php");
   }
?>
<html">

   <head>
      <title>Welcome </title>
   </head>
   <body>
      <h2><a href = "logout.php">Sign Out</a></h2>
      <h1>Welcome <?php echo $login_session; ?></h1>
      <h1><?php echo $login_type; ?></h1>
   </body>

</html>