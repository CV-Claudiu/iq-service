<?php
// Exemplul 13 - includem cod PHP, nu doar HTML
 
require 'parti/functii.php';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 13</title>
</head>
<body>
    <p><?php echo salut('Ana'); ?></p>
    <p><?php echo salut('Mihai'); ?></p>
</body>
</html>
