<?php
   include('session.php');
   include('db.php');

   $fag = $_POST['fagManUnderviser'];

   if (!empty($fag)) {
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        } else {
            $INSERT = "INSERT INTO fag (fagNavn, idBruker) VALUES (?, ?)";

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("si", $fag, $login_id);
            $stmt->execute();
            echo "Fag lagt til";

            $stmt->close();
            $conn->close();
            header("location:welcome$user_type.php");
        }
   } else {
        echo "Du må fylle ut alle feltene";
        die();
   }
?>