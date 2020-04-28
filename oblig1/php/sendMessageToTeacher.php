<?php
   include('cookiemonster.php');
   include('logger.php');

   if(checkCookies(1)) {
       include('session.php');
       include('db.php');
       include('inputValidation.php');

       $teacherId = test_input($_POST['teacher']);
       $melding = test_input($_POST['message']);

       if (!empty($teacherId) || !empty($melding)) {
            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
            if (mysqli_connect_error()) {
                die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
            } else {
                $INSERT = "INSERT INTO melding (idBrukerFra, melding, idFag, svar, upassende, kommentar, status) VALUES (?, ?, ?, '', 0, '', 0)";

                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("isi", $login_id, $melding, $teacherId);
                $stmt->execute();
                echo "Meldingen er sendt";

                // Logger at en melding blir sendt
                $Log->info('En melding ble sendt fra en bruker til en foreleser.', ['ForeleserID:'=>$teacherId]);

                $stmt->close();
                $conn->close();
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