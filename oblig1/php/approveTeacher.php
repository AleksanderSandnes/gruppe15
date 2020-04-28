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

    // This will INFORMATION messages
    $Log->pushHandler($informationHandler);

   include('inputValidation.php');
   include('cookiemonster.php');

   if(checkCookies(3)) {
       include("db.php");

       $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

       if($_SERVER["REQUEST_METHOD"] == "POST") {
          // username and password sent from form
          $brukerID = test_input($_POST['brukerID']);

          $sql = "UPDATE foreleser SET godkjentAvAdmin = 1 WHERE idBruker = ?";
          $stmtsql = $conn->prepare($sql);
          $stmtsql->bind_param("i",$brukerID);
          $stmtsql->execute();

          // Logger at en bruker er godkjent
          $Log->info("En bruker har blitt godkjent.", ['Brukerid'=>$brukerID]);

          echo "Bruker godkjent";
       }
   } else {
       delCookies("emailCookie");
       delCookies("passwordCookie");
       header("Location: ../html/index.html");
   }
?>