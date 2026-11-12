<?php
// IQ SERVICE - pornirea comună a paginilor (Ziua 9)
// Încarcă funcțiile de configurare, citește .env și deschide conexiunea la baza de date.
 
session_start();

require BASE_PATH . '/config/env.php';
require BASE_PATH . '/config/database.php';
 
$config = loadEnv(BASE_PATH . '/.env');
$pdo    = getConnection($config);

// Paznicul: cine nu e în cont este trimis la pagina de intrare (Ziua 16)
//$paginaCurenta = basename($_SERVER['SCRIPT_NAME']);
 
if (!isset($_SESSION['utilizator']) && $paginaCurenta !== 'login.php') {
    header('Location: login.php');
    exit;
}
