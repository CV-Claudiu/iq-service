<?php
// Exemplul 27 - parola nu se păstrează niciodată, se păstrează amprenta ei
// Dați refresh de câteva ori și urmăriți amprenta.
 
$parola = 'Parola123!';
 
$amprenta = password_hash($parola, PASSWORD_DEFAULT);
 
$corecta  = password_verify('Parola123!', $amprenta);
$gresita  = password_verify('parola123!', $amprenta);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Exemplul 27 - parole</title>
</head>
<body>
    <p>Parola: <?php echo $parola; ?></p>
    <p>Amprenta: <code><?php echo $amprenta; ?></code></p>
    <p>„Parola123!” se potrivește? <?php echo $corecta ? 'da' : 'nu'; ?></p>
    <p>„parola123!” (cu p mic) se potrivește? <?php echo $gresita ? 'da' : 'nu'; ?></p>
</body>
</html>
