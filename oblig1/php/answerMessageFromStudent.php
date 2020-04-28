<?php
    // Composer autoloader
    require __DIR__ . '../vendor/autoload.php';

    // Shortcuts for simpler usage
    use Monolog\Logger;
    use Monolog\Formatter\LineFormatter;
    use Monolog\Handler\StreamHandler;

    // Common Logger
    $Log = new Logger('log-files');

    // Line formatter without empty brackets in the end
    $formatter = new LineFormatter(null, null, false, true);

    // Information level handler
    $informationHandler = new StreamHandler('../logs/information.log', Logger::INFO);
    $informationHandler->setFormatter($formatter);

    // This will have only INFORMATIONAL messages
    $Log->pushHandler($informationHandler);

   include('cookiemonster.php');

   if(checkCookies(2)) {
       include('session.php');
       include('db.php');
       include('inputValidation.php');

       $meldingsId = test_input($_POST['meldingsId']);
       $answer = test_input($_POST['answer']);

       if (!empty($meldingsId) || !empty($answer)) {
            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
            if (mysqli_connect_error()) {
                die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
            } else {
                $UPDATE = "UPDATE melding SET status=1, svar='$answer' WHERE idMelding='$meldingsId'";
                $INSERT = "INSERT INTO melding (idBrukerFra, melding, idBrukerTil) VALUES (?, ?, ?)";

                $stmt = $conn->prepare($UPDATE);
                $stmt->execute();

                // Logger alle meldinger som blir sendt
                $Log->info('En bruker har sendt en melding.', ['MeldingsID'=>$meldingsId]);

                echo "Meldingen er sendt";

                $stmt->close();
                $conn->close();
                header("location:welcome$user_type.php");
            }
       } else {
           // Logger feilet sending
           $Log->info('Noen prøvde å sende en melding men feilet');

            echo "Du må fylle ut alle feltene";
            die();
       }
   } else {
       delCookies("emailCookie");
       delCookies("passwordCookie");
       header("Location: ../html/index.html");
   }
?>