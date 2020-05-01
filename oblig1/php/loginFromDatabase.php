<?php
    $timeLoginDelay = rand(1, 2);

    sleep($timeLoginDelay);

    // Composer autoloader
    require __DIR__ . '/../vendor/autoload.php';

    // Shortcuts for simpler usage
    use Monolog\Logger;
    use Monolog\Formatter\LineFormatter;
    use Monolog\Handler\StreamHandler;

    // Common Logger
    $Log = new Logger('log-files');

    // Line formatter without empty brackets in the end
    $formatter = new LineFormatter(null, null, false, true);

    // Notice level handler
    $noticeHandler = new StreamHandler('../logs/notice.log', Logger::NOTICE);
    $noticeHandler->setFormatter($formatter);

    // Informational level handler
    $informationalHandler = new StreamHandler('../logs/informational.log', Logger::INFO);
    $informationalHandler->setFormatter($formatter);

    // This will have only NOTICE messages
    $Log->pushHandler($noticeHandler);

    // This will have only INFORMATIONAL messages
    $Log->pushHandler($informationalHandler);

   include('logger.php');
   include("cookiemonster.php");
   include("db.php");
   include('inputValidation.php');
   session_start();

   $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

   if($_SERVER["REQUEST_METHOD"] == "POST") {
       // username and password sent from form
       $typeBruker = test_input($_POST['typeBruker']);

       $myusername = test_input($_POST['loginUserName']);
       $mypassword = test_input(md5($_POST['loginUserPassword']));

       $sql = "";

       if ($typeBruker == "admin") {
           $sql = "SELECT idBruker, salt, saltEmail FROM admin WHERE brukerNavn = ? and brukerPassord = ?";
       } else if ($typeBruker == "anonym") {
           header("location: welcome$typeBruker.php");
       } else if ($typeBruker == "foreleser") {
           $sql = "SELECT idBruker, salt, saltEmail, passordSistOppdatert FROM foreleser WHERE brukerEmail = ? and brukerPassord = ?";
       } else if ($typeBruker == "brukeretabell") {
           $sql = "SELECT idBruker, salt, saltEmail, passordSistOppdatert FROM brukeretabell WHERE brukerEmail = ? and brukerPassord = ?";
       }
       $stmtsql = $conn->prepare($sql);
       $stmtsql->bind_param("ss", $myusername, $mypassword);
       $stmtsql->execute();
       if ($typeBruker == "foreleser" || $typeBruker == "brukeretabell")
           $stmtsql->bind_result($idBrukeren, $salt, $saltEmail, $passordSistOppdatert);
       else
           $stmtsql->bind_result($idBrukeren, $salt, $saltEmail);
       $stmtsql->store_result();
       $rnumm = $stmtsql->num_rows;

       $saltet = "";
       $saltetEmail = "";
       $maaByttePassord = false;
       while ($stmtsql->fetch()) {
           if ($typeBruker == "foreleser" || $typeBruker == "brukeretabell") {
               $tidNaa = time();
               $your_date = strtotime($passordSistOppdatert);
               echo ($tidNaa - $your_date) / (60 * 60 * 24 * 7 * 52);
               if ((($tidNaa - $your_date) / (60 * 60 * 24 * 7 * 52)) > 0.5)
                   $maaByttePassord = true;
           }
           $saltet = $salt;
           $saltetEmail = $saltEmail;
       }

       if ($rnumm == 1) {
           $_SESSION['login_user'] = $myusername;
           $_SESSION['login_type'] = $typeBruker;
               // Logger riktig innlogging
               $Log->info('Bruker logget inn', ['brukernavn'=>$myusername]);

               setCookies("emailCookie", md5($myusername) . $saltetEmail);
               setCookies("passwordCookie", $mypassword . $saltet);

               if ($maaByttePassord) {
                   echo "<h2>Venligst les:</h2>Som en sikkerhet på denne siden må du bytte passord hver 6 måned.<br>
                         I denne sammenhengen vil vi meddele at det er lengre enn 6 måneder siden du byttet passord.<br>
                         Vi ber deg dermed pent om å gå tilbake og bytte passord.";
               }
               else
                   header("location: welcome$typeBruker.php");

           }
       } else {
       echo "<h1>Feil passord eller email</h1><img src='../images/sadLinux.jpg' style>";

       $_SESSION["login_attempts"] += 1;

       // Logger feil innlogging creds
       $Log->notice('Noen prøvde å logge inn med feil brukernavn eller passord');
   }
?><html">
<h2><a href = "logout.php" target="_top">Gå tilbake til login</a></h2>
</html>
