<?php
include("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

    $myEmail = mysqli_real_escape_string($db,$_POST['foreleserForgotPasswordEmail']);
    $myOldPassword = mysqli_real_escape_string($db,$_POST['foreleserForgotPasswordOldPassword']);
    $myNewPassword = mysqli_real_escape_string($db,$_POST['foreleserForgotPasswordNewPassword']);

    $sql = "UPDATE foreleser SET passord = '$myNewPassword' WHERE email = '$myEmail' AND passord = '$myOldPassword'";
    $result = mysqli_query($db,$sql);
}
?><html">
<h2><a href = "logout.php">Gå tilbake til login</a></h2>
</html>