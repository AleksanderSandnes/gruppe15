<?php
$userName = $_POST['registerName'];
$userPassword = $_POST['registerPassword'];
$userEmail = $_POST['registerEmail'];
$userStudie = $_POST['registerStudie'];
$userYear = $_POST['registerYear'];

if (!empty($userName) || !empty($userPassword) || !empty($userEmail) || !empty($userStudie) || !empty($userYear)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "brukere";
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        $SELECT = "SELECT brukerEmail FROM brukeretabell WHERE brukerEmail = ? LIMIT 1";
        $INSERT = "INSERT INTO brukeretabell (brukerNavn, brukerPassord, brukerEmail, brukerStudie, brukerAar, brukerType) VALUES (?, ?, ?, ?, ?, 1)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s",$brukerEmail);
        $stmt->execute();
        $stmt->bind_result($brukerEmail);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sssii", $userName, $userPassword, $userEmail, $userStudie, $userYear);
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

?><html">
      <h2><a href = "logout.php">Gå tilbake til login</a></h2>
</html>
