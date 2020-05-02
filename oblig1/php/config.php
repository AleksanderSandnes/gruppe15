<?php
   if (!defined('DB_HOST')) {
       define('DB_HOST', 'localhost');
   }
   if (!defined('DB_USERNAME')) {
       define('DB_USERNAME', 'per');
   }
   if (!defined('DB_PASSWORD')) {
       define('DB_PASSWORD', 'Per...Spelmann420');
   }
   if (!defined('DB_NAME')) {
       define('DB_NAME', 'brukere');
   }
   $db = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
?>