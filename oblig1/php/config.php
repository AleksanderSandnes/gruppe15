<?php
   if (!defined('DB_HOST')) {
       define('DB_HOST', 'localhost');
   }
   if (!defined('DB_USERNAME')) {
       define('DB_USERNAME', 'root');
   }
   if (!defined('DB_PASSWORD')) {
       define('DB_PASSWORD', '');
   }
   if (!defined('DB_NAME')) {
       define('DB_NAME', 'brukere');
   }
   $db = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
?>