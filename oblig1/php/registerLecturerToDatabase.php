<?php
    include("config.php");
    include("db.php");
    include('inputValidation.php');

    $navn = test_input($_POST['registerName']);
    $email = test_input($_POST['registerEmail']);
    $passord = test_input($_POST['registerPassword']);

    if (!empty($navn) || !empty($email) || !empty($passord)) {
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        } else {
            $SELECT = "SELECT brukerEmail FROM foreleser WHERE brukerEmail = ? LIMIT 1";
            $INSERT = "INSERT INTO foreleser (brukerNavn, brukerEmail, brukerEmailHash, brukerPassord, brukerURL, brukerType, godkjentAvAdmin) VALUES (?, ?, ?, ?, ?, 2,0)";

            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $emailHash = md5($email);
                $passordHash = md5($passord);
                $stmt->bind_param("sssss", $navn, $email, $emailHash, $passordHash, $_FILES['registerBilde']['name']);
                //bilde
                //BURDE BRUKE REGEX
                if (($_FILES['registerBilde']['name'] != "")){
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
                        if(preg_match('/^[a-zA-Z0-9_-]+(.jpg)$/', $filename.'.'.$ext, $matches, PREG_OFFSET_CAPTURE)) {
                            $stmt->execute();
                            echo "Bruker lagt til";
                        }
                    } else {
                        if(preg_match('/^[a-zA-Z0-9_-]+(.jpg)$/', $filename.'.'.$ext, $matches, PREG_OFFSET_CAPTURE)) {
                            move_uploaded_file($temp_name,$path_filename_ext);
                            echo "Congratulations! File Uploaded Successfully.<br>";
                            $stmt->execute();
                            echo "Bruker lagt til";
                        } else {
                            echo "<p>Looks like you tried to upload an illegal file my friend...</p>";
                            echo "<img src='../images/trumpTan.jpg' style='width:50%'>";
                        }
                    }
                }
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