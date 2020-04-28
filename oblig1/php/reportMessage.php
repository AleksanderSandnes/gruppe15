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

    // Informational level handler
    $informationalHandler = new StreamHandler('../logs/informational.log', Logger::INFO);
    $informationalHandler->setFormatter($formatter);

    // This will have INFORMATIONAL messages only
    $Log->pushHandler($informationalHandler);

   include('inputValidation.php');
   include("db.php");
   $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form
      $meldingID = test_input($_POST['meldingID']);

      $sql = "UPDATE melding SET upassende = 1 WHERE idMelding = ?";
      $stmtsql = $conn->prepare($sql);
      $stmtsql->bind_param("i",$meldingID);
      $stmtsql->execute();

      // Sender log om at melding er rapportert
      $Log->info('Noen har rapportert en melding', ['meldingID:'=>$meldingID]);

      echo "Melding rapportert";
   }
?>