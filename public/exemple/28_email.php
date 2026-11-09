<?php
// Exemplul 28 - verificarea unei adrese de e-mail
 
$adrese = ['ana@firma.ro', 'ana@', 'ana firma.ro', 'ana.pop@iqservice.exemplu.ro', '@firma.ro'];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 28 - e-mail</title>
</head>
<body>
    <ul>
        <?php foreach ($adrese as $adresa): ?>
            <li><?php echo $adresa; ?>: <?php echo filter_var($adresa, FILTER_VALIDATE_EMAIL) ? 'corectă' : 'greșită'; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
