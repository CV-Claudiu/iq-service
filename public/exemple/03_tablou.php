<?php
// Exemplul 3 - aceiași clienți, dar dintr-un tablou PHP
 
$clienti = [
    ['denumire' => 'Automatizări Industriale SRL', 'oras' => 'Cluj-Napoca'],
    ['denumire' => 'Termoplast Service SRL',       'oras' => 'București'],
    ['denumire' => 'Electro Control SA',           'oras' => 'Timișoara'],
];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 3 - tablou PHP</title>
</head>
<body>
    <h1>Clienți (generați de PHP)</h1>
 
    <table border="1" cellpadding="6">
        <tr>
            <th>Denumire</th>
            <th>Oraș</th>
        </tr>
        <?php foreach ($clienti as $client): ?>
            <tr>
                <td><?php echo $client['denumire']; ?></td>
                <td><?php echo $client['oras']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
 
    <p>Număr de clienți: <?php echo count($clienti); ?></p>
</body>
</html>
