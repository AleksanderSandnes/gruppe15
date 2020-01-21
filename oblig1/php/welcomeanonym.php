<?php
   include('db.php');

?>
<html">
   <head>
      <title>Welcome</title>
   </head>
   <body>
      <h2><a href = "logout.php">Sign Out</a></h2>
      <form action='../php/showAllMessages.php' method='POST'>
         <label for='fagManVilSe'>Skriv koden til faget du vil se meldinger for:</label>
         <input type='text' id='fagManVilSe' name='fagManVilSe'>
         <button type='submit' value='Submit'>Se meldinger</button>
      </form>
   </body>

</html>