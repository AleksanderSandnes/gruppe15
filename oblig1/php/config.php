<?php
   define('DB_HOST', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'Gruppe15...123');
   define('DB_NAME', 'brukere');
   $host = DB_HOST;
   $dbUsername = DB_USERNAME;
   $dbPassword = DB_PASSWORD;
   $dbname = DB_NAME;
   $db = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
?>