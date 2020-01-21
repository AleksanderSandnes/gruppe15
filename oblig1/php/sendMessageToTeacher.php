<?php
   include('session.php');
   include('db.php');

   $teacherId = $_POST['teacher'];
   $melding = $_POST['message'];

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

            $stmt->close();
            $conn->close();
        }
   } else {
        echo "Du må fylle ut alle feltene";
        die();
   }
?>