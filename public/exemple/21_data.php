<?php
// Exemplul 21 - o dată din baza de date, afișată românește
// Baza de date scrie datele ca an-lună-zi. Oamenii le citesc zi.lună.an.
 
$dinBaza = '2024-03-15';
 
$romaneste = date('d.m.Y', strtotime($dinBaza));
 
$lipsa = null;
$afisare = $lipsa ? date('d.m.Y', strtotime($lipsa)) : '-';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 21 - date calendaristice</title>
</head>
<body>
    <p>Din baza de date: <?php echo $dinBaza; ?></p>
    <p>Pentru oameni: <?php echo $romaneste; ?></p>
    <p>Dată lipsă: <?php echo $afisare; ?></p>
</body>
</html>
