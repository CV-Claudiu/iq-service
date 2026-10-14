<?php
// Exemplul 2 - PHP calculează, HTML afișează
 
$firma     = 'IQ SERVICE';
$oras      = 'Cluj-Napoca';
$angajati  = 12;
$clienti   = 85;
$medie     = $clienti / $angajati;
$azi       = date('d.m.Y');
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 2 - PHP</title>
</head>
<body>
    <h1><?php echo $firma; ?></h1>
    <p>Sediul: <?php echo $oras; ?></p>
    <p>Angajați: <?php echo $angajati; ?>, clienți: <?php echo $clienti; ?></p>
    <p>Clienți pe angajat: <?php echo round($medie, 1); ?></p>
    <p>Data de azi: <?php echo $azi; ?></p>
</body>
</html>
