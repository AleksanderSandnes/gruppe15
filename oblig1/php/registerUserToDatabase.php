<?php
    include("config.php");
    include("db.php");
    include('inputValidation.php');

    $userName = test_input($_POST['registerName']);
    $userPassword = test_input($_POST['registerPassword']);
    $userEmail = test_input($_POST['registerEmail']);
    $userStudie = test_input($_POST['registerStudie']);
    $userYear = test_input($_POST['registerYear']);

    if (!empty($userName) || !empty($userPassword) || !empty($userEmail) || !empty($userStudie) || !empty($userYear)) {
        $yearNow = date("Y");
        if($yearNow >= $userYear) {
            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
            if (mysqli_connect_error()) {
                die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
            } else {
                $SELECT = "SELECT brukerEmail FROM brukeretabell WHERE brukerEmail = ? LIMIT 1";
                $INSERT = "INSERT INTO brukeretabell (brukerNavn, brukerPassord, brukerEmail, brukerEmail, brukerStudie, brukerAar, brukerType) VALUES (?, ?, ?, ?, ?, ?, 1)";

                $stmt = $conn->prepare($SELECT);
                $stmt->bind_param("s",$userEmail);
                $stmt->execute();
                $stmt->bind_result($userEmail);
                $stmt->store_result();
                $rnum = $stmt->num_rows;

                if ($rnum == 0) {
                    $stmt->close();
                    $stmt = $conn->prepare($INSERT);
                    $emailHash = md5($email);
                    $passordHash = md5($userPassword);
                    $stmt->bind_param("sssssi", $userName, $passordHash, $userEmail, $emailHash, $userStudie, $userYear);
                    $stmt->execute();
                    echo "Bruker lagt til";
                } else {
                    echo "Bruker allerede registrert";
                }
                $stmt->close();
                $conn->close();
            }
        } else {
            echo "Du kan ikke være et kull fra framtiden dessverre";
        }
    } else {
        echo "Du må fylle ut alle feltene";
        die();
    }
?><html">
      <h2><a href = "logout.php">Gå tilbake til login</a></h2>
</html>
