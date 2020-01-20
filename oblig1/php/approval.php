<?php
$hash = $_GET['h'];
$email = $_GET['e'];

if($hash == hash('sha512', 'ACCEPT')){

    //ACCESS MYSQL DATABASE
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "Gruppe15...123";
    $dbname = "brukere";
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    //FIND THE USER AND SET user_approved = 1
    //WHERE email = $email
    $query="UPDATE brukeretabell SET user_approved=1 WHERE brukerEmail='" .$email."'";

}else if($hash == hash('sha512', 'DECLINE')){

    //MAIL THE USER NOTIFYING THAT THE ACCOUNT HAS NOT BEEN APPROVED
    $to = '" .$email. "';
    $subject = 'User not approved';
    $message = 'The user {userName} is not approved' .

    $headers = 'From:aleksander.sandnes@hotmail.com' . "\r\n"; // Set FROM headers
    mail($to, $subject, $message, $headers); // Send the email
}
