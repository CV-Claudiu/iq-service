<?php
// Exemplul 11 - pagina A include meniul dintr-un fișier separat
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 11 - pagina A</title>
</head>
<body>
    <?php include 'parti/meniu.php'; ?>
 
    <h1>Pagina A</h1>
    <p>Meniul de sus nu e scris aici: vine din parti/meniu.php.</p>
</body>
</html>
