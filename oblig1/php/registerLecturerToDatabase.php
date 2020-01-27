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
                if (($_FILES['registerBilde']['name']!="")){
                // Where the file is going to be stored
                     $target_dir = "../images/";
                     $file = $_FILES['registerBilde']['name'];
                     $path = pathinfo($file);
                     $filename = $path['filename'];
                     $ext = $path['extension'];
                     $temp_name = $_FILES['registerBilde']['tmp_name'];
                     $path_filename_ext = $target_dir.$filename.".".$ext;

                     // Check if file already exists
                     if (file_exists($path_filename_ext)) {
                          echo "Sorry, file already exists.<br>";
                     } else {
                         move_uploaded_file($temp_name,$path_filename_ext);
                         echo "Congratulations! File Uploaded Successfully.<br>";
                     }
                }
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