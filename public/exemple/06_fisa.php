<?php
// Exemplul 6 - o „fișă”: alegem UN element din listă după numărul din adresă
// Încearcă: 06_fisa.php?id=1, apoi ?id=2, apoi ?id=3
 
$angajati = [
    1 => ['nume' => 'Ana Popescu',   'functie' => 'Operator',      'oras' => 'Cluj-Napoca'],
    2 => ['nume' => 'Mihai Ionescu', 'functie' => 'Agent vânzări', 'oras' => 'București'],
    3 => ['nume' => 'Ioana Marin',   'functie' => 'Administrator', 'oras' => 'Iași'],
];
 
$id = (int) ($_GET['id'] ?? 0);
$angajat = $angajati[$id] ?? null;
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 6 - fișă</title>
</head>
<body>
    <?php if ($angajat === null): ?>
        <p>Nu există angajatul cu numărul <?php echo $id; ?>.</p>
    <?php else: ?>
        <h1><?php echo $angajat['nume']; ?></h1>
        <p>Funcția: <?php echo $angajat['functie']; ?></p>
        <p>Orașul: <?php echo $angajat['oras']; ?></p>
    <?php endif; ?>
 
    <p>
        <a href="06_fisa.php?id=1">Angajat 1</a> |
        <a href="06_fisa.php?id=2">Angajat 2</a> |
        <a href="06_fisa.php?id=3">Angajat 3</a>
    </p>
</body>
</html>
