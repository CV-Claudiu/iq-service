<?php
// IQ SERVICE - ieșirea din cont (Ziua 15)
 
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/app/init.php';
 
$_SESSION = [];
session_destroy();
 
header('Location: login.php');
exit;
