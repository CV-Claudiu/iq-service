<?php
// IQ SERVICE - pornirea comună a paginilor (Ziua 9)
// Încarcă funcțiile de configurare, citește .env și deschide conexiunea la baza de date.
 
session_start();

require BASE_PATH . '/config/env.php';
require BASE_PATH . '/config/database.php';
 
$config = loadEnv(BASE_PATH . '/.env');
$pdo    = getConnection($config);