<?php
    // Composer autoloader
    require __DIR__ . '../vendor/autoload.php';

    // Shortcuts for simpler usage
    use Monolog\Logger;
    use Monolog\Formatter\LineFormatter;
    use Monolog\Handler\StreamHandler;
    use Monolog\Handler\LogglyHandler;
    use Monolog\Formatter\LogglyFormatter;
    use Monolog\Handler\FingersCrossedHandler;
    use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
    use Monolog\Handler\GelfHandler;
    use Gelf\Message;
    use Gelf\Publisher;
    use Gelf\Transport\UdpTransport;
    use Monolog\Formatter\GelfMessageFormatter;

    // Common Logger
    $Log = new Logger('log-files');

    // Line formatter without empty brackets in the end
    $formatter = new LineFormatter(null, null, false, true);

    // 0 - Emergency level handler
    $emergencyHandler = new StreamHandler('../logs/emergency.log', Logger::EMERGENCY);
    $emergencyHandler->setFormatter($formatter);

    // 1- Alert level handler
    $alertHandler = new StreamHandler('../logs/alert.log', Logger::ALERT);
    $alertHandler->setFormatter($formatter);

    // 2 - Critical level handler
    $criticalHandler = new StreamHandler('../logs/critical.log', Logger::CRITICAL);

    // 3 - Error level handler
    $errorHandler = new StreamHandler('../logs/error.log', Logger::ERROR);
    $errorHandler->setFormatter($formatter);

    // 4 - Warning level handler
    $warningHandler = new StreamHandler('../logs/warning.log', Logger::WARNING);
    $warningHandler->setFormatter($formatter);

    // 5 - Notice level handler
    $noticeHandler = new StreamHandler('../logs/notice.log', Logger::NOTICE);
    $noticeHandler->setFormatter($formatter);

    // 6 - Informational level handler
    $informationalHandler = new StreamHandler('../logs/informational.log', Logger::INFO);
    $informationalHandler->setFormatter($formatter);

    // 7 - Debug level handler
    $debugHandler = new StreamHandler('../logs/debug.log', Logger::DEBUG);
    $debugHandler->setFormatter($formatter);

    // 0 - This will only have EMERGENCY messages
    $Log->pushHandler($emergencyHandler);

    // 1 - This will only have ALERT messages
    $Log->pushHandler($alertHandler);

    // 2 - This will only have CRITICAL messages
    $Log->pushHandler($criticalHandler);

    // 3 - This will have only ERROR messages
    $Log->pushHandler($errorHandler);

    // 4 - This will have only WARNING messages
    $Log->pushHandler($warningHandler);

    // 5 - This will have only NOTICE messages
    $Log->pushHandler($noticeHandler);

    // 6 - This will have only INFORMATIONAL messages
    $Log->pushHandler($informationalHandler);

    // 7 - This will have both DEBUG and ERROR messages
    $Log->pushHandler($debugHandler);