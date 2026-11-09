<?php
// Exemplul 26 - prețuri: cum le scrie calculatorul, cum le citim noi
 
$pret = 1250.5;
 
$romaneste = number_format($pret, 2, ',', '.');
 
$scrisDeOm = '250,50';
$pentruCalculator = str_replace(',', '.', $scrisDeOm);
 
$eNumar = is_numeric($pentruCalculator);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 26 - prețuri</title>
</head>
<body>
    <p>Cum îl ține PHP: <?php echo $pret; ?></p>
    <p>Cum îl citim noi: <?php echo $romaneste; ?> lei</p>
    <p>Scris de om: <?php echo $scrisDeOm; ?> → pentru calculator: <?php echo $pentruCalculator; ?></p>
    <p>Este număr? <?php echo $eNumar ? 'da' : 'nu'; ?></p>
</body>
</html>
