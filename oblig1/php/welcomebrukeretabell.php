<?php
   include('session.php');
   include('db.php');
   if ($login_type == 2) {
        header("location: welcomeTeacher.php");
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
      <form action='../php/sendMessageToTeacher.php' method='POST'>
        <p>Send melding til foreleser:</p>
        <select name='teacher'>
            <option value='1'>Lærer 1</option>
            <option value='2'>Lærer 2</option>
        </select>
        <textarea rows='4' cols='50' placeholder='Send melding ang. ønsket emne/fag' name='message'> </textarea>
        <button type='submit' value='Submit'>Send melding</button>
      </form>
   </body>

</html>