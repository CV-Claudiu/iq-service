<?php
// Exemplul 20 - de ce avem nevoie de un nomenclator
// Aceeași categorie, scrisă de mână de trei oameni diferiți.
 
$scrisDeMana = ['Centrală termică', 'centrala termica', 'CT', 'Centrală termică', 'Centrala'];
 
$numarare = array_count_values($scrisDeMana);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 20 - nomenclator</title>
</head>
<body>
    <h1>Câte centrale termice avem?</h1>
 
    <ul>
        <?php foreach ($numarare as $text => $cate): ?>
            <li><?php echo $text; ?>: <?php echo $cate; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
