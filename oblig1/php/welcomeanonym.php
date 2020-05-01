<?php
   include('db.php');
?>
<html>
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>Gjesteside</title>
       <link rel="stylesheet" type="text/css" href="../css/navbar.css">
   </head>
   <body>
       <ul>
           <li><a class="active" href="welcomeanonym.php" target="_top">Gjestesiden</a></li>
           <li><a href="../html/index.php" target="_top">HJEM</a></li>
           <li><a href="logout.php" target="_top">Logg ut</a> </li>
       </ul>

      <form action='../php/showAllMessages.php' method='POST'>
         <label for='fagManVilSe'>Skriv koden til faget du vil se meldinger for:</label>
         <input type='text' id='fagManVilSe' name='fagManVilSe' spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off">
         <button type='submit' value='Submit'>Se meldinger</button>
      </form>

    </body>

</html>