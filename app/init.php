<?php
// IQ SERVICE - pornirea comună a paginilor (Ziua 9)
// Încarcă funcțiile de configurare, citește .env și deschide conexiunea la baza de date.
 
session_start();

require BASE_PATH . '/config/env.php';
require BASE_PATH . '/config/database.php';
 
$config = loadEnv(BASE_PATH . '/.env');
$pdo    = getConnection($config);

// Paznicul: cine nu e în cont este trimis la pagina de intrare (Ziua 16)
$paginaCurenta = basename($_SERVER['SCRIPT_NAME']);
 
if (!isset($_SESSION['utilizator']) && $paginaCurenta !== 'login.php') {
    header('Location: login.php');
    exit;
}

// Funcții pentru roluri: areRol() întreabă, cereRol() oprește pagina (Ziua 16)
function areRol($roluri)
{
    return in_array($_SESSION['utilizator']['rol'] ?? '', $roluri);
}
 
function cereRol($roluri)
{
    if (!areRol($roluri)) {
        http_response_code(403);
        echo 'Nu ai acces la această pagină. <a href="index.php">Înapoi la pagina de start</a>';
        exit;
    }
}
