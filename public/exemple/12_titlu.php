<?php
// Exemplul 12 - fișierul inclus folosește o variabilă stabilită înainte
 
$titlu = 'Despre firma noastră';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 12</title>
</head>
<body>
    <?php include 'parti/titlu.php'; ?>
 
    <p>Titlul de mai sus a fost scris de parti/titlu.php, dar textul l-am ales aici.</p>
</body>
</html>
