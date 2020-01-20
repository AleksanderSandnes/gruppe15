<?php
   include('session.php');
   include('db.php');
   if ($login_type == 1) {
        header("location: welcomeUser.php");
   } else if ($login_type == 2) {
        header("location: welcomeTeacher.php");
   }
?>
<html">

   <head>
      <title>Welcome </title>
   </head>
   <body>
      <h2><a href = "logout.php">Sign Out</a></h2>
      <h1>Welcome <?php echo $login_session; ?></h1>
   </body>

</html>