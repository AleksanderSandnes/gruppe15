<?php
    include("config.php");
    $navn = $_POST['navn'];
    $email = $_POST['email'];
    $passord = $_POST['passord'];
    $bildeURL = $_POST['bilde'];

    if (!empty($navn) || !empty($email) || !empty($passord) || !empty($bildeURL)) {
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        } else {
            $SELECT = "SELECT brukerEmail FROM foreleser WHERE brukerEmail = ? LIMIT 1";
            $INSERT = "INSERT INTO foreleser (brukerNavn, brukerEmail, brukerPassord, brukerURL, brukerType) VALUES (?, ?, ?, ?, 2)";

            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("ssss", $navn, $email, $passord, $bildeURL);
                $stmt->execute();
                echo "Bruker lagt til";
            } else {
                echo "Bruker allerede registrert";
            }
            $stmt->close();
            $conn->close();
        }
    } else {
        echo "Du må fylle ut alle feltene";
        die();
    }
?>