<?php
   include("config.php");

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $myEmail = mysqli_real_escape_string($db,$_POST['forgotPasswordEmail']);
      $myOldPassword = mysqli_real_escape_string($db,$_POST['forgotPasswordOldPassword']);
      $myNewPassword = mysqli_real_escape_string($db,$_POST['forgotPasswordNewPassword']);

      $sql = "UPDATE brukeretabell SET brukerPassord = '$myNewPassword' WHERE brukerEmail = '$myEmail' AND brukerPassord = '$myOldPassword'";
      $result = mysqli_query($db,$sql);
   }
?><html">
      <h2><a href = "logout.php">Gå tilbake til login</a></h2>
</html>