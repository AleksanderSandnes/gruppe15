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
      <form action='../php/addSubjectToTeacher.php' method='POST'>
         <label for='fagManUnderviser'>Velg fag du underviser:</label>
         <input type='text' id='fagManUnderviser' name='fagManUnderviser'>
         <button type='submit' value='Submit'>Legg til</button>
      </form>
      <div>
        <h2>Mine fag:</h2>
        <p>Fag 1</p>
      </div>
   </body>

</html>