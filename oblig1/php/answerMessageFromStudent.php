<?php
   include('cookiemonster.php');

   if(checkCookies(2)) {
       include('session.php');
       include('db.php');
       include('inputValidation.php');

       $meldingsId = test_input($_POST['meldingsId']);
       $answer = test_input($_POST['answer']);

       if (!empty($meldingsId) || !empty($answer)) {
            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
            if (mysqli_connect_error()) {
                die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
            } else {
                $UPDATE = "UPDATE melding SET status=1, svar='$answer' WHERE idMelding='$meldingsId'";
                $INSERT = "INSERT INTO melding (idBrukerFra, melding, idBrukerTil) VALUES (?, ?, ?)";

                $stmt = $conn->prepare($UPDATE);
                $stmt->execute();
                echo "Meldingen er sendt";

                $stmt->close();
                $conn->close();
                header("location:welcome$user_type.php");
            }
       } else {
            echo "Du må fylle ut alle feltene";
            die();
       }
   } else {
       delCookies("emailCookie");
       delCookies("passwordCookie");
       header("Location: ../html/index.html");
   }
?>