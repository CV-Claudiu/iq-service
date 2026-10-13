<?php
// IQ SERVICE - pagina de start (Ziua 3)
// Citește configurația din .env, se conectează la baza de date
// și afișează rezultatul verificării.
 
date_default_timezone_set('Europe/Bucharest');
 
// Rădăcina proiectului: folderul de deasupra lui public/
define('BASE_PATH', dirname(__DIR__));
 
require BASE_PATH . '/config/env.php';
require BASE_PATH . '/config/database.php';
 
$config        = [];
$numeAplicatie = 'IQ SERVICE';
$conectat      = false;
$infoBaza      = [];
$detaliiEroare = '';
 
try {
    $config        = loadEnv(BASE_PATH . '/.env');
    $numeAplicatie = $config['APP_NAME'] ?? $numeAplicatie;
 
    $pdo      = getConnection($config);
    $infoBaza = $pdo->query('SELECT DATABASE() AS baza, VERSION() AS versiune, NOW() AS ora')->fetch();
    $conectat = true;
} catch (Throwable $e) {
    // 1. Notăm eroarea completă în jurnalul aplicației (pentru programator)
    $mesajLog = date('Y-m-d H:i:s') . ' | ' . $e->getMessage() . PHP_EOL;
    error_log($mesajLog, 3, BASE_PATH . '/storage/logs/app.log');
 
    // 2. Detaliile tehnice apar pe ecran doar în modul de depanare
    if (($config['APP_DEBUG'] ?? 'false') === 'true') {
        $detaliiEroare = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($numeAplicatie); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($numeAplicatie); ?></h1>
    <p>Aplicație CRM pentru service echipamente de automatizare</p>
 
    <h2>Verificarea conexiunii la baza de date</h2>
 
    <?php if ($conectat): ?>
        <p style="color: green;"><strong>Conexiunea la baza de date funcționează.</strong></p>
        <ul>
            <li>Baza de date: <?php echo htmlspecialchars($infoBaza['baza']); ?></li>
            <li>Server: <?php echo htmlspecialchars($infoBaza['versiune']); ?></li>
            <li>Ora serverului de baze de date: <?php echo htmlspecialchars($infoBaza['ora']); ?></li>
            <li>Versiune PHP: <?php echo phpversion(); ?></li>
        </ul>
    <?php else: ?>
        <p style="color: red;"><strong>Nu ne putem conecta la baza de date.</strong></p>
        <p>Eroarea a fost notată în jurnalul aplicației (storage/logs/app.log).</p>
        <?php if ($detaliiEroare !== ''): ?>
            <p><em>Detalii (vizibile doar cu APP_DEBUG=true):</em>
               <?php echo htmlspecialchars($detaliiEroare); ?></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>