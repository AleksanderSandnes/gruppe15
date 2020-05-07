<?php

    $timeLoginDelay = rand(1, 2);

    sleep($timeLoginDelay);
    include("config.php");
    include("db.php");
    include('inputValidation.php');
    //include('logger.php');

    $userName = test_input($_POST['registerName']);
    $userPassword = test_input(md5($_POST['registerPassword']));
    $userEmail = test_input($_POST['registerEmail']);
    $userStudie = test_input($_POST['registerStudie']);
    $userYear = test_input($_POST['registerYear']);

    $password = test_input($_POST['registerPassword']);
    $passwordAgain = test_input($_POST['registerPasswordAgain']);

    preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password, $matchPassordKrav,PREG_OFFSET_CAPTURE);

    if ($password == $passwordAgain) {
        if ($matchPassordKrav) {
            if (!empty($userName) || !empty($userPassword) || !empty($userEmail) || !empty($userStudie) || !empty($userYear)) {
                $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
                if (mysqli_connect_error()) {
                    die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
                } else {
                    $SELECT = "SELECT brukerEmail FROM brukeretabell WHERE brukerEmail = ? LIMIT 1";
                    $INSERT = "INSERT INTO brukeretabell (brukerNavn, brukerPassord, salt, brukerEmail, brukerEmailHash, saltEmail, brukerStudie, brukerAar, brukerType, passordSistOppdatert) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?)";

                    $stmt = $conn->prepare($SELECT);
                    $stmt->bind_param("s", $userEmail);
                    $stmt->execute();
                    $stmt->bind_result($userEmail);
                    $stmt->store_result();
                    $rnum = $stmt->num_rows;

                    if ($rnum == 0) {
                        $alphas = range('a', 'z');
                        $numbers = range(1, 9);
                        $salt = "";
                        $saltEmail = "";

                        for ($i = 0; $i < rand(10, 20); $i++) {
                            $tallEllerBokstav = rand(1, 2);
                            if ($tallEllerBokstav == 1) {
                                $tilfeldigBokstav = rand(0, 25);
                                $salt .= $alphas[$tilfeldigBokstav];
                            } else if ($tallEllerBokstav == 2) {
                                $tilfeldigBokstav = rand(0, 8);
                                $salt .= $numbers[$tilfeldigBokstav];
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

                        $datoenIdag = date("Y-m-d");
                        $stmt->close();
                        $stmt = $conn->prepare($INSERT);
                        $emailHash = md5($userEmail);
                        echo $datoenIdag;
                        $stmt->bind_param("sssssssis", $userName, $userPassword, $salt, $userEmail, $emailHash, $saltEmail, $userStudie, $userYear, $datoenIdag);
                        $stmt->execute();
                        echo "Bruker lagt til";

                        // Logger at en bruker ble opprettet
                        //$Log->info('En bruker ble laget.', ['Navn:' => $userName]);
                    } else {
                        // Logger at en bruker allerede finnes
                        //$Log->info('Noen prøvde å lage en bruker som finnes, idiot :)');

                        echo "Bruker allerede registrert";
                    }
                    $stmt->close();
                    $conn->close();
                }
            } else {
                // Logger at alle felter ikke ble fylt ut
                //$Log->info('Bruker ble ikke laget pga alle felter ikke var fylt ut');

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
        echo "Passordet og verifikasjonspassordet må være det samme";
    }

?><html">
      <h2><a href = "logout.php" target="_top">Gå tilbake til login</a></h2>
</html>
