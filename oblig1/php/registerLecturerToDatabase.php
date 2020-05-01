<?php

    $timeLoginDelay = rand(1, 2);

    sleep($timeLoginDelay);
    // Composer autoloader
    require __DIR__ . '/../vendor/autoload.php';

    include("logger.php");
    include("config.php");
    include("db.php");
    include('inputValidation.php');

    $navn = test_input($_POST['registerName']);
    $email = test_input($_POST['registerEmail']);
    $passord = test_input(md5($_POST['registerPassword']));

    $password = test_input($_POST['registerPassword']);
    $passwordAgain = test_input($_POST['registerPassword']);

    preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password, $matchPassordKrav,PREG_OFFSET_CAPTURE);

    if ($password == $passwordAgain) {
        if ($matchPassordKrav) {
            if (!empty($navn) || !empty($email) || !empty($passord)) {
                echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

                if (mysqli_connect_error()) {
                    die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
                } else {
                    $SELECT = "SELECT brukerEmail FROM foreleser WHERE brukerEmail = ? LIMIT 1";
                    $INSERT = "INSERT INTO foreleser(brukerNavn, brukerEmail, brukerEmailHash, brukerPassord, salt, saltEmail, brukerURL, brukerType, godkjentAvAdmin) VALUES (?, ?, ?, ?, ?, ?, ?, 2,0)";

                    $stmt = $conn->prepare($SELECT);
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $stmt->bind_result($email);
                    $stmt->store_result();
                    $rnum = $stmt->num_rows;

                    if ($rnum == 0) {
                        $alphas = range('a', 'z');
                        $numbers = range(1, 9);
                        $saltPass = "";
                        $saltEmail = "";

                        for ($i = 0; $i < rand(10, 20); $i++) {
                            $tallEllerBokstav = rand(1, 2);
                            if ($tallEllerBokstav == 1) {
                                $tilfeldigBokstav = rand(0, 25);
                                $saltPass .= $alphas[$tilfeldigBokstav];
                            } else if ($tallEllerBokstav == 2) {
                                $tilfeldigBokstav = rand(0, 8);
                                $saltPass .= $numbers[$tilfeldigBokstav];
                            }
                        }
                        for ($i = 0; $i < rand(10, 20); $i++) {
                            $tallEllerBokstav = rand(1, 2);
                            if ($tallEllerBokstav == 1) {
                                $tilfeldigBokstav = rand(0, 25);
                                $saltEmail .= $alphas[$tilfeldigBokstav];
                            } else if ($tallEllerBokstav == 2) {
                                $tilfeldigBokstav = rand(0, 8);
                                $saltEmail .= $numbers[$tilfeldigBokstav];
                            }
                        }
                        $stmt->close();
                        $stmt = $conn->prepare($INSERT);
                        $emailHash = md5($email);
                        $stmt->bind_param("sssssss", $navn, $email, $emailHash, $passord, $saltPass, $saltEmail, $_FILES['registerBilde']['name']);

                        //bilde
                        if (($_FILES['registerBilde']['name'] != "")) {
                            // Where the file is going to be stored
                            $target_dir = "../images/";
                            $file = $_FILES['registerBilde']['name'];
                            $path = pathinfo($file);
                            $filename = $path['filename'];
                            $ext = $path['extension'];
                            $temp_name = $_FILES['registerBilde']['tmp_name'];
                            $path_filename_ext = $target_dir . $filename . "." . $ext;

                            preg_match('/^[a-zA-Z0-9_-]+.jpg$/', $file, $match, PREG_OFFSET_CAPTURE);

                            if ($match) {
                                // Check if file already exists
                                if (file_exists($path_filename_ext)) {
                                    // Sender en log om at noen prøvde å legge til en fil som allerede finnes
                                    $Log->info("En bruker prøvde å laste opp et bilde som allerede finnes");

                                    echo "Sorry, file already exists.<br>";
                                } else {
                                    move_uploaded_file($temp_name, $path_filename_ext);
                                    echo "Congratulations! File Uploaded Successfully.<br>";
                                    echo "Bruker lagt til";

                                    // Sender en log om at bruker ble opprettet.
                                    $Log->info("En bruker ble opprettet.", ['brukernavn' => $navn]);

                                    $stmt->execute();
                                }
                            } else {
                                echo "<h1>Hacketty hack hack</h1>";
                                echo "<img style='width:50%' src='../images/tumpTan.jpg'>";
                                echo "<br>*Psst* Brukeren ble ikke lagt til";

                                // Sender inn en log
                                $Log->info('Noen prøvde å opprette en bruker men klarte det ikke');
                            }
                        } else {
                            echo "Bruker allerede registrert";
                        }
                    } else {
                        // Logger feilet forsøk
                        $Log->info('Noen prøvde å opprette en bruker som allerede finnes');

                        echo "Bruker allerede registrert";
                    }
                }
            } else {
                // Logger at noen ikke fyllte ut alle feltene
                $Log->info('Noen prøvde å lage bruker uten å fylle inn alle feltene');
                echo "Du må fylle ut alle feltene";
                die();
            }
        } else {
            echo "  Brukeren ble ikke lagt til.
                <br><strong>Grunn:</strong>
                <br> Passord må inneholde minst:
                <ul>
                    <li>En liten bokstav</li>
                    <li>En stor bokstav</li>
                    <li>Ett tall</li>
                    <li>Ett spesialtegn</li>
                </ul>";
        }
    } else {
        echo "Det nye passordet og verifikasjonspassordet må være det samme";
    }

?><html">
<h2><a href = "logout.php" target="_top">Gå tilbake til login</a></h2>
</html>
