<?php
$navn = $_POST['foreleserNavn'];
$email = $_POST['foreleserEmail'];
$passord = $_POST['foreleserPassord'];
$bildeURL = $_POST['bilde'];

if (!empty($navn) || !empty($email) || !empty($passord) || !empty($bildeURL)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "brukere";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        $SELECT = "SELECT email FROM foreleser WHERE email = ? LIMIT 1";
        $INSERT = "INSERT INTO foreleser (navn, email, passord, bildeURL) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sssii", $navn, $email, $passord, $bildeURL);
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