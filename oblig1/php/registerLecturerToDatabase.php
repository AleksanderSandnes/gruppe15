<?php
    include("config.php");
    include("db.php");
    include('inputValidation.php');

    $navn = test_input($_POST['registerName']);
    $email = test_input($_POST['registerEmail']);
    $passord = test_input(md5($_POST['registerPassword']));

    if (!empty($navn) || !empty($email) || !empty($passord)) {
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        } else {
            $SELECT = "SELECT brukerEmail FROM foreleser WHERE brukerEmail = ? LIMIT 1";
            $INSERT = "INSERT INTO foreleser(brukerNavn, brukerEmail, brukerEmailHash, brukerPassord, salt, saltEmail, brukerURL, brukerType, godkjentAvAdmin) VALUES (?, ?, ?, ?, ?, ?, ?, 2,0)";

            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $alphas = range('a', 'z');
                $numbers = range(1, 9);
                $saltPass = "";
                $saltEmail = "";

                for($i = 0; $i<rand(5,11);$i++) {
                    $tallEllerBokstav = rand(1,2);
                    if($tallEllerBokstav == 1) {
                        $tilfeldigBokstav = rand(0,25);
                        $saltPass .= $alphas[$tilfeldigBokstav];
                    } else if($tallEllerBokstav == 2) {
                        $tilfeldigBokstav = rand(0,8);
                        $saltPass .= $numbers[$tilfeldigBokstav];
                    }
                }
                for($i = 0; $i<rand(5,11);$i++) {
                    $tallEllerBokstav = rand(1,2);
                    if($tallEllerBokstav == 1) {
                        $tilfeldigBokstav = rand(0,25);
                        $saltEmail .= $alphas[$tilfeldigBokstav];
                    } else if($tallEllerBokstav == 2) {
                        $tilfeldigBokstav = rand(0,8);
                        $saltEmail .= $numbers[$tilfeldigBokstav];
                    }
                }
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $emailHash = md5($email);
                $stmt->bind_param("sssssss", $navn, $email, $emailHash, $passord, $saltPass, $saltEmail, $_FILES['registerBilde']['name']);

                //bilde
                //BURDE BRUKE REGEX
                if (($_FILES['registerBilde']['name']!="")){
                    // Where the file is going to be stored
                    $target_dir = "../images/";
                    $file = $_FILES['registerBilde']['name'];
                    $path = pathinfo($file);
                    $filename = $path['filename'];
                    $ext = $path['extension'];
                    $temp_name = $_FILES['registerBilde']['tmp_name'];
                    $path_filename_ext = $target_dir.$filename.".".$ext;

                    preg_match('/^[a-zA-Z0-9_-]+.jpg$/', $file, $match,PREG_OFFSET_CAPTURE);

                    if($match) {
                        // Check if file already exists
                        if (file_exists($path_filename_ext)) {
                             echo "Sorry, file already exists.<br>";
                        } else {
                            move_uploaded_file($temp_name,$path_filename_ext);
                            echo "Congratulations! File Uploaded Successfully.<br>";
                            echo "Bruker lagt til";
                            $stmt->execute();
                        }
                    } else {
                        echo "<h1>Hacketty hack hack</h1>";
                        echo "<img style='width:50%' src='../images/tumpTan.jpg'>";
                        echo "<br>*Psst* Brukeren ble ikke lagt til";
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