<?php
// IQ SERVICE - pagina de start (Ziua 2)
// Pagina afișează informații despre mediul de lucru,
// ca să vedem că Apache și PHP lucrează împreună.
 
date_default_timezone_set('Europe/Bucharest');
 
$numeAplicatie = 'IQ SERVICE!';
$descriere     = 'Aplicație CRM pentru service echipamente de automatizare';
$versiunePhp   = phpversion();
$dataOra       = date('d.m.Y H:i:s');
$numecalculator= gethostname();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $numeAplicatie; ?></title>
</head>
<body>
    <h1><?php echo $numeAplicatie; ?></h1>
    <p><?php echo $descriere; ?></p>
    <p>Calculator: <?php echo $numecalculator; ?></p>
 
    <h2>Mediul de lucru funcționează</h2>
    <ul>
        <li>Server web: <?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
        <li>Versiune PHP: <?php echo $versiunePhp; ?></li>
        <li>Data și ora serverului: <?php echo $dataOra; ?></li>
        <li>Fișierul executat: <?php echo __FILE__; ?></li>
    </ul>
</body>
</html>