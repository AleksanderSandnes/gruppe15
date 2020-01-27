<?php
    include("config.php");
    include("db.php");

    $navn = $_POST['registerName'];
    $email = $_POST['registerEmail'];
    $passord = $_POST['registerPassword'];

    if (!empty($navn) || !empty($email) || !empty($passord)) {
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        } else {
            $SELECT = "SELECT brukerEmail FROM foreleser WHERE brukerEmail = ? LIMIT 1";
            $INSERT = "INSERT INTO foreleser (brukerNavn, brukerEmail, brukerPassord, brukerURL, brukerType, godkjentAvAdmin) VALUES (?, ?, ?, ?, 2,0)";

            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("ssss", $navn, $email, $passord, $_FILES['registerBilde']['name']);
                $stmt->execute();
                //bilde
                $info = pathinfo($_FILES['registerBilde']['name']);
                $ext = $info['extension']; // get the extension of the file
                $newname = $_FILES['registerBilde']['name'].$ext;

                $target = '../images/'.$newname;
                move_uploaded_file( $_FILES['registerBilde']['tmp_name'], $target);
                echo $target."<br><br>";
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