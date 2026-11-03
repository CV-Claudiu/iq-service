<?php
// Exemplul 14 - două liste legate printr-un număr
// Fiecare persoană are „firma_id” = numărul firmei la care lucrează.
 
$firme = [
    1 => 'Automatizări Industriale SRL',
    2 => 'Termoplast Service SRL',
];
 
$persoane = [
    ['nume' => 'Andrei Pop',    'firma_id' => 1],
    ['nume' => 'Elena Rusu',    'firma_id' => 1],
    ['nume' => 'Victor Neagu',  'firma_id' => 2],
];
 
$firmaAleasa = (int) ($_GET['firma'] ?? 1);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 14 - legătură între liste</title>
</head>
<body>
    <h1><?php echo $firme[$firmaAleasa] ?? 'Firmă necunoscută'; ?></h1>
 
    <p>Persoane de contact:</p>
    <ul>
        <?php foreach ($persoane as $persoana): ?>
            <?php if ($persoana['firma_id'] === $firmaAleasa): ?>
                <li><?php echo $persoana['nume']; ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
 
    <p>
        <a href="14_legatura.php?firma=1">Firma 1</a> |
        <a href="14_legatura.php?firma=2">Firma 2</a>
    </p>
</body>
</html>